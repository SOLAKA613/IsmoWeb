<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    
    public function level(){
        return $this->belongTo(Level::class);
    }

    public function trainees(){
        return $this->hasMany(Trainee::class);
    }
}
