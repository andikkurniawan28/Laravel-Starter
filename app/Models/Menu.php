<?php

namespace App\Models;

use App\Models\ActivityLog;
use App\Models\Globalization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    /**
     * Model name.
     */
    protected const _model_name = "Menu";

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
            ["method" => "RESOURCE", "name" => ucfirst("menu"), "icon" => "fas fa-list", "route" => "menu", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst("role"), "icon" => "fas fa-key", "route" => "role", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst("permission"), "icon" => "fas fa-door-open", "route" => "permission", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst("user"), "icon" => "fas fa-users", "route" => "user", "is_serialized" => 1],
            ["method" => "RESOURCE", "name" => ucfirst("documentation"), "icon" => "fas fa-book", "route" => "documentation", "is_serialized" => 1],
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
            ActivityLog::create([ "description" => Auth()->user()->name." create menu ".$menu->name."." ]);
        });
    }

    /**
     * Function to handle serve record.
     */
    public static function serveRecord(){
        $global = Globalization::index();
        $menu_id = Menu::where("name", self::_model_name)->get()->last()->id ?? NULL;
        $description = Documentation::where("menu_id", $menu_id)->get();
        $menu = self::all();
        return view("menu.index", compact("global", "description", "menu"));
    }

    /**
     * Function to handle show creation form.
     */
    public static function showCreationForm(){
        $global = Globalization::index();
        return view("menu.create", compact("global"));
    }

    /**
     * Function to handle record storing.
     */
    public static function handleStore($request){
        self::create($request->all());
        return redirect()->route("menu.index")->with("success", ucfirst("menu has been stored."));
    }

    /**
     * Function to handle show specific record.
     */
    public static function showSpecificRecord($id){
        $global = Globalization::index();
        $menu = self::whereId($id)->get()->last();
        return view("menu.show", compact("global", "menu"));
    }

    /**
     * Function to handle show editing form.
     */
    public static function showEditingForm($id){
        $global = Globalization::index();
        $menu = self::whereId($id)->get()->last();
        return view("menu.edit", compact("global", "menu"));
    }

    /**
     * Function to handle record modification.
     */
    public static function handleUpdate($request, $id){
        self::whereId($id)->update([
            "name" => $request->name,
            "icon" => $request->icon,
            "route" => $request->route,
            "is_serialized" => $request->is_serialized,
        ]);
        $change = ActivityLog::checkModification(self::_model_name, $request, $id);
        ActivityLog::writeLog(Auth()->user()->name." update menu ".$request->old_name.$change.".");
        return redirect()->route("menu.index")->with("success", ucfirst("menu has been updated."));
    }

    /**
     * Function to handle record deletion.
     */
    public static function handleDelete($id){
        $change = ActivityLog::checkDeletion(self::_model_name, $id);
        ActivityLog::writeLog(Auth()->user()->name." delete menu ".$change.".");
        self::whereId($id)->delete();
        return redirect()->route("menu.index")->with("success", ucfirst("menu has been deleted."));
    }
}
