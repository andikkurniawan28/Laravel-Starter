<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    /**
     * All fields are accessible.
     */
    protected $guarded = [];

    /**
     * Function to perform seeder. Whenever registering a new route, it is recommended to add
     * that route to the seeder so that when performing migration, your route will be included
     * in the menu table and its access rights can be managed.
     */
    public static function setSeeder(){
        $data = [
            ["method" => "GET", "name" => "Setting Index", "icon" => "fas fa-cogs", "route" => "setting.index", "is_serialized" => 0],
            ["method" => "POST", "name" => "Setting Process", "icon" => NULL, "route" => "setting.process", "is_serialized" => 0],
            ["method" => "GET", "name" => "Activity Log", "icon" => "fas fa-history", "route" => "activity_log", "is_serialized" => 0],
            ["method" => "RESOURCE", "name" => ucfirst('menu'), "icon" => "fas fa-list", "route" => "menu", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst('role'), "icon" => "fas fa-key", "route" => "role", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst('permission'), "icon" => "fas fa-door-open", "route" => "permission", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst('user'), "icon" => "fas fa-users", "route" => "user", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst('documentation'), "icon" => "fas fa-book", "route" => "documentation", "is_serialized" => 1],
            ["method" => "GET", "name" => "User Activation", "icon" => NULL, "route" => "user.activation", "is_serialized" => 0],
        ];
        return $data;
    }

    /**
     * Declare relationship with Permission Model.
     */
    public function permission(){
        return $this->hasMany(Permission::class);
    }

    /**
     * Declare relationship with Documentation Model.
     */
    public function documentation(){
        return $this->hasMany(Documentation::class);
    }

    /**
     * Function to perform logging every time a new record is created.
     */
    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Menu $menu) {
            ActivityLog::create([ "description" => Auth()->user()->name." create menu ".$menu->name ]);
        });
    }

    /**
     * Function to perform logging every time a new record is updated.
     */
    public static function updateLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." update menu ".$request->name
        ]);
    }

    /**
     * Function to perform logging every time a new record is deleted.
     */
    public static function deleteLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete menu ".$request->name
        ]);
    }
}
