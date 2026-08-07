<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->foreignId('people_id')->constrained('people')->restrictOnDelete();
            $table->string('category', 50);
            $table->decimal('amount', 15, 2);
            $table->string('payment_method', 30);
            $table->string('store_name')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['transaction_date', 'category']);
            $table->index(['people_id', 'transaction_date']);
            $table->index('store_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_transactions');
    }
};
