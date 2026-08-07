<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['business_name', 'business_address', 'whatsapp_number', 'logo_path', 'currency'];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'business_name' => 'Dapur Uti',
            'currency' => 'IDR',
        ]);
    }
}
