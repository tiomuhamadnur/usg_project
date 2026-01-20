<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadService
{
    protected $manager;

    public function __construct()
    {
        // Pilih driver GD (bisa ganti ke Imagick jika ada)
        // $this->manager = new ImageManager(new Driver());
        $this->manager = ImageManager::imagick();
    }

    /**
     * Upload + Resize + Compress Image.
     *
     * @param $file
     * @param string $path          Folder penyimpanan
     * @param int|null $width       Target width (optional)
     * @param int|null $height      Target height (optional)
     * @param int $quality          Quality JPG (1–100)
     * @return string|null
     */
    public function uploadImage($file, $path, $width = null, $height = 300, $quality = 50)
    {
        if (!$file) return null;

        // Unique filename
        $fileName = time() . '-' . $file->getClientOriginalName();
        $storagePath = public_path("storage/" . $path);

        // Buat folder jika belum ada
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Load image
        $image = $this->manager->read($file->getRealPath());

        // Resize only if provided
        if ($width || $height) {
            $image = $image->scale($width, $height); // v3 method
        }

        // Save with compression
        $image->toJpeg($quality)->save($storagePath . $fileName);

        return $path . $fileName;
    }
}
