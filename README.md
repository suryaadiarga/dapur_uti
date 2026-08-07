# Dapur Uti Finance

Dapur Uti Finance adalah aplikasi web pencatatan keuangan sederhana untuk usaha katering rumahan Dapur Uti. Aplikasi berfokus pada uang masuk, uang keluar, nota belanja, orang yang terlibat, inventaris/peralatan, buku kas, dan laporan.

## Teknologi

- Laravel 11
- Laravel Breeze (Blade)
- Tailwind CSS
- MySQL
- DomPDF untuk export PDF
- Laravel Excel untuk export Excel

## Fitur

- Login dan logout admin
- Dashboard ringkasan bulanan, saldo kas, inventaris, transaksi terbaru, dan grafik 6 bulan
- CRUD data orang
- CRUD uang masuk dengan filter, pencarian, dan upload bukti
- CRUD uang keluar dengan filter, pencarian, dan upload nota
- Galeri nota belanja dengan preview dan download
- CRUD inventaris dengan filter dan perhitungan total nilai
- Buku kas dengan debit, kredit, dan saldo berjalan
- Laporan uang masuk, uang keluar, kas, nota, dan inventaris
- Filter laporan hari ini, minggu ini, bulan ini, tahun ini, dan rentang custom
- Export laporan PDF dan Excel
- Pengaturan identitas usaha dan logo
- Tampilan responsif untuk laptop dan ponsel

## Persyaratan

- PHP 8.2–8.4
- Composer
- Node.js 20.19+ atau 22.12+ dan npm
- MySQL 8+ atau MariaDB yang kompatibel
- Ekstensi PHP: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, dan `zip`

## Instalasi

Jalankan:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Pada Windows PowerShell, pengganti perintah `cp`:

```powershell
Copy-Item .env.example .env
```

## Pengaturan database

Gunakan database MySQL yang sudah tersedia dengan nama `dapur_uti_finance`. Jangan membuat database lain.

Pastikan bagian berikut di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dapur_uti_finance
DB_USERNAME=root
DB_PASSWORD=
```

Jika instalasi MySQL menggunakan username atau password berbeda, sesuaikan hanya nilai `DB_USERNAME` dan `DB_PASSWORD`. Jangan mengubah `DB_DATABASE`.

Jalankan migration dan seeder ke database `dapur_uti_finance`:

```bash
php artisan migrate --seed
```

Kemudian buat storage link:

```bash
php artisan storage:link
```

## Menjalankan aplikasi

Buka dua terminal.

Terminal pertama:

```bash
npm run dev
```

Terminal kedua:

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000`.

Untuk build aset produksi:

```bash
npm run build
```

## Akun login default

- Email: `admin@dapuruti.test`
- Password: `password`

Ganti password default sebelum aplikasi dipakai pada lingkungan produksi.

## Upload file

Foto bukti, nota, inventaris, dan logo disimpan pada disk `public` Laravel di `storage/app/public`. Perintah `php artisan storage:link` wajib dijalankan agar file dapat dibuka melalui aplikasi.

Format file yang diterima: JPG, JPEG, PNG, dan WEBP dengan ukuran maksimal 2 MB.

## Catatan keamanan

Aplikasi ini menggunakan Laravel 11 sesuai spesifikasi. Pada Juni 2026 cabang Laravel 11 telah memiliki advisory keamanan upstream yang tidak menyediakan rilis perbaikan pada cabang 11. Untuk penggunaan publik/produksi, rencanakan upgrade ke Laravel 12 atau versi yang masih menerima pembaruan keamanan.
