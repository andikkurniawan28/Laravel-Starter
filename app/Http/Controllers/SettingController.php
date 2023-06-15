<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Globalization;

class SettingController extends Controller
{
    /**
     * Display a form to update setting.
     */
    public function index(){
        $global = Globalization::index();
        return view('setting.index', compact('global'));
    }

    /**
     * Function to handle setting update.
     */
    public function process(Request $request){
        return Setting::updateSetting($request);
    }
}
