<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\AllStationIndexResource;
use App\Models\Station;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AllStationController extends Controller
{
    public function index(){
        $query = Station::query();
        $sortField = request('sort_field','created_at');
        $sortDirection = request('sort_direction', 'desc');

        if(request('name')){
            $query->where('name','like','%'.request('name').'%');
        }

        // dd($query);

        $stations = $query->orderBy($sortField, $sortDirection)->with('creator','updater')->paginate(10);

        // dd($stations);

        return Inertia::render('all-stations/Index',[
            'stations' => AllStationIndexResource::collection($stations),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=> 'required|max:150',
            'location' => 'required'
        ]);

        $station = Station::create($request->all());
        $name = $station->name;

        return redirect()->route('all-stations.index')->with('success','A station called '.$name.' is created successfully');
    }

    public function update(Request $request, $id){
        $validate = $request->validate([
            'name'=> 'required|max:150',
            'location' => 'required'
        ]);

        $station = Station::find($id);
        $station->update($request->all());
        $name = $station->name;

        return redirect()->route('all-stations.index')->with('success','A station called'.$name.' is created successfully');
    }

    public function destroy($id){
        $station = Station::find($id);
        $name = $station->name;
        $station->delete();

        return redirect()->route('all-stations.index')->with('success','A Station called'.$name.' is deleted successfully');
    }
}
