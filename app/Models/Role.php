<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * Model name.
     */
    protected const _model_name = "Role";

    /**
     * All fields are accessible.
     */
    protected $guarded = [];

    /**
     * Declare relationship with User Model.
     */
    public function user(){
        return $this->hasMany(User::class);
    }

    /**
     * Declare relationship with Permission Model.
     */
    public function permission(){
        return $this->hasMany(Permission::class);
    }

    /**
     * Function to perform logging every time a new record is created.
     */
    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Role $role) {
            ActivityLog::create([ "description" => Auth()->user()->name." create role ".$role->name ]);
        });
    }

    /**
     * Function to handle serve record.
     */
    public static function serveRecord(){
        $global = Globalization::index();
        $menu_id = Menu::where("name", self::_model_name)->get()->last()->id ?? NULL;
        $description = Documentation::where("menu_id", $menu_id)->get();
        $role = self::all();
        return view("role.index", compact("global", "description", "role"));
    }

    /**
     * Function to handle show creation form.
     */
    public static function showCreationForm(){
        $global = Globalization::index();
        return view("role.create", compact("global"));
    }

    /**
     * Function to handle record storing.
     */
    public static function handleStore($request){
        self::create($request->all());
        return redirect()->route("role.index")->with("success", ucfirst("role has been stored."));
    }

    /**
     * Function to handle show specific record.
     */
    public static function showSpecificRecord($id){
        $global = Globalization::index();
        $role = self::whereId($id)->get()->last();
        return view("role.show", compact("global", "role"));
    }

    /**
     * Function to handle show editing form.
     */
    public static function showEditingForm($id){
        $global = Globalization::index();
        $role = self::whereId($id)->get()->last();
        return view("role.edit", compact("global", "role"));
    }

    /**
     * Function to handle record modification.
     */
    public static function handleUpdate($request, $id){
        self::whereId($id)->update([
            "name" => $request->name,
        ]);
        $change = ActivityLog::checkModification(self::_model_name, $request, $id);
        ActivityLog::writeLog(Auth()->user()->name." update role ".$request->old_name.$change.".");
        return redirect()->route("role.index")->with("success", ucfirst("role has been updated."));
    }

    /**
     * Function to handle record deletion.
     */
    public static function handleDelete($id){
        $change = ActivityLog::checkDeletion(self::_model_name, $id);
        ActivityLog::writeLog(Auth()->user()->name." delete role ".$change.".");
        self::whereId($id)->delete();
        return redirect()->route("role.index")->with("success", ucfirst("role has been deleted."));
    }
}
