<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Models\Association;
use App\Models\Station;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function getAll(){
        $vehicle = Vehicle::with(['association', 'station'])->orderBy('plate_number', 'asc')->get();
        return new VehicleCollection($vehicle);
    }
    
    public function index()
    {
        $vehicles = Vehicle::with(['association', 'station', 'deploymentLine'])
        ->latest()
        ->paginate(env("PAGINATION_NUMBER", 15));

        return new VehicleCollection($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'plate_number' => ['required', 'regex:/^[a-zA-Z]?\d{5}$/'],
            'level' => ['required', 'in:level_1,level_2,level_3'],
            'number_of_passengers' => ['required', 'integer',],
            'car_type' => ['required', 'max:250'],
            'station_name' => ['required'],
            'association_name'=> ['required'],
            'deployment_line_id' => ['required'],
            'code' => ['required','in:1,2,3']
        ]);

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
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        if(!$vehicle){
            return response()->json([
                'status' => false,
                 'message' => 'Vehicle not found.'
            ]);
        }
        $vehicle->load(['station', 'association','deploymentLine']);
        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $attrs = $request->validate([
            'plate_number' => ['required', 'regex:/^[a-zA-Z]?\d{5}$/'],
            'level' => ['required', 'in:level_1,level_2,level_3'],
            'number_of_passengers' => ['required', 'integer',],
            'car_type' => ['required', 'max:250'],
            'station_name' => ['required'],
            'association_name'=> ['required'],
            'deployment_line_id' => ['required'],
            'code' => ['required','in:1,2,3']
        ]);

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

        $vehicle->load(['station', 'association','deploymentLine']);
        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Vehicle Deleted Successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the vehicle.'
            ], 500);
        }
    }
}
