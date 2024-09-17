<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        // return [
        //     'data' => $this->collection
        // ];
        return $this->collection->transform(function($station) {
            return [
                'id' => $station->id,
                'name' => $station->name,
                'location' => $station->location,
                'associations' => $station->associations->map(function($association){
                    return [
                        'id' =>$association->id,
                        'name' => $association->name,
                    ];
                }),
                'created_at' => $station->created_at,
                'updated_at'=> $station->updated_at,
                'created_by' => new UserResource($station->creator),
                'updated_by' => new UserResource($station->updater),
            ];
        });
    }
}
