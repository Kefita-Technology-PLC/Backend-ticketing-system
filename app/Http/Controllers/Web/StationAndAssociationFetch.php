<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\StationResource;
use App\Models\Association;
use App\Models\Station;

class StationAndAssociationFetch extends Controller
{
    public function station(Station $station){
        return response()->json([
            'data' => new StationResource($station)
        ]);
    }

    public function association(Association $association){
        return response()->json([
            'data' => $association
        ]);
    }
}
