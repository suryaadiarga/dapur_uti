<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;

    public const ROLES = [
        'admin' => 'Administrator',
        'pemilik' => 'Pemilik',
        'staff' => 'Staff',
        'keluarga' => 'Keluarga',
        'kurir' => 'Kurir',
        'lainnya' => 'Lainnya',
    ];

    protected $fillable = ['name', 'phone', 'role', 'notes'];

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
