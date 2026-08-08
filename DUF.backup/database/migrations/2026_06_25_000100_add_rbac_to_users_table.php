<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique()->after('name');
            });
        }

        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 20)->default('staff')->index()->after('email');
            });
        }

        DB::table('users')
            ->whereNull('role')
            ->orWhereNotIn('role', ['admin', 'staff'])
            ->update(['role' => 'staff']);

        DB::table('users')
            ->whereNull('username')
            ->orderBy('id')
            ->each(function (object $user): void {
                $source = Str::before((string) $user->email, '@') ?: (string) $user->name;
                $base = Str::slug($source, '_') ?: 'user_'.$user->id;
                $username = $base;
                $suffix = 1;

                while (DB::table('users')->where('username', $username)->exists()) {
                    $username = $base.'_'.$suffix++;
                }

                DB::table('users')->where('id', $user->id)->update(['username' => $username]);
            });

        $primaryAdminId = DB::table('users')->orderBy('id')->value('id');

        if ($primaryAdminId) {
            DB::table('users')->where('id', $primaryAdminId)->update(['role' => 'admin']);
        }
    }

    public function down(): void
    {
        // Intentionally irreversible: this production migration is additive only.
    }
};
