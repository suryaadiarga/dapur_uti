<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::with('user')
            ->when($request->action, fn ($query, string $action) => $query->where('action', $action))
            ->when($request->user_id, fn ($query, string $userId) => $query->where('user_id', $userId))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $actions = ActivityLog::query()->distinct()->orderBy('action')->pluck('action');

        return view('activity-logs.index', compact('logs', 'actions'));
    }
}
