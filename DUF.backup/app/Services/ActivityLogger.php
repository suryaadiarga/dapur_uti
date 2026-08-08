<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

class ActivityLogger
{
    private const SENSITIVE_KEYS = [
        'password',
        'password_confirmation',
        'current_password',
        'remember_token',
        'token',
    ];

    public static function log(
        string $action,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
    ): void {
        try {
            $request = request();
            $user = auth()->user();

            ActivityLog::create([
                'user_id' => $user?->id,
                'role' => $user?->role,
                'action' => $action,
                'model_type' => $model ? class_basename($model) : null,
                'model_id' => $model?->getKey(),
                'description' => $description,
                'old_values' => self::sanitize($oldValues),
                'new_values' => self::sanitize($newValues),
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
            ]);
        } catch (Throwable $exception) {
            Log::warning('Activity log could not be written.', [
                'action' => $action,
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    private static function sanitize(?array $values): ?array
    {
        if ($values === null) {
            return null;
        }

        return Arr::except($values, self::SENSITIVE_KEYS);
    }
}
