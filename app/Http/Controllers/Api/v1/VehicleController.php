<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AssociationResource;
use App\Http\Resources\Api\StationResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\VehicleResource as ApiVehicleResource;
use App\Http\Resources\Api\VehicleCollection;
use App\Models\Tariff;
use App\Models\Vehicle;
use App\Rules\UniqueVehicleCombination;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    public function vehiclePlateNumber(Request $request)
    {
        // Validate input
        $attrs = $request->validate([
            'plate_number' => 'required',
            'region'   => 'required|string',
            'code'     => 'required',
        ]);
    
        // Search for the vehicle using a single query
        $vehicle = Vehicle::where([
            ['plate_number', '=', $attrs['plate_number']],
            ['region', '=', $attrs['region']],
            ['code', '=', $attrs['code']]
        ])->with('creator','updater', 'station', 'association')->first();
    
        // Return error if vehicle is not found
        if (!$vehicle) {
            return response()->json([
                'data' => [
                    'error' => 'Vehicle not found.'
                ]
                
            ], 404);
        }
    
        // Return the vehicle data
        return response()->json([
            'data' => [
                'vehicle' => $vehicle,
            ]
        ], 200);
    }
    

    public function searchQueries(Request $request){
        $searchColumns = ["plate_number"];
        $vehicleQuery = Vehicle::with(['association','station','creator','updater']);

        return $this->search($request, $vehicleQuery, $searchColumns, ApiVehicleResource::class);
    }

     public function getAll(){
        $vehicle = Vehicle::with(['association', 'station', 'creator', 'updater'])->orderBy('plate_number', 'asc')->get();
        return new VehicleCollection($vehicle);
    }

    public function ByPlateNumber(Request $request){
        $request->validate([
            'code' => 'required',
            'region' => ['required', 'in:TG,AF,AA,SN,DR,SD,AM,OR,SM,BN,HR,SW,ET'],
            'plate_number' => 'required',
        ]);

        $vehicle = Vehicle::with('association', 'station','creator', 'updater')
        ->where('code', $request->code)
        ->where('region', $request->region)
        ->where('plate_number', $request->plate_number)
        ->first();

        if(!$vehicle){
            return response()->json([
                'data' => [
                    'message' => 'vehicle not found.'
                ]
            ], 404);
        }

        $tariff = Tariff::where('origin', strtolower($vehicle->origin))
        ->where('destination', strtolower($vehicle->destination))->first();

        if(!$tariff){
            return response()->json([
                'data' => [
                    'message' => 'Tarrif not found.'
                ]
            ], 404);
        }

        $price = 0;

        if($vehicle->level == 'level_1'){
            $price = $tariff->level1_price;
        }else if($vehicle->level == 'level_2'){
            $price =  $tariff->level2_price;
        }else{
            $price =  $tariff->level3_price;
        }

        return response()->json([
            'data' =>[
                'id' => $vehicle->id,
                'station' => new StationResource($vehicle->station),
                'association' => new AssociationResource($vehicle->association),
                'plate_number' => $vehicle->plate_number,
                'code' => $vehicle->code,
                'level' => $vehicle->level,
                'number_of_passengers' => $vehicle->number_of_passengers,
                'car_type' => $vehicle->car_type,
                'created_by' => new UserResource($vehicle->creator),
                'updated_by' => new UserResource($vehicle->updater),
                'price' => $price
            ]
        ]);

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
            'origin' => ['required'],
            'destination' => ['required'],
            // 'deployment_line_id' => ['required'],
            'code' => ['required','in:1,2,3'],
            'region' => ['required','in:TG,AF,AA,SN,DR,SD,AM,OR,SM,BN,HR,SW,ET'],
            'plate_number' => [new UniqueVehicleCombination($request->plate_number, $request->code, $request->region)]
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
            'origin' => ['required'],
            'destination' => ['required'],
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
