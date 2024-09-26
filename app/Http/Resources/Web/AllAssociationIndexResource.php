<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllAssociationIndexResource extends JsonResource
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
            'creator' => new UserNameAndIdResource($this->creator),
            'updater' => new UserNameAndIdResource($this->updater),
        ];
    }
}
