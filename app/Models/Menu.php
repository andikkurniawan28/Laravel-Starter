<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function setSeeder(){
        $data = [
            ['name' => "Setting", "icon" => "cogs", 'route' => "setting"],
            ['name' => "Menu", "icon" => "list", 'route' => "menu.index"],
            ['name' => "Role", "icon" => "key",'route' => "role.index"],
            ['name' => "User", "icon" => "users", 'route' => "user.index"],
            ['name' => "Permission", "icon" => "door-open", 'route' => "permission.index"],
        ];
        return $data;
    }

    public function permission(){
        return $this->hasMany(Permission::class);
    }
}
