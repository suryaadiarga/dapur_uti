<?php

namespace App\Models;

use App\Models\Concerns\OwnedByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, OwnedByUser, SoftDeletes;

    public const ROLES = [
        'pemilik' => 'Pemilik',
        'staff' => 'Staff',
        'keluarga' => 'Keluarga',
        'kurir' => 'Kurir',
        'lainnya' => 'Lainnya',
    ];

    protected $fillable = ['name', 'phone', 'role', 'notes', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incomeTransactions(): HasMany
    {
        return $this->hasMany(IncomeTransaction::class, 'people_id');
    }

    public function expenseTransactions(): HasMany
    {
        return $this->hasMany(ExpenseTransaction::class, 'people_id');
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'people_id');
    }
}
