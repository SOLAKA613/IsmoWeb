<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    use HasFactory;

    public function trainer(){
        return $this->belongTo(Trainer::class);
    }

    public function module(){
        return $this->belongTo(Module::class);
    }
}
