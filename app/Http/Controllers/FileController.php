<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $file = 'uploads/' . $request->input('fileID') . '-' . $request->input('fileName');
        \Storage::append($file, base64_decode($request->input('chunk')), '');

        return response()->json([
            'finished' => $request->input('endOfFile', false),
            'url'      => \Storage::url($file),
        ]);
    }
}
