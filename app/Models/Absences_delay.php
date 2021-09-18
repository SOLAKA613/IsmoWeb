<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences_delay extends Model
{
    use HasFactory;

    public function trainee(){
        return $this->belongTo(Trainee::class);
    }
}
