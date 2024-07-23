<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Models\Association;
use App\Models\Station;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new VehicleCollection(Vehicle::with(['association','station'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'plate_number' => ['required', 'unique:vehicles,plate_number'],
            'level' => ['required', 'in:level1,level2,level3'],
            'registration_date' => ['required', 'date'],
            'number_of_passengers' => ['required', 'integer',],
            'car_type' => ['required', 'max:250'],
            'station_name' => ['required'],
            'association_name'=> ['required'],
        ]);

        $station = Station::where('name', $attrs['station_name'])->first();
        $association = Association::where('name', $attrs['association_name'])->first();

        $stations = Station::pluck('id', 'name');
        $associations = Association::pluck('id', 'name');

        $stationId = $stations[$attrs['station_name']] ?? null;
        $associationId = $associations[$attrs['association_name']] ?? null;

        if (!$stationId || !$associationId) {
            return response()->json(['error' => 'Station or Association not found'], 404);
        }

        $vehicle = Vehicle::create([
            'station_id' => $stationId,
            'association_id' => $associationId,
            ...Arr::except($attrs, ['station_name', 'association_name']),
        ]);

        return new VehicleResource($vehicle);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['station', 'association']);
        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $attrs = $request->validate([
            'plate_number' => ['required',],
            'level' => ['required', 'in:level1,level2,level3'],
            'registration_date' => ['required', 'date'],
            'number_of_passengers' => ['required', 'integer',],
            'car_type' => ['required', 'max:250'],
            'station_name' => ['required'],
            'association_name'=> ['required'],
        ]);

        $station = Station::where('name', $attrs['station_name'])->first();
        $association = Association::where('name', $attrs['association_name'])->first();

        $stations = Station::pluck('id', 'name');
        $associations = Association::pluck('id', 'name');

        $stationId = $stations[$attrs['station_name']] ?? null;
        $associationId = $associations[$attrs['association_name']] ?? null;

        if (!$stationId || !$associationId) {
            return response()->json(['error' => 'Station or Association not found'], 404);
        }

        $vehicle->update([
            'station_id' => $stationId,
            'association_id' => $associationId,
            ...Arr::except($attrs, ['station_name', 'association_name']),
        ]);

        $vehicle->load(['station', 'association']);
        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return new VehicleCollection(Vehicle::with(['association','station'])->get());
    }
}
