<?php

namespace App\Models;

use App\Models\Concerns\OwnedByUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, OwnedByUser, SoftDeletes;

    public const CATEGORIES = [
        'alat_masak' => 'Alat masak',
        'alat_makan' => 'Alat makan',
        'elektronik' => 'Elektronik',
        'meja_kursi' => 'Meja/kursi',
        'peralatan_packing' => 'Peralatan packing',
        'lain_lain' => 'Lain-lain',
    ];

    public const CONDITIONS = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak ringan',
        'rusak_berat' => 'Rusak berat',
        'hilang' => 'Hilang',
    ];

    protected $fillable = [
        'name', 'category', 'purchase_date', 'purchase_price', 'quantity',
        'condition', 'location', 'people_id', 'photo_path', 'description', 'user_id',
    ];

    protected function casts(): array
    {
        return ['purchase_date' => 'date', 'purchase_price' => 'decimal:2', 'quantity' => 'integer'];
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'people_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalValueAttribute(): float
    {
        return (float) $this->purchase_price * $this->quantity;
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['category'] ?? null, fn (Builder $q, $category) => $q->where('category', $category))
            ->when($filters['condition'] ?? null, fn (Builder $q, $condition) => $q->where('condition', $condition))
            ->when($filters['person_id'] ?? null, fn (Builder $q, $person) => $q->where('people_id', $person))
            ->when($filters['search'] ?? null, fn (Builder $q, $search) => $q->where('name', 'like', "%{$search}%"));
    }
}
