<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\UserResource;
use App\Models\Ticket;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        $vehicleData = Cache::remember('vehicleData', 60 * 10, function () {
            return Vehicle::select('car_type', DB::raw('count(*) as registeredVehicles'))
                ->groupBy('car_type')
                ->get()
                ->map(function ($vehicle) {
                    $colorMap = [
                        'lonchin' => 'hsl(var(--chart-1))',
                        'mini bus' => 'hsl(var(--chart-2))',
                        'taxi' => 'hsl(var(--chart-3))',
                        'higer' => 'hsl(var(--chart-4))',
                        'bus' => 'hsl(var(--chart-5))',
                    ];

                    return [
                        'vehicleType' => $vehicle->car_type,
                        'registeredVehicles' => $vehicle->registeredVehicles,
                        'fill' => $colorMap[$vehicle->car_type] ?? 'hsl(var(--chart-6))',
                    ];
                });
        });

        // Create an array of all months for the last 5 months
        $months = [];
        for ($i = 0; $i < 5; $i++) {
            $months[] = Carbon::now()->subMonths($i)->format('F'); // Month name
        }

        // Fetching ticket sales data for the last 5 months
        $salesData = Ticket::select(DB::raw("strftime('%Y-%m', created_at) as month"), DB::raw('SUM(price) as totalSales'))
            ->whereBetween('created_at', [Carbon::now()->subMonths(5), Carbon::now()])
            ->groupBy('month')
            ->get()
            ->keyBy('month') // Change to key by month for easy lookup
            ->toArray();

        // echo($salesData);

        // Prepare the final initialData with months and sales
        $initialData = [];
        foreach ($months as $month) {
            $monthKey = Carbon::now()->subMonths(5)->format('Y-m'); // Adjust the format for key lookup
            $totalSales = $salesData[$monthKey] ?? ['totalSales' => 0]; // Use 0 if no sales data exists

            $initialData[] = [
                'month' => $month,
                'totalSales' => (float) $totalSales['totalSales'],
            ];

            // Move to the next month
            Carbon::now()->subMonth(); // Adjust for the next month in the loop
        }

        if($request->user()->hasRole('admin')){
            return Inertia::render('Dashboard',[ 'user' => new UserResource(Auth::user()) ]);
        }

        if($request->user()->hasRole('super admin')){
            return Inertia::render('SuperAdmin/Dashboard', [
                'user' => new UserResource(Auth::user()),
                'vehicleData' => $vehicleData,
                'vehicleChartConfig' => [
                    'registeredVehicles' => ['label' => 'Registered Vehicles'],
                    'lonchin' => ['label' => 'Lonchin', 'color' => 'hsl(var(--chart-1))'],
                    'mini bus' => ['label' => 'Mini Bus', 'color' => 'hsl(var(--chart-2))'],
                    'taxi' => ['label' => 'Taxi', 'color' => 'hsl(var(--chart-3))'],
                    'higer' => ['label' => 'Higer', 'color' => 'hsl(var(--chart-4))'],
                    'bus' => ['label' => 'Bus', 'color' => 'hsl(var(--chart-5))']
                ],
                'initialData' => $initialData,
            ]);
        }
    }

}