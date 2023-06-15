<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * Function to perform update record on setting table.
     */
    public static function updateSetting($request){
        Setting::where("name", "app_name")->update(["value" => $request->app_name]);
        Setting::where("name", "app_color")->update(["value" => $request->app_color]);
        Setting::where("name", "app_font_color")->update(["value" => $request->app_font_color]);

        if($request->has("app_logo")){
            self::uploadLogo($request);
        }
        if($request->has("app_icon")){
            self::uploadIcon($request);
        }

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
        Setting::where("name", "app_logo")->update(["value" => $imageName]);
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
        Setting::where("name", "app_icon")->update(["value" => $imageName]);
    }
}
