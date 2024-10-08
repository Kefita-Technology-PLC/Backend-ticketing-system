<?php

namespace App\Http\Controllers\Api\v1;

use App\Custom\EthiopianDateCustom;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AssociationCollection;
use App\Http\Resources\Api\AssociationResource;
use App\Http\Resources\Api\AssociationSearchResource;
use App\Models\Association;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    public function searchQueries(Request $request)
    {
        $searchColumns = ['name'];
        $associationQuery = Association::with(['stations','creator','updater']);

        return $this->search($request, $associationQuery, $searchColumns, AssociationSearchResource::class);
    }

     public function getAll(){
        $association = Association::with('stations')->with(['creator','updator'])->get();

        return new AssociationCollection($association);
    }

    public function index()
    {
        $associations = Association::latest()->with(['creator', 'updator'])->paginate(env('PAGINATION_NUMBER', 15));
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
    public function show($id)
    {
        $association = Association::find($id);
        if(!$association){
            return response()->json([
                'status' => false,
                 'message' => 'Association not found.'
            ], 404);
        }
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
    public function destroy($id)
    {

        $association = Association::find($id);
        if(!$association){
            return response()->json([
                'status' => false,
                 'message' => 'Association not found.'
            ], 404);
        }

        $association->delete();
        return response()->json([
            "status"=> true,
            "message" => 'Association Deleted Succesfully.'
        ]);
    }
}
