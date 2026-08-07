<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('attendance_date');
            $table->foreignId('people_id')->constrained('people')->cascadeOnDelete();
            $table->string('status', 30)->default('hadir'); // hadir, izin, sakit, alpa
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['attendance_date', 'people_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};