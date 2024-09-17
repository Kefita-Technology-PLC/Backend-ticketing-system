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
            'id' => $this->id,
            'plate_number' => $this->plate_number,
            // 'station' =>
            'code' => $this->code,
            'level' => $this->level,
            'number_of_passengers' => $this->number_of_passengers,
            'car_type' => $this->car_type,
            'created_by' => new UserResource($this->created_by),
            'updated-by' => new UserResource($this->updated_by),
        ];
    }
}
