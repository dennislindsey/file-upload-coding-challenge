<?php

namespace App\Http\Controllers;

use App\StoredFile;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return response()->json(StoredFile::all()->toArray());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        /** @var StoredFile $storedFile */
        $storedFile = StoredFile::create(['filename' => $request->input('fileName')]);

        return response()->json($storedFile->toArray());
    }

    /**
     * @param Request    $request
     * @param StoredFile $storedFile
     * @return Response
     */
    public function update(Request $request, StoredFile $storedFile): Response
    {
        $storedFile->appendToFile(base64_decode($request->input('chunk')));

        if ($request->input('endOfFile')) {
            $storedFile->update(['upload_completed' => true]);
        }

        return response()->json($storedFile->toArray());
    }

    /**
     * @param StoredFile $storedFile
     * @return Response
     */
    public function destroy(StoredFile $storedFile): Response
    {
        $storedFile->deleteFile();
        $storedFile->delete();

        return response()->json(['deleted' => true]);
    }
}
