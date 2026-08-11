<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\ExpenseTransaction;
use App\Models\IncomeTransaction;
use App\Models\Inventory;
use App\Models\Person;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. SEED USERS
        echo "Seeding Users...\n";
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Admin Dapur Uti',
            'email' => 'admin@dapuruti.my.id',
            'password' => Hash::make('zxcvbnm123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $userId = DB::table('users')->first()->id;

        // 2. SEED PEOPLE (50 data sesuai model)
        echo "Seeding People...\n";
        DB::table('people')->truncate();
        $roleKeys = array_keys(Person::ROLES);
        for ($i = 1; $i <= 50; $i++) {
            DB::table('people')->insert([
                'name' => 'Person ' . $i,
                'phone' => '0812345678' . $i,
                'role' => $roleKeys[array_rand($roleKeys)],
                'created_at' => now(),
            ]);
        }
        $peopleIds = DB::table('people')->pluck('id')->toArray();

        // 3. SEED INVENTORIES (200 data sesuai model)
        echo "Seeding Inventories...\n";
        DB::table('inventories')->truncate();
        $catKeys = array_keys(Inventory::CATEGORIES);
        $condKeys = array_keys(Inventory::CONDITIONS);
        
        $chunk = [];
        for ($i = 1; $i <= 200; $i++) {
            $chunk[] = [
                'name' => 'Barang ' . $i,
                'category' => $catKeys[array_rand($catKeys)],
                'purchase_date' => now()->subDays(rand(1, 365)),
                'purchase_price' => rand(10000, 500000),
                'quantity' => rand(1, 10),
                'condition' => $condKeys[array_rand($condKeys)],
                'people_id' => $peopleIds[array_rand($peopleIds)],
                'created_at' => now(),
            ];
        }
        DB::table('inventories')->insert($chunk);

        // 4. SEED TRANSACTIONS & OTHERS (Masing-masing 33.333 data agar mendekati total skala besar)
        $expenseCats = array_keys(ExpenseTransaction::CATEGORIES);
        $incomeCats = array_keys(IncomeTransaction::CATEGORIES);
        $paymentMethods = array_keys(ExpenseTransaction::PAYMENT_METHODS);

        $this->seedIncomeTransactions($peopleIds, $incomeCats, $paymentMethods, $userId, 33333);
        $this->seedExpenseTransactions($peopleIds, $expenseCats, $paymentMethods, $userId, 33333);
        $this->seedAttendances($peopleIds, $userId, 33334);
        $this->seedMealSchedules($userId, 33333);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        echo "Seeding lengkap selesai!\n";
    }

    private function seedIncomeTransactions($peopleIds, $cats, $methods, $userId, $count)
    {
        echo "Seeding income_transactions ($count rows)...\n";
        DB::table('income_transactions')->truncate();
        $chunk = [];
        for ($i = 1; $i <= $count; $i++) {
            $chunk[] = [
                'transaction_date' => now()->subDays(rand(0, 365)),
                'people_id' => $peopleIds[array_rand($peopleIds)],
                'category' => $cats[array_rand($cats)],
                'amount' => rand(50000, 2000000),
                'payment_method' => $methods[array_rand($methods)],
                'description' => 'Pemasukan ' . $i,
                'created_by' => $userId,
                'created_at' => now(),
            ];

            if (count($chunk) >= 500) {
                DB::table('income_transactions')->insert($chunk);
                $chunk = [];
            }
        }
        if (!empty($chunk)) DB::table('income_transactions')->insert($chunk);
    }

    private function seedExpenseTransactions($peopleIds, $cats, $methods, $userId, $count)
    {
        echo "Seeding expense_transactions ($count rows)...\n";
        DB::table('expense_transactions')->truncate();
        $chunk = [];
        for ($i = 1; $i <= $count; $i++) {
            $chunk[] = [
                'transaction_date' => now()->subDays(rand(0, 365)),
                'people_id' => $peopleIds[array_rand($peopleIds)],
                'category' => $cats[array_rand($cats)],
                'amount' => rand(20000, 1000000),
                'payment_method' => $methods[array_rand($methods)],
                'store_name' => 'Toko ' . rand(1, 10),
                'description' => 'Pengeluaran ' . $i,
                'created_by' => $userId,
                'created_at' => now(),
            ];

            if (count($chunk) >= 500) {
                DB::table('expense_transactions')->insert($chunk);
                $chunk = [];
            }
        }
        if (!empty($chunk)) DB::table('expense_transactions')->insert($chunk);
    }

    private function seedAttendances($peopleIds, $userId, $count)
    {
        echo "Seeding attendances ($count rows)...\n";
        DB::table('attendances')->truncate();
        $statuses = ['hadir', 'izin', 'sakit', 'alpa'];
        $chunk = [];
        for ($i = 1; $i <= $count; $i++) {
            $chunk[] = [
                'attendance_date' => now()->subDays(rand(0, 365)),
                'people_id' => $peopleIds[array_rand($peopleIds)],
                'status' => $statuses[array_rand($statuses)],
                'notes' => 'Catatan absensi ke-' . $i,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($chunk) >= 500) {
                DB::table('attendances')->insert($chunk);
                $chunk = [];
            }
        }
        if (!empty($chunk)) DB::table('attendances')->insert($chunk);
    }

    private function seedMealSchedules($userId, $count)
    {
        echo "Seeding meal_schedules ($count rows)...\n";
        DB::table('meal_schedules')->truncate();
        $menus = [
            'Ayam Goreng, Tempe, Sayur Asem', 
            'Rendang Sapi, Perkedel, Cah Kangkung', 
            'Sate Ayam, Kerupuk, Sup Bakso',
            'Ikan Lele Goreng, Tahu, Sayur Lodeh'
        ];
        $chunk = [];
        for ($i = 1; $i <= $count; $i++) {
            $portion = rand(50, 400);
            $chunk[] = [
                'schedule_date' => now()->subDays(rand(0, 365)),
                'shift' => rand(1, 3),
                'menu_items' => $menus[array_rand($menus)],
                'portion_count' => $portion,
                'estimated_cost' => $portion * rand(12000, 20000),
                'notes' => 'Jadwal katering harian',
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($chunk) >= 500) {
                DB::table('meal_schedules')->insert($chunk);
                $chunk = [];
            }
        }
        if (!empty($chunk)) DB::table('meal_schedules')->insert($chunk);
    }
}