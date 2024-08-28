<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NumberOfPassengersCollection;
use App\Http\Resources\NumberOfPassengersResource;
use App\Models\NumberOfPassengers;
use Illuminate\Http\Request;

class NumberOfPassengersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $passengers = NumberOfPassengers::orderBy('number', 'asc')->get();
        return new NumberOfPassengersCollection($passengers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'number'=> 'required | integer',
        ]);

        $passenger = NumberOfPassengers::create($attrs);
        return new NumberOfPassengersResource($passenger);
    }

    /**
     * Display the specified resource.
     */
    public function show(NumberOfPassengers $numberOfPassengers)
    {
        return new NumberOfPassengersResource($numberOfPassengers);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NumberOfPassengers $numberOfPassengers)
    {
        $attrs = $request->validate([
            'number'=> 'required | integer',
        ]);

        $numberOfPassengers->update($attrs);
        return new NumberOfPassengersResource($numberOfPassengers);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NumberOfPassengers $numberOfPassengers)
    {
        $numberOfPassengers->delete();
        return response()->json([
            'status' => true,
            'message' => 'Number of passengers added sucessfully.'
        ]);
    }
}
