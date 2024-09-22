<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\UserResource;
use App\Http\Resources\Web\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
