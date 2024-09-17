<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\VehicleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->transform(function ($vehicle) {
            return new VehicleResource($vehicle);
        });

    }
}
