<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    public function stations(){
        return $this->belongsToMany(Station::class, 'association_station');
    }
}
