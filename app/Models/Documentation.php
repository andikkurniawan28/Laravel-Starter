<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Documentation $documentation) {
            ActivityLog::create([ "description" => Auth()->user()->name." create documentation"]);
        });
    }

    public static function updateLog(){
        ActivityLog::create([
            "description" => Auth()->user()->name." update documentation"
        ]);
    }

    public static function deleteLog(){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete documentation"
        ]);
    }
}
