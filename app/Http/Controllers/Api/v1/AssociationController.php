<?php

namespace App\Http\Controllers\Api\v1;

use App\Custom\EthiopianDateCustom;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssociationCollection;
use App\Http\Resources\AssociationResource;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $associations = Association::latest()->paginate(env('PAGINATION_NUMBER', 15));
        return new AssociationCollection($associations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => ['required', 'unique:associations,name', 'max:200'],
            'establishment_date' => ['required', 'date'],
            'amharic' => ['boolean'],
        ]);

        if($attrs['amharic']){
            $establish_date = EthiopianDateCustom::input($attrs['establishment_date']);
        }else{
            $establish_date = $attrs['establishment_date'];
        }


        $association =  Association::create([
            'name' => $request->name,
            'establishment_date' => $establish_date,
        ]);

        return new AssociationResource($association);
    }

    /**
     * Display the specified resource.
     */
    public function show(Association $association)
    {
        return new AssociationResource($association);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Association $association)
    {
        $attrs = $request->validate([
            'name' => ['required', 'max:200'],
            'establishment_date' => ['required', 'date'],
            'amharic' => ['boolean']
        ]);

        if($attrs['amharic']){
            $establish_date = EthiopianDateCustom::input($attrs['establishment_date']);
        }else{
            $establish_date = $attrs['establishment_date'];
        }

        $association->update([
            'name' => $request->name,
            'establishment_date' => $establish_date,
        ]);

        return new AssociationResource($association);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {
        $association->delete();
        return response()->json([
            "status"=> true,
            "message" => 'Association Deleted Succesfully.'
        ]);
    }
}
