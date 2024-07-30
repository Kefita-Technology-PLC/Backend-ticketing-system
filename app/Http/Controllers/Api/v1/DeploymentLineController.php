<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeploymentCollection;
use App\Http\Resources\DeploymentResource;
use App\Models\DeploymentLine;
use Illuminate\Http\Request;

class DeploymentLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deployments = DeploymentLine::latest()->paginate(env('PAGINATION_NUMBER', 15));

        return new DeploymentCollection($deployments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'origin' => ['required', 'string', 'max:250'],
            'destination' => ['required', 'string', 'max:250'],
            //'arrival' => [ 'in:pending,arrival, ']
        ]);

        $deploymentLine = DeploymentLine::create($attrs);
        return new DeploymentResource($deploymentLine);        

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $deploymentLine = DeploymentLine::find($id);
        if(!$deploymentLine){
            return response()->json([
                'status' => false,
                 'message' => 'Deployment line not found.'
            ]);
        }

        return new DeploymentResource($deploymentLine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeploymentLine $deploymentLine)
    {
        $attrs = $request->validate([
            'origin' => ['required', 'string', 'max:250'],
            'destination' => ['required', 'string', 'max:250'],
            'arrival' => [ 'in:pending,arrival']
        ]);

        $deploymentLine->update($attrs);
        return new DeploymentResource($deploymentLine);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deploymentLine = DeploymentLine::find($id);
        if(!$deploymentLine){
            return response()->json([
                'status' => false,
                 'message' => 'Deployment line not found.'
            ]);
        }
        $deploymentLine->delete();
        return response()->json([
            'status' => false,
             'message' => 'Deploymnet line deleted successfully.'
        ]);
    }
}
