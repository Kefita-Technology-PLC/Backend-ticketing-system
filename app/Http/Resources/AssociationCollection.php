<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssociationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->transform(function($association){
            return [
                'id' => $association->id,
                'name' => $association->name,
                'establishment_date' => $association->establishment_date,
                'created_at' => $association->created_at,
                'updated_at' => $association->updated_at,
                  'stations' => $association->stations->map(function($station) {
                    return [
                        'id' => $station->id,
                        'name' => $station->name,
                        // Add any other station attributes you need
                    ];
                })
            ];
        });
    }
}
