<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    public function station(){
        return $this->belongsTo(Station::class);
    }

    public function deploymentLines(){
        return $this->belongsTo(DeploymentLine::class);
    }
}
