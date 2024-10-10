<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\AssociationResource;
use App\Http\Resources\Api\StationResource;
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
            "id"=> $this->id,
            'station' => new StationResource($this->station),
            'association' => new AssociationResource($this->association),
            'plate_number' => $this->plate_number,
            'code' => $this->code,
            'level' => $this->level,
            'number_of_passengers' => $this->number_of_passengers,
            'car_type' => $this->car_type,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->updater),
        ];
    }
}
