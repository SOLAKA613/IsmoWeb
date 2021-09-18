<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $table = "levels";

    public function division(){
        return $this->belongTo(Division::class);//Pour faire la relation Many to one avec classe Division
    }

    public function groups(){
        return $this->hasMany(Group::class);
    }

    public function modules(){
        return $this->hasMany(Module::class);
    }
}
