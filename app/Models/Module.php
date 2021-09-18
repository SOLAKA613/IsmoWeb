<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = "modules";

    public function level(){
        return $this->belongTo(Level::class);
    }

    public function teachings(){
        return $this->hasMany(Teaching::class);
    }
}
