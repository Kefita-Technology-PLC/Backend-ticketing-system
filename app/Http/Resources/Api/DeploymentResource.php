<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeploymentResource extends JsonResource
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
            'origin'=> $this->origin,
            'destination' => $this->destination,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->updater),
        ];
    }
}
