<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@dapuruti.my.id'], [
            'name' => 'Admin Dapur Uti',
            'password' => 'zxcvbnm123',
            'email_verified_at' => now(),
        ]);

        Person::firstOrCreate(['name' => 'Uti'], [
            'role' => 'pemilik',
            'notes' => 'Pemilik Dapur Uti',
        ]);

        Setting::firstOrCreate([], [
            'business_name' => 'Dapur Uti',
            'business_address' => 
                'Mojokemuning RT003/RW001, Sidomojo, Krian, Sidoarjo, 61262',
            'whatsapp_number' => '6285852759459',
            'currency' => 'IDR',
        ]);
    }
}
