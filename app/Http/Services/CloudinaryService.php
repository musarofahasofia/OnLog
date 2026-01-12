<?php
namespace App\Http\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CloudinaryService
{
    public static function uploadImage(
        UploadedFile $file,
        $rootFolder = 'User', $idFolder = '1', $folder = 'photo-profile'
    ) {
        $folderPath = "{$rootFolder}/{$idFolder}/{$folder}";

        $uploadedFile = Cloudinary::uploadApi()->upload($file->getRealPath(), [
            'folder' => $folderPath,
        ]);

        return [
            'url' => $uploadedFile['secure_url'],
            'public_id' => $uploadedFile['public_id'],
        ];
    }
}
