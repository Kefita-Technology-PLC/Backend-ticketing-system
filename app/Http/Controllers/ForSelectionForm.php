<?php

namespace App\Http\Controllers;

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
            'car_type' => $types
        ]);
    }
}
