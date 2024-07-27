<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function station(){
        return $this->belongsTo(Station::class);
    }

    public function destination(){
        return $this->belongsTo(Destination::class);
    }
}