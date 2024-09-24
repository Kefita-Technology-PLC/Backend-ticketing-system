<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\StationCollection;
use App\Http\Resources\Api\StationResource;
use App\Http\Resources\Api\StationSearchResource;
use App\Models\Association;
use App\Models\Station;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    public function searchQueries(Request $request)
    {
        $searchColumns = ['name', 'location'];
        $stationQuery = Station::with(['updater','creator']);

        return $this->search($request, $stationQuery, $searchColumns, StationSearchResource::class);
    }

    public function getAll(){
        $station = Station::orderBy('name', 'asc')->with(['updater', 'creator'])->get();
        return new StationCollection($station);
    }

    public function index()
    {
        $station = Station::latest()->with(['updater','creator'])->paginate(env('PAGINATION_NUMBER', 15));

        return new StationCollection($station);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name'=> ['required', 'unique:stations,name', 'max:100'],
            'location' => ['required', 'max:50'],
            'associations' => ['array'],
        ]);

       // return $attrs['associations'];

        $station = Station::create(Arr::except($attrs, 'associations'));

        foreach($attrs['associations'] as $association){
            $station->association($association);
        }
        return new StationResource($station);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       // return $station;
        $station = Station::find($id);
        if(!$station){
            return response()->json([
                'status' => false,
                 'message' => 'Station not found.'
            ], 404);
        }
        return new StationResource($station);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Station $station)
    {
        $attrs = $request->validate([
            'name'=> ['required', 'max:50'],
            'location' => ['required', 'max:100'],
            'associations' => ['array'],
        ]);

        $associations = Association::pluck('name');
        foreach($associations as $association){
            $station->removeAssociation($association);
        }

        foreach($attrs['associations'] as $association){
            $station->association($association);
        }

        $station->update(Arr::except($attrs, 'associations'));
        return new StationResource($station);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $station = Station::find($id);
        if(!$station){
            return response()->json([
                'status' => false,
                 'message' => 'Station not found.'
            ], 404);
        }
        $station->delete();
        return response()->json([
            'status' => true,
            'message' => 'Station Deleted Successfully.',
        ]);
    }
}
