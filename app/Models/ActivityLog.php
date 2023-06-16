<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * All fields are accessible.
     */
    protected $guarded = [];

    /**
     * All fields are accessible.
     */
    public static function writeLog($description){
        self::insert(["description" => $description]);
    }

    /**
     * Function to check modification on model.
     */
    public static function checkModification($model, $request, $id){
        switch($model){
            case "Menu" : $change = self::modificationMenu($request, $id); break;
            case "Role" : $change = self::modificationRole($request, $id); break;
            case "Permission" : $change = self::modificationPermission($request, $id); break;
        }
        return $change;
    }

    /**
     * Function to check deletion on menu model.
     */
    public static function checkDeletion($model, $id){
        switch($model){
            case "Menu" : $change = Menu::whereId($id)->get()->last()->name; break;
            case "Role" : $change = Role::whereId($id)->get()->last()->name; break;
            case "Permission" : $change = self::deletionPermission($id); break;
        }
        return $change;
    }

    public static function modificationMenu($request, $id){
        $change = "";
        $new_name = Menu::whereId($id)->get()->last()->name;
        $new_icon = Menu::whereId($id)->get()->last()->icon;
        $new_route = Menu::whereId($id)->get()->last()->route;
        $new_is_serialized = Menu::whereId($id)->get()->last()->is_serialized;
        if($new_name != $request->old_name){
            $change = ", name from ".$request->old_name." to ".$new_name;
        }
        if($new_icon != $request->old_icon){
            $change = $change.", icon from ".$request->old_icon." to ".$new_icon;
        }
        if($new_route != $request->old_route){
            $change = $change.", route from ".$request->old_route." to ".$new_route;
        }
        if($new_is_serialized != $request->old_is_serialized){
            $change = $change.", serialization from ".$request->old_is_serialized." to ".$new_is_serialized;
        }
        return $change;
    }

    public static function modificationRole($request, $id){
        $change = "";
        $new_name = Role::whereId($id)->get()->last()->name;
        if($new_name != $request->old_name){
            $change = ", name from ".$request->old_name." to ".$new_name;
        }
        return $change;
    }

    public static function modificationPermission($request, $id){
        $change = " with ID ".$id;

        $new_role_id = Permission::whereId($id)->get()->last()->role_id;
        $new_menu_id = Permission::whereId($id)->get()->last()->menu_id;

        $new_role = Role::whereId($new_role_id)->get()->last()->name;
        $new_menu = Menu::whereId($new_menu_id)->get()->last()->name;

        $old_role = Role::whereId($request->old_role_id)->get()->last()->name;
        $old_menu = Menu::whereId($request->old_menu_id)->get()->last()->name;

        if($old_role != $new_role){
            $change = ", role from ".$old_role." to ".$new_role;
        }
        if($old_menu != $new_menu){
            $change = $change.", menu from ".$old_menu." to ".$new_menu;
        }
        return $change;
    }

    public static function deletionPermission($id){
        $role_id = Permission::whereId($id)->get()->last()->role_id;
        $menu_id = Permission::whereId($id)->get()->last()->menu_id;
        $role = Role::whereId($role_id)->get()->last()->name;
        $menu = Menu::whereId($menu_id)->get()->last()->name;
        $change = "for ".$role." to access ".$menu.".";
        return $change;
    }

}
