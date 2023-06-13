<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public static function updateSetting($request){
        Setting::where("name", "app_name")->update(["value" => $request->app_name]);
        Setting::where("name", "app_color")->update(["value" => $request->app_color]);
        Setting::where("name", "app_font_color")->update(["value" => $request->app_font_color]);
        if($request->has("app_icon")){
            self::uploadImage($request);
        }
        return redirect()->back()->with("success", "Setting has been updated.");
    }

    public static function uploadImage($request){
        $request->validate([
            "app_icon" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);
        $imageName = time().".".$request->app_icon->extension();
        $request->app_icon->move(public_path("app_icon"), $imageName);
        Setting::where("name", "app_icon")->update(["value" => $imageName]);
    }
}
