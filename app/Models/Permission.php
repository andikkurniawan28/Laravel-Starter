<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    /**
     * Model name.
     */
    protected const _model_name = "Permission";

    /**
     * All fields are accessible.
     */
    protected $guarded = [];

    /**
     * Declare relationship with Role Model.
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * Declare relationship with Menu Model.
     */
    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    /**
     * Function to perform logging every time a new record is created.
     */
    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Permission $permission) {
            ActivityLog::create([ "description" => Auth()->user()->name." create permission for ".$permission->role->name." to access ".$permission->menu->name."." ]);
        });
    }

    /**
     * Function to handle serve record.
     */
    public static function serveRecord(){
        $global = Globalization::index();
        $menu_id = Menu::where("name", self::_model_name)->get()->last()->id ?? NULL;
        $description = Documentation::where("menu_id", $menu_id)->get();
        $permission = self::all();
        return view("permission.index", compact("global", "description", "permission"));
    }

    /**
     * Function to handle show creation form.
     */
    public static function showCreationForm(){
        $global = Globalization::index();
        return view("permission.create", compact("global"));
    }

    /**
     * Function to handle record storing.
     */
    public static function handleStore($request){
        self::create($request->all());
        return redirect()->route("permission.index")->with("success", ucfirst("permission has been stored."));
    }

    /**
     * Function to handle show specific record.
     */
    public static function showSpecificRecord($id){
        $global = Globalization::index();
        $permission = self::whereId($id)->get()->last();
        return view("permission.show", compact("global", "permission"));
    }

    /**
     * Function to handle show editing form.
     */
    public static function showEditingForm($id){
        $global = Globalization::index();
        $permission = self::whereId($id)->get()->last();
        return view("permission.edit", compact("global", "permission"));
    }

    /**
     * Function to handle record modification.
     */
    public static function handleUpdate($request, $id){
        self::whereId($id)->update([
            "role_id" => $request->role_id,
            "menu_id" => $request->menu_id,
        ]);
        $change = ActivityLog::checkModification(self::_model_name, $request, $id);
        ActivityLog::writeLog(Auth()->user()->name." update permission ".$change.".");
        return redirect()->route("permission.index")->with("success", ucfirst("permission has been updated."));
    }

    /**
     * Function to handle record deletion.
     */
    public static function handleDelete($id){
        $change = ActivityLog::checkDeletion(self::_model_name, $id);
        ActivityLog::writeLog(Auth()->user()->name." delete permission ".$change);
        self::whereId($id)->delete();
        return redirect()->route("permission.index")->with("success", ucfirst("permission has been deleted."));
    }
}
