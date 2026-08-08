<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLES = [
        'people',
        'income_transactions',
        'expense_transactions',
        'inventories',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $tableName) {
            if (! Schema::hasColumn($tableName, 'user_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('user_id')->nullable()->index();
                });
            }

            if (! Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }

        $adminId = DB::table('users')
            ->where('role', 'admin')
            ->orderBy('id')
            ->value('id') ?? DB::table('users')->orderBy('id')->value('id');

        if ($adminId) {
            DB::table('people')->whereNull('user_id')->update(['user_id' => $adminId]);
            DB::table('inventories')->whereNull('user_id')->update(['user_id' => $adminId]);

            DB::table('income_transactions')->whereNull('user_id')->update([
                'user_id' => DB::raw('COALESCE(created_by, '.(int) $adminId.')'),
            ]);
            DB::table('expense_transactions')->whereNull('user_id')->update([
                'user_id' => DB::raw('COALESCE(created_by, '.(int) $adminId.')'),
            ]);
        }

        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Intentionally irreversible: ownership and soft-delete data must be preserved.
    }
};
