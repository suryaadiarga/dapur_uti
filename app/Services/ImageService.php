<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ImageService
{
    /**
     * Memproses, mengompres, dan menyimpan gambar.
     *
     * @param UploadedFile $file File gambar dari request
     * @param string $folderPath Nama folder tujuan di storage/app/public (contoh: 'salary-proofs' atau 'uploads/foto')
     * @return string Path gambar yang berhasil disimpan untuk dimasukkan ke database
     */
    public function uploadAndCompress(UploadedFile $file, string $folderPath = 'uploads'): string
    {
        // 1. Trik Bypass Windows: Simpan file dari Temp ke Storage sementara
        $tempPath = $file->store($folderPath . '/temp', 'public');
        
        // Dapatkan path absolut dari file sementara
        $absoluteTempPath = Storage::disk('public')->path($tempPath);

        // 2. Tentukan nama file akhir dan path absolut tujuan
        $filename = $folderPath . '/' . time() . '_' . uniqid() . '.jpg';
        $absoluteFinalPath = Storage::disk('public')->path($filename);

        // 3. Baca gambar yang sudah aman di folder Storage
        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->decodePath($absoluteTempPath);

        // 4. Ubah ukuran (maksimal lebar 1000px, tinggi otomatis proporsional)
        $image->scale(width: 1000);

        // 5. Encode ke format JPEG dengan kualitas 75% agar ringan
        $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 75);

        // 6. Simpan hasil kompresi ke tujuan akhir
        $encoded->save($absoluteFinalPath);

        // 7. Hapus file mentah di folder temp agar penyimpanan tidak penuh
        Storage::disk('public')->delete($tempPath);

        // 8. Kembalikan nama file beserta foldernya untuk disimpan ke DB
        return $filename;
    }
}