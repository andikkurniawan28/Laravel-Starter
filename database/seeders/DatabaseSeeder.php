<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use App\Models\Permission;
use App\Models\Documentation;
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

        $documentation = [
            ["menu_id" => 4, "description" => "A menu is a feature used to organize the routes or menus that will be displayed and registered within an application. It depicts the routes of your application, and each route should ideally be included in the menu table so that its permissions can be controlled."],
            ["menu_id" => 5, "description" => "Role are a feature used to define and manage access rights within an application. Generally, an application introduces the concept of admin and user access rights. However, you can develop these access rights according to the needs of your application."],
            ["menu_id" => 6, "description" => "Permissions are a feature used to configure how a role can access a menu or multiple menus. Generally, this application grants more permissions to admins compared to users, but you can customize this concept according to your preferences."],
            ["menu_id" => 7, "description" => "User is a feature for managing users, including user addition, modification, and deletion. You can also activate users through this feature. Inactive users are not able to log in."],
        ];

        Role::insert($role);
        Setting::insert($setting);
        Menu::insert($menu);
        Permission::insert($permission);
        User::insert($user);
        Documentation::insert($documentation);
    }
}
