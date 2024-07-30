<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public function station(){
        return $this->belongsTo(Station::class);
    }

    public function association(){
        return $this->belongsTo(Association::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function deploymentLine(){
        return $this->belongsTo(DeploymentLine::class);
    }
}
