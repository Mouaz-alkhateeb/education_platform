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
    public function uploadSectionAttachment($file)
    {
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('sections'), $filename);
        $path = 'sections/' . $filename;
        return $path;
    }
    public function uploadCourseAttachment($file)
    {
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('courses'), $filename);
        $path = 'courses/' . $filename;
        return $path;
    }
}
