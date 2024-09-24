<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\UserResource;
use App\Http\Resources\Web\VehicleResource;
use App\Models\Vehicle;
use App\Rules\UniqueVehicleCombination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      $query = Vehicle::query();
      $sortField = request('sort_field', 'created_at');
      $sortDirection = request('sort_direction', 'desc');

      if (request('level')){

        $query->where('level', request('level'));
        // dd($query);
      }

      if (request('plate_number')){
        $query->where('plate_number','like','%'. request('plate_number')  .'%');
      }

      if (request('car_type')){
        $query->where('car_type', request('car_type'));
      }

      // dd('here is the error');
        $vehicles = $query->orderBy($sortField, $sortDirection)->with('station','association','creator','updater')->paginate(10);

        // dd($vehicles);

        return Inertia::render('Vehicles/Index',[
            'vehicles' => VehicleResource::collection($vehicles),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return Inertia::render('Vehicles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

      $attrs = $request->validate([
        'plate_number' => ['required', 'regex:/^[a-zA-Z]?\d{5}$/'],
        'level' =>['required', 'in:level_1,level_2,level_3,level_4'],
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

      // dd($attrs);
      $attrs['created_by'] = Auth::user()->id;

      Vehicle::create($attrs);

      return to_route('vehicles.index')->with('success','A vehicle '.$attrs['plate_number'].' has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
      $vehicle->load('creator','updater','station','association');
      return Inertia::render('Vehicles/Show',[
        'vehicle' => $vehicle,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return Inertia::render('Vehicles/Edit',[
          'vehicle' => $vehicle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
      $attrs = $request->validate([
        'plate_number' => ['required', 'regex:/^[a-zA-Z]?\d{5}$/'],
        'level' =>['required', 'in:level_1,level_2,level_3,level_4'],
        'number_of_passengers' => ['required', 'integer',],
        'car_type' => ['required', 'max:250'],
        'station_id' => ['required'],
        'association_id'=> ['required'],
        'origin' => ['required'],
        'destination' => ['required'],
        // 'deployment_line_id' => ['required'],
        'code' => ['required','in:1,2,3'],
        'region' => ['required','in:TG,AF,AA,SN,DR,SD,AM,OR,SM,BN,HR,SW,ET'],
        // 'plate_number' => [new UniqueVehicleCombination($request->plate_number, $request->code, $request->region)]
    ]);
        $attrs['updated_by'] = Auth::user()->id;

        $vehicle->update($attrs);

        return to_route('vehicles.index')->with('success','Vechile '.$attrs['plate_number'].' '.'has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
      
        $plateNumber = $vehicle->plate_number;
        $vehicle->delete();

        return to_route('vehicles.index')->with('success','Vehicle '.$plateNumber.' Deleted Successfully');
    }
}
