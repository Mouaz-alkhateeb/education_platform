<?php

namespace App\Http\Trait;

use Illuminate\Support\Str;

trait UploadImage
{
    public function uploadUserAttachment($file)
    {
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $path = 'images/' . $filename;
        return $path;
    }
}
