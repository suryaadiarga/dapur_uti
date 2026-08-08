<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attendance extends Model
{
    use HasFactory;

    public const STATUSES = [
        'hadir' => 'Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'alpa' => 'Alpa',
    ];

    protected $fillable = [
        'attendance_date',
        'people_id',
        'status',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
        ];
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'people_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function salary(): HasOne
    {
        return $this->hasOne(Salary::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['date'] ?? null, fn (Builder $q, $date) => $q->whereDate('attendance_date', $date))
            ->when($filters['person_id'] ?? null, fn (Builder $q, $person) => $q->where('people_id', $person))
            ->when($filters['status'] ?? null, fn (Builder $q, $status) => $q->where('status', $status));
    }
}