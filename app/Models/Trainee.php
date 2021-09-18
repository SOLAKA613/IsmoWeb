<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'age',
        'email',
        'gender',
    ];

    public function group(){
        return $this->belongTo(Group::class);
    }

    public function absences_delayes(){
        return $this->hasMany(Absences_delay::class);
    }
}
