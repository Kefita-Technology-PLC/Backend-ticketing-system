<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public static function TypeCount(string $type){

        $vehicleType = Vehicle::where('car_type', $type)->count();

        return $vehicleType;
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');

    }
    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');

    }
}
