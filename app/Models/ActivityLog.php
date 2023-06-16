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
}
