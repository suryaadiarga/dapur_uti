<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait OwnedByUser
{
    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        return $user->isAdmin()
            ? $query
            : $query->where($query->qualifyColumn('user_id'), $user->id);
    }

    public function isVisibleTo(User $user): bool
    {
        return $user->isAdmin() || (int) $this->user_id === (int) $user->id;
    }
}
