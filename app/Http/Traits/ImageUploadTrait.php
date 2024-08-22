<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    /**
     * Store the image and return the filename.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    public function storeImage(UploadedFile $file, $folder = '')
    {
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

        $filePath =  Storage::disk('public')->putFileAs($folder, $file, $filename);

        return $filePath;
    }

    /**
     * Delete the image.
     *
     * @param string $filename
     * @param string $folder
     * @return void
     */
    public function deleteImage($filename, $folder = 'images')
    {
        Storage::disk('public')->delete($folder . '/' . $filename);
    }

    public function getImageUrl($filename, $folder)
    {
        return asset('storage/' . $folder . '/' . $filename);
    }
}
