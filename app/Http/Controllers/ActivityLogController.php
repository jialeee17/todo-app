<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ActivityLog/Index');
    }

    public function getActivityLogData(Request $request)
    {
        try {
            $activityLog = ActivityLog::with('user')->get();

            return response()->json([
                'success' => true,
                'data' => $activityLog,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
