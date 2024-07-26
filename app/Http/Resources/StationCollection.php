<?php

namespace App\Http\Resources;

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
                'associations' => new AssociationCollection($station->associations),
            ];
        });
    }
}
