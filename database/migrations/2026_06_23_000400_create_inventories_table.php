<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category', 50);
            $table->date('purchase_date');
            $table->decimal('purchase_price', 15, 2);
            $table->unsignedInteger('quantity')->default(1);
            $table->string('condition', 30);
            $table->string('location')->nullable();
            $table->foreignId('people_id')->constrained('people')->restrictOnDelete();
            $table->string('photo_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['category', 'condition']);
            $table->index('people_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
