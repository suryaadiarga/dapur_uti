<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('schedule_date');
            $table->unsignedTinyInteger('shift')->default(1); // 1, 2, 3
            $table->text('menu_items'); // contoh: ayam goreng, tempe goreng, sayuran, sambal, krupuk
            $table->unsignedInteger('portion_count')->default(0); // 1 - 500+ porsi
            $table->decimal('estimated_cost', 15, 2)->nullable(); // Opsional untuk biaya operasional/bahan
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['schedule_date', 'shift']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_schedules');
    }
};