<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    public function vechicles(){
        return $this->hasMany(Vehicle::class);
    }
    
    public function associations(){
        return $this->belongsToMany(Association::class);
    }
}
