<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleStationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plate_number' => $this->plate_number,
            'code' => $this->code,
            'level' => $this->level,
            'number_of_passengers' => $this->number_of_passengers,
            'car_type' =>
            $this->car_type,
            'region' => $this->region,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator' => new UserResource($this->creator),
            'updater' => new UserResource($this->updater),
        ];
    }
}
