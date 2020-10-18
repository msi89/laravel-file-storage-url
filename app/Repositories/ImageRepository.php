<?php

namespace App\Repositories;

use App\Models\Image;
use Illuminate\Http\Request;
use League\Glide\Server;
use League\Glide\Signatures\Signature;

class ImageRepository
{
	private Image $image;
	private Server $server;
	private Signature $signature;

	public function __construct(Image $image,  Server $server,  Signature $signature)
	{
		$this->image = $image;
		$this->server = $server;
		$this->signature = $signature;
	}

	public function all()
	{
		// return $this->image->all()->map->format();
		return $this->image->all();
	}

	public function upload($image, string $description = "")
	{
		$filename = time() . '.' . strtolower($image->getClientOriginalExtension());
		$image->storeAs('images', $filename);
		$this->image->description = $description;
		$this->image->name =  $filename;
		$this->image->url = url('images/' . $filename);
		$this->image->save();
		return $this->image;
	}

	public function download(string $filename)
	{
		if (!$img = $this->image->where('name', $filename)->first()) {
			return response("file not found", 404);
		}
		return storage_path('app/public/images/' . $img->name);
	}

	public function getImage(string $image, array $params = [])
	{
		//$this->signature->validateRequest('images/' . $image, $params);
		return $this->server->getImageResponse($image, $params);
	}
}
