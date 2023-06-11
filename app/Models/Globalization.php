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

    public static function index(){
        $data["role"] = Role::all();
        $data["menu"] = Menu::all();
        $data["app_name"] = Setting::where("name", "=", "app_name")->get()->last()->value;
        $data["app_color"] = Setting::where("name", "=", "app_color")->get()->last()->value;
        $data["app_font_color"] = Setting::where("name", "=", "app_font_color")->get()->last()->value;
        $data["default_role_id"] = Role::max("id");

        if (Route::current()->getName() != "login" && Route::current()->getName() != "register") {
            $data["permission"] = Permission::where("role_id", Auth()->user()->role_id)->get();
            $data["is_setting_allowed"] = Permission::where("role_id", Auth()->user()->role_id)
                ->where("menu_id", 2)->count();
        }

        return $data;
    }
}
