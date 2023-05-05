<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('ActivityLogs/Index');
    }
}
