<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\ToDos;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ActivityLog/Index');
    }

    public function getActivityLogData(Request $request)
    {
        $userId = $request->userId;
        $todoId = $request->todoId;
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.

        // Get the total number of records, regardless of pagination or filtering.
        $activityLogNotFiltered = ActivityLog::count();

        $activityLog = ActivityLog::with('user')
                                ->where('user_id', $userId)
                                ->when($todoId, function ($query, $todoId) {
                                    return $query->where('todo_id', $todoId);
                                })
                                ->orderBy('created_at', 'desc')
                                ->paginate($limit, ['*'], 'page', $page);

        $result = [
            'total' => $activityLog->total(),
            'totalNotFiltered' => $activityLogNotFiltered,
            'rows' => $activityLog->items(),
        ];

        return response()->json([
            'success' => true,
            'data' => $result,
        ], 200);
    }
}
