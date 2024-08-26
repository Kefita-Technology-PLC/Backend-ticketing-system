<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Station;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ForSelectionForm extends Controller
{
    public function carType(){
        $types = Vehicle::distinct()->pluck('car_type');
        if(!$types){
            return response()->json([
                'message' => 'No Car Type'
            ], 404);
        }
        return response()->json([
            'data'=>[
                'car_type' => $types
            ]
        ]);
    }

    public function stationNames(){
        $stations = Station::select('id', 'name')
        ->orderBy('name', 'asc')
        ->groupBy('name') // Ensure only unique names
        ->get();

        return response()->json([
            'data' => $stations
        ]);
    }

    public function associationNames(){
        $associations = Association::select('id', 'name')
        ->orderBy('name', 'asc')
        ->groupBy('name')
        ->get();

        return response()->json([
            'data' => $associations
        ]);
    }

    // public function 
}
