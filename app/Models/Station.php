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

    public function association(string $name){
        $association = Association::where([
            'name' => $name,
        ])->first();

        $this->associations()->attach($association);
    }

    public function removeAssociation(string $name){
        $association = Association::where([
            'name' => $name,
        ])->first();

        $this->associations()->detach($association);
    }
    
    public function associations(){
        return $this->belongsToMany(Association::class);
    }
}
