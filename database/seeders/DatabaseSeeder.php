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
        $role = [
            ['name' => ucfirst("admin")],
            ['name' => ucfirst("user")],
        ];

        $setting = [
            ['name' => "app_name", 'value' => "Starter"],
            ['name' => "app_color", 'value' => "primary"],
            ['name' => "app_font_color", 'value' => "dark"],
        ];

        $menu = [
            ['name' => "Setting", "icon" => "cogs", 'route' => "setting"],
            ['name' => "Role", "icon" => "key",'route' => "role.index"],
            ['name' => "User", "icon" => "users", 'route' => "user.index"],
            ['name' => "Permission", "icon" => "door-open", 'route' => "permission.index"],
        ];

        $permission = [
            ['role_id' => "1", "menu_id" => 1],
            ['role_id' => "1", "menu_id" => 2],
            ['role_id' => "1", "menu_id" => 3],
            ['role_id' => "1", "menu_id" => 4],
        ];

        $user = [
            ['name' => ucfirst("admin"), "username" => "admin", "password" => bcrypt("admin"), "role_id" => 1],
        ];

        Role::insert($role);
        Setting::insert($setting);
        Menu::insert($menu);
        Permission::insert($permission);
        User::insert($user);
    }
}
