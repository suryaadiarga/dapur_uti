<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealSchedule extends Model
{
    use HasFactory;

    public const SHIFTS = [
        1 => 'Shift 1',
        2 => 'Shift 2',
        3 => 'Shift 3',
    ];

    protected $fillable = [
        'schedule_date',
        'shift',
        'menu_items',
        'portion_count',
        'estimated_cost',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'schedule_date' => 'date',
            'portion_count' => 'integer',
            'estimated_cost' => 'decimal:2',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['month'] ?? null, fn (Builder $q, $month) => $q->whereMonth('schedule_date', $month))
            ->when($filters['year'] ?? null, fn (Builder $q, $year) => $q->whereYear('schedule_date', $year))
            ->when($filters['shift'] ?? null, fn (Builder $q, $shift) => $q->where('shift', $shift))
            ->when($filters['search'] ?? null, fn (Builder $q, $search) => $q->where('menu_items', 'like', "%{$search}%"));
    }
}