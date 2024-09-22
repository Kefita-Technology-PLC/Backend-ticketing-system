<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>(int) $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->updator),
        ];
    }
}
