<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use App\Http\Requests\CreateImageRequest;

class ImageController extends Controller
{
    protected ImageRepository $images;

    public function __construct(ImageRepository $images)
    {
        $this->images = $images;
    }

    public function index()
    {
        return response()->json($this->images->all());
    }

    public function show(Request $request, $path)
    {
        return $this->images->getImage($path, $request->all());
    }

    public function store(CreateImageRequest $request)
    {
        $image = $request->file('image');
        $img = $this->images->upload($image, $request->description);
        return response()->json($img, 201);
    }
}
