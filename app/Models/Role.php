<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

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
     * Function to perform logging every time a new record is updated.
     */
    public static function updateLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." update role ".$request->name
        ]);
    }

    /**
     * Function to perform logging every time a new record is deleted.
     */
    public static function deleteLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete role ".$request->name
        ]);
    }
}
