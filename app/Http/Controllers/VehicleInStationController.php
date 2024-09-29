<?php

namespace App\Http\Controllers;

use App\Http\Resources\Web\VehicleStationResource;
use App\Models\Vehicle;
use App\Rules\UniqueVehicleCombination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VehicleInStationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $query = Vehicle::where('station_id', Auth::user()->station_id);
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

        $vehicles = $query->orderBy($sortField, $sortDirection)->with('station','association','creator','updater')->paginate(10);

        $user = Auth::user();
        $addVehicle = $user->hasPermissionTo('add vehicles');
        $updateVehicle = $user->hasPermissionTo('update vehicles');
        $deleteVehicle = $user->hasPermissionTo('delete vehicles');

        return Inertia::render('vehicles-stations/Index',[
          'vehicles' => VehicleStationResource::collection($vehicles),
          'addVehicle' => $addVehicle,
          'updateVehicle' => $updateVehicle,
          'deleteVehicle' => $deleteVehicle,
          'success' => session('success'),
          'queryParams' => request()->query(),
          'stationName' => $user->station->name,
        ]);
    }



    public function store(Request $request){
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

      $attrs['created_by'] = Auth::user()->id;

      Vehicle::create($attrs);

      return to_route('vehicles-stations.index')->with('success',value: 'A vehicle '.$attrs['plate_number'].' has been created.');
    }

    public function create(){
      return Inertia::render('vehicles-stations/Create');
    }

    public function update(Request $request, string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $attrs = $request->validate([
            'plate_number' => ['required', 'regex:/^[a-zA-Z]?\d{5}$/'],
            'level' => ['required', 'in:level_1,level_2,level_3,level_4'],
            'number_of_passengers' => ['required', 'integer'],
            'car_type' => ['required', 'max:250'],
            'station_id' => ['required'],
            'association_id'=> ['required'],
            'origin' => ['required'],
            'destination' => ['required'],
            // 'deployment_line_id' => ['required'],
            'code' => ['required', 'in:1,2,3'],
            'region' => ['required', 'in:TG,AF,AA,SN,DR,SD,AM,OR,SM,BN,HR,SW,ET'],
            // 'plate_number' => [new UniqueVehicleCombination($request->plate_number, $request->code, $request->region)]
        ]);
    
        // Check if any attributes have changed
        $isChanged = false;
        foreach ($attrs as $key => $value) {
            if ($vehicle->{$key} != $value) {
                $isChanged = true;
                break;
            }
        }
    
        // Update the vehicle if any attributes have changed
        if ($isChanged) {
            $vehicle->update($attrs);
            $vehicle->updated_by = Auth::user()->id;
            $vehicle->save();
        }
    
        return to_route('vehicles-stations.index')->with('success', 'Vehicle ' . $attrs['plate_number'] . ' has been updated successfully.');
    }
    
  public function destroy(string $id)
  {

    $vehicle = Vehicle::findOrFail($id);
    $plateNumber = $vehicle->plate_number;
    $code = $vehicle->code;
    $region = $vehicle->region;
    $vehicle->delete();

    return to_route('vehicles-stations.index')->with('success','Vehicle '.$region.'-'.$code.'-'.$plateNumber.' Deleted Successfully');
  }
}
