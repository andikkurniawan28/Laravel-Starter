<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a form to update setting.
     */
    public function index(){
        return Setting::showSettingForm();
    }

    /**
     * Function to handle setting update.
     */
    public function process(Request $request){
        return Setting::updateSetting($request);
    }
}
