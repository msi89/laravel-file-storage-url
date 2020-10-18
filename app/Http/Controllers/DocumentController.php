<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateDocumentRequest;

class DocumentController extends Controller
{
    public function index()
    {
        return response()->json(Document::all());
    }

    public function show(int $id)
    {
        return response()->json(Document::findOrFail($id));
    }

    public function store(CreateDocumentRequest $request)
    {

        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('docs', $filename, 'public');
        //store your file into database
        $document = new Document();
        $document->name = $request->name;
        $document->url = url(Storage::url($path));
        $document->save();

        return response()->json($document, 201);
    }
}
