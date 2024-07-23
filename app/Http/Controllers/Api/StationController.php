<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StationCollection;
use App\Http\Resources\StationResource;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new StationCollection(Station::all());
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name'=> ['required', 'unique:stations,name', 'max:100'],
            'location' => ['required', 'max:50']
        ]);

        $station = Station::create($attrs);
        return new StationResource($station);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Station $station)
    {
        return new StationResource($station);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Station $station)
    {
        $attrs = $request->validate([
            'name'=> ['required', 'unique:stations,name', 'max:50'],
            'location' => ['required', 'max:50']
        ]);

        $station->update($attrs);
        return new StationResource($station);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Station $station)
    {
        $station->delete();
        return new StationCollection(Station::all());
    }
}
