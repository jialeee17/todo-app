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

            if (!$activityLog) {
                throw new Exception('Activity Log Not Found');
            }

            return response()->json([
                'Success' => true,
                'data' => $activityLog,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => $e->getMessage()
            ], 500);
        }
    }
}
