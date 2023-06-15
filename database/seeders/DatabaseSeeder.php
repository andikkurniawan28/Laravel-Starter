<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $menu = Menu::setSeeder();

        $setting = [
            ["name" => "app_name", "value" => "Laravel Starter"],
            ["name" => "app_logo", "value" => "1686639239.png"],
            ["name" => "app_icon", "value" => "1686640675.png"],
            ["name" => "app_color", "value" => "danger"],
            ["name" => "app_font_color", "value" => "dark"],
        ];

        $role = [
            ["name" => ucfirst("admin")],
            ["name" => ucfirst("user")],
        ];

        $permission = [];
        for($i = 1; $i <= count($menu); $i++){
            $permission[$i]["role_id"] = 1;
            $permission[$i]["menu_id"] = $i;
        }

        $user = [
            ["name" => ucfirst("admin"), "username" => "admin", "password" => bcrypt("admin"), "role_id" => 1, "is_activated" => 1],
        ];

        Role::insert($role);
        Setting::insert($setting);
        Menu::insert($menu);
        Permission::insert($permission);
        User::insert($user);
    }
}
