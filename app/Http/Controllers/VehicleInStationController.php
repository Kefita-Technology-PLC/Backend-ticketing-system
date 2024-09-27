<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
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


          return Inertia::render('vehicles-stations/Index',[
            'vehicles' => 
          ]);
    }
}
