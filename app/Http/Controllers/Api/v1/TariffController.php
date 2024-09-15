<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TariffCollection;
use App\Http\Resources\TariffResource;
use App\Models\DeploymentLine;
use App\Models\Tariff;
use App\Rules\UniqueOriginDestination;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    public function searchQueries(Request $request){
        $searchColumns = ['created_at'];
        $tariffQuery = Tariff::with('station');

        return $this->search($request, $tariffQuery, $searchColumns);
    }
    
    public function index()
    {
        $tariffs = Tariff::with('station')->latest()->paginate(env('PAGINATION_NUMBER', 10));
        return new TariffCollection($tariffs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'station_id' => 'required',
            'distance' => 'required|integer',
            'origin' => ['required', new UniqueOriginDestination($request->origin, $request->destination)],
            'destination' => 'required',
            'car_type' => 'required',
            'level1_price' => 'required|numeric',
            'level2_price' => 'required|numeric',
            'level3_price' => 'required|numeric'
        ]);

        $tariff = Tariff::create($attrs);
        $tariff->load('station');
        return new TariffResource($tariff);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tariff = Tariff::find($id);
        if(!$tariff){
            return response()->json([
                'status' => false,
                 'message' => 'Tariff not found.'
            ], 404);
        }

        $tariff->load('station');

        return new TariffResource($tariff);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tariff $tariff)
    {
        $attrs = $request->validate([
            'station_id' => 'required',
            'distance' => 'required|integer',
            'origin' => ['required'],
            'destination' => 'required',
            'car_type' => 'required',
            'level1_price' => 'required|numeric',
            'level2_price' => 'required|numeric',
            'level3_price' => 'required|numeric'
        ]);

        $tariff->update($attrs);
        $tariff->load('station');
        return new TariffResource($tariff);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tariff = Tariff::find($id);
        if(!$tariff){
            return response()->json([
                'status' => false,
                 'message' => 'Tariff not found.'
            ], 404);
        }
        $tariff->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Tariff deleted successfully'
        ]);
    }
}
