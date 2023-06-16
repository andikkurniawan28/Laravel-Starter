<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Documentation;
use App\Models\Globalization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documentation extends Model
{
    use HasFactory;

    /**
     * Model name.
     */
    protected const _model_name = "Documentation";

    /**
     * All fields are accessible.
     */
    protected $guarded = [];

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
        static::created(function (Documentation $documentation) {
            ActivityLog::create([ "description" => Auth()->user()->name." create documentation."]);
        });
    }

    /**
     * Function to handle serve record.
     */
    public static function serveRecord(){
        $global = Globalization::index();
        $menu_id = Menu::where("name", self::_model_name)->get()->last()->id ?? NULL;
        $description = Documentation::where("menu_id", $menu_id)->get();
        $documentation = self::all();
        return view("documentation.index", compact("global", "description", "documentation"));
    }

    /**
     * Function to handle show creation form.
     */
    public static function showCreationForm(){
        $global = Globalization::index();
        return view("documentation.create", compact("global"));
    }

    /**
     * Function to handle record storing.
     */
    public static function handleStore($request){
        self::create($request->all());
        return redirect()->route("documentation.index")->with("success", ucfirst("documentation has been stored."));
    }

    /**
     * Function to handle show specific record.
     */
    public static function showSpecificRecord($id){
        $global = Globalization::index();
        $documentation = self::whereId($id)->get()->last();
        return view("documentation.show", compact("global", "documentation"));
    }

    /**
     * Function to handle show editing form.
     */
    public static function showEditingForm($id){
        $global = Globalization::index();
        $documentation = self::whereId($id)->get()->last();
        return view("documentation.edit", compact("global", "documentation"));
    }

    /**
     * Function to handle record modification.
     */
    public static function handleUpdate($request, $id){
        self::whereId($id)->update([
            "menu_id" => $request->menu_id,
            "description" => $request->description,
        ]);
        $change = ActivityLog::checkModification(self::_model_name, $request, $id);
        ActivityLog::writeLog(Auth()->user()->name." update documentation".$change.".");
        return redirect()->route("documentation.index")->with("success", ucfirst("documentation has been updated."));
    }

    /**
     * Function to handle record deletion.
     */
    public static function handleDelete($id){
        $change = ActivityLog::checkDeletion(self::_model_name, $id);
        ActivityLog::writeLog(Auth()->user()->name." delete documentation ".$change);
        self::whereId($id)->delete();
        return redirect()->route("documentation.index")->with("success", ucfirst("documentation has been deleted."));
    }
}
