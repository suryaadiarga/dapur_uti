<?php

namespace App\Services;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ImageService
{
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            $filename = time() . '_' . uniqid() . '.jpg';
            $destinationPath = public_path('/uploads/foto');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // 1. Buat manager dengan Driver GD
            $manager = ImageManager::usingDriver(Driver::class);

            // 2. Baca file gambar dari path-nya
            $image = $manager->decodePath($file->getRealPath());

            // 3. Ubah ukuran (misal berdasarkan lebar 1000px atau tinggi 300px)
            $image->scale(width: 1000);

            // 4. Encode ke format JPEG dengan kualitas 75 agar ringan & stabil
            $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 75);

            // 5. Simpan ke folder tujuan
            $encoded->save($destinationPath . '/' . $filename);

            // Simpan nama file ($filename) ke database...
        }
    }
}