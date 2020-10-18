<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Filesystem\Filesystem;

class DocumentRepository
{
	protected Document $document;

	public function __construct(Document $document)
	{
		$this->document = $document;
	}

	public function all()
	{
		return $this->document->all();
	}

	public function upload($doc, string $description = "")
	{
		$filename = time() . '.' . $doc->getClientOriginalExtension();
		//$doc->storeAs('docs', $filename, 'public');
		$doc->storeAs('docs', $filename);
		$this->document->description = $description;
		$this->document->name =  $filename;
		$this->document->url =  url('documents/' . $filename);
		$this->document->save();
		return $this->document;
	}

	public function download(string $filename)
	{
		if (!$doc = $this->document->where('name', $filename)->first()) {
			return response("file not found", 404);
		}
		return storage_path('app/docs/' . $doc->name);
	}
}
