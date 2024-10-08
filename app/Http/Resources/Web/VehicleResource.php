<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>(int) $this->id,
            'plate_number' => $this->plate_number,
            'station_name' => $this->station->name,
            'code' => $this->code,
            'level' => $this->level,
            'number_of_passengers' => $this->number_of_passengers,
            'car_type' =>
            $this->car_type,
            'region' => $this->region,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator' => new UserNameAndIdResource($this->creator),
            'updater' => new UserNameAndIdResource($this->updater),
        ];
    }
}
