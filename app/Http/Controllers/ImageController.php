<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use App\Http\Requests\CreateImageRequest;
use App\Jobs\ResizeImage;

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
    
    public function storeResize(Request $request)
    {
        $file = $request->file('file');
        $image = $file->move(public_path("uploads/{$file->getBasename()}", $file->getClientOriginalExtension()));
        $formats = [150, 500, 1000, 1200, 1400];
        echo $image->getBasename();
        $this->dispatch(new ResizeImage($image, $formats));
        return view('file');
    }
}
