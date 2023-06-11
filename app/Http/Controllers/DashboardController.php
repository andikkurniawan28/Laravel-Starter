<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Globalization;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $global = Globalization::index();
        return view('dashboard.index', compact('global'));
    }
}
