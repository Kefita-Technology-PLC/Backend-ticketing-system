<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssociationCollection;
use App\Http\Resources\AssociationResource;
use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AssociationCollection(Association::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => ['required', 'unique:associations,name', 'max:200'],
            'establishment_date' => ['required', 'date'],
        ]);

        $association =  Association::create($attrs);
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
            'name' => ['required', 'unique:associatons,name', 'max:200'],
            'establishemnt_date' => ['required', 'date'],
        ]);

        $association->update($attrs);
        return new AssociationResource($association);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {
        $association->delete();
        return new AssociationCollection(Association::all());
    }
}
