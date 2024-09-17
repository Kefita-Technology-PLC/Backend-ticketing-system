<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeploymentLine extends Model
{
    use HasFactory;

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function creator(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function updator(){
        return $this->belongsTo(User::class,'updated_by');
    }
}
