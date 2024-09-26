<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'name' => $this->name,
            'phone_no' => $this->phone_no,
            'email' => $this->email,
            'gender' => $this->gender,
            'salary' => $this->salary,
            'station_id' => $this->station_id,
            'permissions' => $this->getAllPermissions()->pluck('name'),
        ];
    }
}
