<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

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
            ActivityLog::create([ "description" => Auth()->user()->name." create permission for ".$permission->role->name." to access ".$permission->menu->name ]);
        });
    }

    /**
     * Function to perform logging every time a new record is updated.
     */
    public static function updateLog(){
        ActivityLog::create([
            "description" => Auth()->user()->name." update permission"
        ]);
    }

    /**
     * Function to perform logging every time a new record is deleted.
     */
    public static function deleteLog(){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete permission"
        ]);
    }
}
