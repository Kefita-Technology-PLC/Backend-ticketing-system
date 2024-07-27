<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Association;
use App\Models\DeploymentLine;
use App\Models\Station;
use App\Models\Ticket;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketGeneratorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $attrs = $request->validate([
            'station_name' => 'required',
            'deployment_line' => 'required',
            'arrival_time' => 'required',
            'plate_number' => 'required',
            'service_price' => 'required',
            'origin' => 'required',
            'level' => ['required', 'in:level1,level2,level3'],
            'number_of_passengers' => 'required',
            'service_price' => '',
        ]);

        $vehicles = Vehicle::pluck('id', 'plate_number');
        $stations = Station::pluck('id', 'name');
        $deploymentLines = DeploymentLine::pluck('id', 'origin');

        $station_id = $stations[$attrs['station_name']] ?? null;
        $vehicle_id = $vehicles[$attrs['plate_number']] ?? null;
        $deployment_line_id = $deploymentLines[$attrs['origin']] ?? null;

        if (!$station_id || !$vehicle_id || !$deployment_line_id) {
            return response()->json([
                'status' => false,
                'error' => 'Station, Association or Deployment line not found'], 404);
        }

        $vehicle = Vehicle::find($vehicle_id);

        $ticket = Ticket::create([
            'user_id' => Auth::user()->id,
            'vechicle_id' => $vehicle_id,
            'station_id' => $station_id,
            'deployment_line_id' => $deployment_line_id,
            'level'=> $request->level,
            'number_of_passengers' => $request->number_of_passengers,
            'price' => $request->price,
            'service_price' => $request->service_price,
            'sold_status' => $request->sold_status,
        ]);
        return new TicketResource($ticket);
    }
}
