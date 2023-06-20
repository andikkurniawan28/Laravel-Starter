<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Globalization extends Model
{
    use HasFactory;

    /**
     * Function to globally present data without having to individually call each model in every controller.
     */
    public static function index(){
        $data["role"] = Role::all();
        $data["menu"] = Menu::all();
        $data["permission"] = Permission::all();
        $data["user"] = User::count();
        $data["app_name"] = Setting::where("name", "app_name")->get()->last()->value;
        $data["app_logo"] = Setting::where("name", "app_logo")->get()->last()->value;
        $data["app_icon"] = Setting::where("name", "app_icon")->get()->last()->value;
        $data["app_color"] = Setting::where("name", "app_color")->get()->last()->value;
        $data["app_font_color"] = Setting::where("name", "app_font_color")->get()->last()->value;
        $data["default_role_id"] = Role::max("id");

        if (Route::current()->getName() != "login" && Route::current()->getName() != "register") {
            $data["permission"] = Permission::where("role_id", Auth()->user()->role_id)->get();
            $data["is_setting_allowed"] = Permission::where("role_id", Auth()->user()->role_id)
                ->where("menu_id", 1)->count();
            $data["is_activity_log_allowed"] = Permission::where("role_id", Auth()->user()->role_id)
                ->where("menu_id", 3)->count();
        }

        return $data;
    }
}
