<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeTransaction extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'modal_pemilik' => 'Modal pemilik',
        'pembayaran_pelanggan' => 'Pembayaran pelanggan',
        'tambahan_kas' => 'Tambahan kas',
        'pengembalian_uang' => 'Pengembalian uang',
        'lain_lain' => 'Lain-lain',
    ];

    public const PAYMENT_METHODS = [
        'tunai' => 'Tunai',
        'transfer' => 'Transfer',
        'qris' => 'QRIS',
        'lain_lain' => 'Lain-lain',
    ];

    protected $fillable = [
        'transaction_date', 'people_id', 'category', 'amount',
        'payment_method', 'description', 'proof_path', 'created_by',
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
            ->when($filters['search'] ?? null, function (Builder $q, $search) {
                $q->where(function (Builder $nested) use ($search) {
                    $nested->where('description', 'like', "%{$search}%")
                        ->orWhereHas('person', fn (Builder $person) => $person->where('name', 'like', "%{$search}%"));
                });
            });
    }
}
