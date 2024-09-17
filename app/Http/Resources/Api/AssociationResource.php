<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociationResource extends JsonResource
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
            'establishment_date' => $this->establishment_date,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->updater),
        ];
    }
}
