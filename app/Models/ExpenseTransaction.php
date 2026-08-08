<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseTransaction extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'belanja_bahan' => 'Belanja bahan',
        'gas' => 'Gas',
        'listrik' => 'Listrik',
        'air' => 'Air',
        'transportasi' => 'Transportasi',
        'packaging' => 'Packaging',
        'peralatan_dapur' => 'Peralatan dapur',
        'gaji' => 'Gaji',
        'operasional' => 'Operasional',
        'lain_lain' => 'Lain-lain',
    ];

    // Didefinisikan secara langsung agar tidak error jika IncomeTransaction bermasalah
    public const PAYMENT_METHODS = [
        'transfer' => 'Transfer',
        'qris' => 'QRIS',
        'tunai' => 'Tunai'
    ];

    protected $fillable = [
        'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
        'store_name', 'description', 'receipt_path', 'created_by',
    ];

    protected function casts(): array
    {
        return ['transaction_date' => 'date', 'amount' => 'decimal:2'];
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'people_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['date_from'] ?? null, fn (Builder $q, $date) => $q->whereDate('transaction_date', '>=', $date))
            ->when($filters['date_to'] ?? null, fn (Builder $q, $date) => $q->whereDate('transaction_date', '<=', $date))
            ->when($filters['category'] ?? null, fn (Builder $q, $category) => $q->where('category', $category))
            ->when($filters['person_id'] ?? null, fn (Builder $q, $person) => $q->where('people_id', $person))
            ->when($filters['store_name'] ?? null, fn (Builder $q, $store) => $q->where('store_name', 'like', "%{$store}%"))
            ->when($filters['search'] ?? null, function (Builder $q, $search) {
                $q->where(function (Builder $nested) use ($search) {
                    $nested->where('description', 'like', "%{$search}%")
                        ->orWhere('store_name', 'like', "%{$search}%")
                        ->orWhereHas('person', fn (Builder $person) => $person->where('name', 'like', "%{$search}%"));
                });
            });
    }
}