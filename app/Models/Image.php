<?php

namespace App\Models;

use App\Services\ImagePathGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected $hidden = [
        'imageable_id',
        'imageable_type',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
        });
    }

    // public function format()
    // {
    //     return [
    //         "id" => $this->id,
    //         "description" => $this->description,
    //         "name" => $this->name,
    //         // "url" => url('images/' . $this->name),
    //         "url" => url(image($this->name)),
    //         "updated_at" => $this->updated_at,
    //         "created_at" => $this->created_at,
    //     ];
    // }
}
