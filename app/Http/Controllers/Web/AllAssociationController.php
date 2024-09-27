<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\AllAssociationIndexResource;
use App\Models\Association;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AllAssociationController extends Controller
{
    public function index(){

        $query = Association::query();
        $sortField = request('sort_field','created_at');
        $sortDirection = request('sort_direction', 'desc');

        if(request('name')){
            $query->where('name','like','%'.request('name').'%');
        }

        $associations = $query->orderBy($sortField, $sortDirection)->with('creator','updater')->paginate(10);

        return Inertia::render('all-associations/Index',[
            'associations' => AllAssociationIndexResource::collection($associations),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=> 'required|max:150',
            'establishment_date' => '',
        ]);

        $association = Association::create($validate);
        $association->created_by = auth()->id();
        $association->save();
        $name = $association->name;
        return to_route('all-associations.index')->with('success', 'An association called '.$name.' created successfully');
    }

    public function update(Request $request, $id){
        $association = Association::findOrFail($id);

        $validate = $request->validate([
            'name'=> 'required|max:150',
            'establishment_date' => '',
        ]);

        $association->update($validate);
        $association->updated_by = auth()->id();
        $association->save();
        
        $name = $association->name;

        return to_route('all-associations.index')->with('success', 'An association called '.$name.' is updated successfully');

    }

    public function destroy(string $id){
        $association = Association::findOrFail($id);
        $name = $association->name;
        $association->delete();
        return to_route('all-associations.index')->with('success','An association called '.$name.'is deleted successfully');
    }
}
