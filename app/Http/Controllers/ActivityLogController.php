<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ActivityLog/Index', [
            'userId' => Auth::id()
        ]);
    }

    public function getActivityLogData(Request $request)
    {
        try {
            $userId = $request->userId;
            $offset = $request->offset;
            $limit = $request->limit;
            // The page number to use as the starting point for pagination.
            $page = $offset == 0 ? 1 : ($offset / $limit) + 1;

            // Get the total number of records, regardless of pagination or filtering.
            $activityLogNotFiltered = ActivityLog::count();

            $activityLog = ActivityLog::with('user')
                                    ->where('user_id', $userId)
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
