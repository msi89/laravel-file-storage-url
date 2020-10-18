<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'documentable_id',
        'documentable_type',
    ];

    public function format()
    {
        return [
            "id" => $this->id,
            "description" => $this->description,
            "name" => $this->name,
            "url" => url('documents/' . $this->name),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
