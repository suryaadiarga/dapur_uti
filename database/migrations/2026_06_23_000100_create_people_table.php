<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30)->nullable();
            $table->string('role', 30);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['role', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
