<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeploymentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->transform(function($deploymentLine){
            return[
                'id'=> $deploymentLine->id,
                'origin' => $deploymentLine->origin,
                'destination' => $deploymentLine->destination,
                'created_at' => $deploymentLine->created_at,
                'updated_at'=> $deploymentLine->updated_at,
                'created_by' => new UserResource($deploymentLine->creator),
                'updated_by' => new UserResource($deploymentLine->updator),
            ];
        });
    }
}
