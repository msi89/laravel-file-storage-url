<?php 
namespace App\Repositories;

use App\Models\Note;

class NoteRepository
{
	protected Note $note;

	public function __construct(Note $note)
	{
		$this->note = $note;
	}

}
