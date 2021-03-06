<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileIndexRequest;
use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\StoredFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * @param FileIndexRequest $request
     * @return Response
     */
    public function index(FileIndexRequest $request): Response
    {
        /** @var Collection $files */
        $files = StoredFile::query()
            ->when($request->input('search'), function (Builder $builder) use ($request) {
                $builder->where('filename_orig', 'LIKE', "%{$request->input('search')}%");
            })
            ->when($request->input('type'), function (Builder $builder) use ($request) {
                $builder->where('type', 'LIKE', "%{$request->input('type')}%");
            })
            ->get();

        return response()->json($files->toArray());
    }

    /**
     * @param FileStoreRequest $request
     * @return Response
     */
    public function store(FileStoreRequest $request): Response
    {
        $ext = explode('.', $request->input('fileName'));
        $ext = end($ext);

        /** @var StoredFile $storedFile */
        $storedFile = StoredFile::create([
            'filename_orig' => $request->input('fileName'),
            'filename'      => Uuid::uuid4() . '.' . $ext,
            'type'          => $request->input('type')
        ]);

        return response()->json($storedFile->toArray());
    }

    /**
     * @param FileUpdateRequest $request
     * @param StoredFile        $storedFile
     * @return Response
     */
    public function update(FileUpdateRequest $request, StoredFile $storedFile): Response
    {
        $storedFile->appendToFile(base64_decode($request->input('chunk')));

        if ($request->input('endOfFile')) {
            $storedFile->update(['upload_completed' => true]);
        } else {
            $storedFile->touch();
        }

        return response()->json($storedFile->toArray());
    }

    /**
     * @param StoredFile $storedFile
     * @return Response
     */
    public function destroy(StoredFile $storedFile): Response
    {
        $storedFile->delete();

        return response()->json(['deleted' => true]);
    }
}
