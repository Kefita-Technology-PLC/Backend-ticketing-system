<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\VehicleResource as ApiVehicleResource;
use App\Http\Resources\Api\VehicleCollection;
// use App\Http\Resources\VehicleResource;
use App\Models\Association;
use App\Models\Station;
use App\Models\Vehicle;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    public function searchQueries(Request $request){
        $searchColumns = ["plate_number"];
        $vehicleQuery = Vehicle::with(['association','station','creator','updater']);

        return $this->search($request, $vehicleQuery, $searchColumns);
    }

     public function getAll(){
        $vehicle = Vehicle::with(['association', 'station', 'creator', 'updater'])->orderBy('plate_number', 'asc')->get();
        return new VehicleCollection($vehicle);
    }

    public function index()
    {
        $vehicles = Vehicle::with(['association', 'station', 'deploymentLine','creator', 'updater'])
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
            'level' => ['required', 'in:level_1,level_2,level_3,level_4','level_5'],
            'number_of_passengers' => ['required', 'integer',],
            'car_type' => ['required', 'max:250'],
            'station_id' => ['required'],
            'association_id'=> ['required'],
            // 'deployment_line_id' => ['required'],
            'code' => ['required','in:1,2,3'],
            'region' => ['required','in:TG,AF,AA,SN,DR,SD,AM,OR,SM,BN,HR,SW,ET'],
        ]);

        $attrs['created_by'] = Auth::user()->id;

        $vehicle = Vehicle::create($attrs);



        // $stations = Station::pluck('id', 'name');
        // $associations = Association::pluck('id', 'name');

        // $stationId = $stations[$attrs['station_name']] ?? null;
        // $associationId = $associations[$attrs['association_name']] ?? null;

        // if (!$stationId || !$associationId) {
        //     return response()->json(['error' => 'Station or Association not found'], 404);
        // }

        // $vehicle = Vehicle::create(
        //     // 'station_id' => $stationId,
        //     // 'association_id' => $associationId,
        //     // ...Arr::except($attrs, ['station_name', 'association_name']),
        //     $attrs
        // );

        return new ApiVehicleResource($vehicle);
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
        return new ApiVehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $attrs = $request->validate([
            'plate_number' => ['required', 'regex:/^[a-zA-Z]?\d{5}$/'],
            'level' => ['required', 'in:level_1,level_2,level_3,level_4','level_5'],
            'number_of_passengers' => ['required', 'integer',],
            'car_type' => ['required', 'max:250'],
            'station_id' => ['required'],
            'association_id'=> ['required'],
            // 'deployment_line_id' => ['required'],
            'code' => ['required','in:1,2,3'],
            'region' => ['required','in:TG,AF,AA,SN,DR,SD,AM,OR,SM,BN,HR,SW,ET'],
        ]);

        // $stations = Station::pluck('id', 'name');
        // $associations = Association::pluck('id', 'name');

        // $stationId = $stations[$attrs['station_name']] ?? null;
        // $associationId = $associations[$attrs['association_name']] ?? null;

        // if (!$stationId || !$associationId) {
        //     return response()->json(['error' => 'Station or Association not found'], 404);
        // }

        $attrs['updated_by'] = Auth::user()->id;

        $vehicle->update($attrs);

        $vehicle->load(['station', 'association','deploymentLine']);
        return new ApiVehicleResource($vehicle);
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
