<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\Globalization;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity log.
     */
    public function index(){
        $global = Globalization::index();
        $activity_log = ActivityLog::latest()->paginate(1000);
        return view("activity_log.index", compact("global", "activity_log"));
    }
}
