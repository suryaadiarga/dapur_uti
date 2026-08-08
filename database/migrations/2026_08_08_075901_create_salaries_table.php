<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('attendances')->onDelete('cascade');
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->date('salary_date');
            $table->decimal('amount', 12, 2);
            $table->string('proof_photo')->nullable(); // Foto bukti pembayaran/penyerahan gaji
            $table->text('signature')->nullable(); // Tanda tangan digital (Base64 / File)
            $table->enum('status', ['pending', 'paid'])->default('paid');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};