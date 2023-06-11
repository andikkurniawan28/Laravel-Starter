<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Globalization;

class SettingController extends Controller
{
    public function index(){
        $global = Globalization::index();
        return view('setting.index', compact('global'));
    }

    public function process(Request $request){
        Setting::where('name', 'app_name')->update(['value' => $request->app_name]);
        Setting::where('name', 'app_color')->update(['value' => $request->app_color]);
        Setting::where('name', 'app_font_color')->update(['value' => $request->app_font_color]);
        return redirect()->back()->with('success', 'Setting has been updated.');
    }
}
