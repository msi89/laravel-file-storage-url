<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Requests\CreateDocumentRequest;
use App\Repositories\DocumentRepository;

class DocumentController extends Controller
{
    protected DocumentRepository $documents;

    public function __construct(DocumentRepository $documents)
    {
        $this->documents = $documents;
    }
    public function index()
    {
        return response()->json($this->documents->all());
    }

    public function show(string $path)
    {
        $doc = $this->documents->download($path);
        return response()->download($doc);
    }

    public function store(CreateDocumentRequest $request)
    {
        $file = $request->file('file');
        $document = $this->documents->upload($file, $request->comment);
        return response()->json($document, 201);
    }
}
