<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Trainer extends Model
{
    use HasFactory;
    protected $table = 'trainers';

    public function modules(){
        return $this->hasMany(Module::class);
    }

    public function teachings(){
        return $this->hasMany(Teaching::class);
    }
}
