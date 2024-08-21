<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    public function saveImage(UploadedFile $image)
    {
        $path = Storage::put('images', $image);

        return Image::create(['path' => $path]);
    }
}
