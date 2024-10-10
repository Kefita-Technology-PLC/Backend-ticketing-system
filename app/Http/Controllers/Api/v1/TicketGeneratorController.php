<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\Http\Resources\DailyReportResource as ResourcesDailyReportResource;
use App\Http\Resources\TicketResource;
use App\Models\Association;
use App\Models\DailyReport;
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
    public function ticketWebsite(Request $request)
    {
        $attrs = $request->validate([
            'station_name' => 'required',
            'arrival_time' => 'required',
            'plate_number' => 'required',
            'service_price' => 'required',
            'origin' => 'required',
            'level' => ['required', 'in:level1,level2,level3'],
            'number_of_passengers' => 'required',
            'deployment_line_id' => 'required',
            'price' => 'required',
            'destination_id' => 'required',
        ]);

        $vehicles = Vehicle::pluck('id', 'plate_number');
        $stations = Station::pluck('id', 'name');
        // $destinations = Station::pluck('id', 'name');
        // $deploymentLines = DeploymentLine::pluck('id', 'origin');

        $station_id = $stations[$attrs['station_name']] ?? null;
        $vehicle_id = $vehicles[$attrs['plate_number']] ?? null;
        // $deployment_line_id = $deploymentLines[$attrs['origin']] ?? null;

        if (!$station_id || !$vehicle_id ) {
            return response()->json([
                'status' => false,
                'error' => 'Station or Vehicle not found'], 404);
        }

        $ticket = Ticket::create([
            'user_id' => Auth::user()->id,
            'vehicle_id' => $vehicle_id,
            'station_id' => $station_id,
            'deployment_line_id' => $request->deployment_line_id,
            'destination_id' => $request->destination_id,
            "arrival_time"=> $request->arrival_time,
            'level'=> $request->level,
            'number_of_passengers' => $request->number_of_passengers,
            'price' => $request->price,
            'service_price' => $request->service_price,
            // 'sold_status' => $request->sold_status,
        ]);

        $ticket->load('user','vehicle','station','deploymentLine', 'destination');

        return new TicketResource($ticket);
    }

    public function ticketPos(Request $request){

        $attrs = $request->validate([  
            // 'station_name' => 'required',
            'ticket_count' => 'required',
            'total_sale' => 'required',
            'revenue' => 'required',
        ]);


        $dailyReport = DailyReport::create([
            'user_id' => Auth::user()->id,
            'ticket_count' => $attrs['ticket_count'],
            'revenue' => $attrs['revenue'],
            'total_sale' => $attrs['total_sale'],
        ]);


        return new ResourcesDailyReportResource($dailyReport);
    }
}
