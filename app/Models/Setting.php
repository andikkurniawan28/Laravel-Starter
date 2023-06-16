<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\ActivityLog;
use App\Models\Documentation;
use App\Models\Globalization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * Model name.
     */
    protected const _model_name = "Setting";

    /**
     * Function to show setting form.
     */
    public static function showSettingForm(){
        $global = Globalization::index();
        $menu_id = Menu::where("name", self::_model_name)->get()->last()->id ?? NULL;
        $description = Documentation::where("menu_id", $menu_id)->get();
        return view("setting.index", compact("global", "description"));
    }

    /**
     * Function to perform update record on setting table.
     */
    public static function updateSetting($request){
        self::where("name", "app_name")->update(["value" => $request->app_name]);
        self::where("name", "app_color")->update(["value" => $request->app_color]);
        self::where("name", "app_font_color")->update(["value" => $request->app_font_color]);
        if($request->has("app_logo")){
            self::uploadLogo($request);
        }
        if($request->has("app_icon")){
            self::uploadIcon($request);
        }
        $change = self::checkModification($request);
        ActivityLog::writeLog(["description" => Auth()->user()->name." update setting".$change."."]);
        return redirect()->back()->with("success", "Setting has been updated.");
    }

    /**
     * Function to handle upload app logo.
     */
    public static function uploadLogo($request){
        $request->validate([
            "app_logo" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);
        $imageName = time().".".$request->app_logo->extension();
        $request->app_logo->move(public_path("app_logo"), $imageName);
        self::where("name", "app_logo")->update(["value" => $imageName]);
    }

    /**
     * Function to handle upload app icon.
     */
    public static function uploadIcon($request){
        $request->validate([
            "app_icon" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);
        $imageName = time().".".$request->app_icon->extension();
        $request->app_icon->move(public_path("app_icon"), $imageName);
        self::where("name", "app_icon")->update(["value" => $imageName]);
    }

    /**
     * Function to check modification in setting model.
     */
    public static function checkModification($request){
        $change = "";
        $app_logo = Setting::where("name", "app_logo")->get()->last()->value;
        $app_icon = Setting::where("name", "app_icon")->get()->last()->value;
        if($request->app_name != $request->old_app_name){
            $change = $change.", app name from ".$request->old_app_name." to ".$request->app_name;
        }
        if($request->app_color != $request->old_app_color){
            $change = $change.", app color from ".$request->old_app_color." to ".$request->app_color;
        }
        if($request->app_font_color != $request->old_app_font_color){
            $change = $change.", app font color from ".$request->old_app_font_color." to ".$request->app_font_color;
        }
        if($request->has("app_logo")){
            $change = $change.", app logo from ".$request->old_app_logo." to ".$app_logo;
        }
        if($request->has("app_icon")){
            $change = $change.", app icon from ".$request->old_app_icon." to ".$app_icon;
        }
        return $change;
    }
}
