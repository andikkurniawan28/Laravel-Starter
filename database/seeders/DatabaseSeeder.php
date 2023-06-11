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
            ['name' => "app_name", 'value' => "Laravel-Starter"],
            ['name' => "app_color", 'value' => "primary"],
            ['name' => "app_font_color", 'value' => "dark"],
        ];

        $permission = [
            ['role_id' => "1", "menu_id" => 1],
            ['role_id' => "1", "menu_id" => 2],
            ['role_id' => "1", "menu_id" => 3],
            ['role_id' => "1", "menu_id" => 4],
            ['role_id' => "1", "menu_id" => 5],
        ];

        $user = [
            ['name' => ucfirst("admin"), "username" => "admin", "password" => bcrypt("admin"), "role_id" => 1, "is_activated" => 1],
        ];

        $menu = Menu::setSeeder();

        Role::insert($role);
        Setting::insert($setting);
        Menu::insert($menu);
        Permission::insert($permission);
        User::insert($user);
    }
}
