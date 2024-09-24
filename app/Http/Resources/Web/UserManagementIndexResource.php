<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserManagementIndexResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at,
            'creator' => $this->created_by,
            'updater' => $this->updated_by,
        ];
    }
}
