<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [ ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {

        $url = env('FRONT_END_URL').'reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification
        ($url));
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function createdVehicles(){
        return $this->hasMany(Vehicle::class, 'created_by');
    }
    public function updatedVehicles(){
        return $this->hasMany(Vehicle::class,'updated_by');
    }

    public function createdStations(){
        return $this->hasMany(Station::class,'created_by');
    }

    public function updatedStations(){
        return $this->hasMany(Station::class,'updated_by');
    }

    public function createdAssociations(){
        return $this->hasMany(Association::class,'created_by');
    }

    public function updatedAssociations(){
        return $this->hasMany(Association::class,'updated_by');
    }

    public function createdDeploymentLines(){
        return $this->hasMany(DeploymentLine::class,'created_by');
    }

    public function updatedDeploymentLines(){
        return $this->hasMany(DeploymentLine::class,'updated_by');
    }
}
