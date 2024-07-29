<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use App\Custom\EthiopianDateCustom;
use Illuminate\Http\Requesst;

class ReportController extends Controller
{
    public function dailyReport(){

        $today = Carbon::today();
        $ticket_numbers = Ticket::where('created_at', $today)->count();
        $vehicles = Vehicle::where('created_at', $today)->count();
        $total_price = Ticket::where('created_at', $today)->sum('price');
        $associations = Association::where('created_at', $today)->count();

        $ticketSellersCount = User::role('ticket seller')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->count();

        $adminsCount = User::role('admin')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->count();

        return response()->json([
            'status' => true,
            'data' => [
                'ticket_numbers' => $ticket_numbers,
                'vehicles' => $vehicles,
                'total_price' => $total_price,
                'ticket_sellers' => $ticketSellersCount,
                'admins' => $adminsCount,
                'associations_number' => $associations,
            ]
        ]);
    }

    public function weeklyReport(){
        $startOfWeek = Carbon::now()->startOfWeek();    
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyTicketNumbers = Ticket::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        $weeklyVehicles = Vehicle::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        $weeklyTotalPrice = Ticket::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('price');

        $associations = Association::whereBetween('created_at',[$startOfWeek, $endOfWeek] )->count();

        $ticketSellersCount = User::role('ticket seller')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfWeek, $endOfWeek])
        ->count();


        $adminsCount = User::role('admin')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfWeek, $endOfWeek])
        ->count();

        return response()->json([
            'status' => true,
            'data' => [
                'ticket_numbers' => $weeklyTicketNumbers,
                'vehicles' => $weeklyVehicles,
                'total_price' => $weeklyTotalPrice,
                'ticket_sellers' => $ticketSellersCount,
                'admins' => $adminsCount,
                'associations_number' => $associations,
            ]
        ]);
      
    }

    public function monthlyReport(){
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Count the number of tickets sold this month
        $monthlyTicketNumbers = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Count the number of vehicles created this month
        $monthlyVehicles = Vehicle::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Calculate the total price of all tickets sold this month
        $monthlyTotalPrice = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('price');

        $associations = Association::whereDate('created_at',[$startOfMonth, $endOfMonth] )->count();

        $ticketSellersCount = User::role('ticket seller')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfMonth, $endOfMonth])
        ->count();


        $adminsCount = User::role('admin')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfMonth, $endOfMonth])
        ->count();

        return response()->json([
            'status' => true,
            'data' => [
                'ticket_numbers' => $monthlyTicketNumbers,
                'vehicles' => $monthlyVehicles,
                'total_price' => $monthlyTotalPrice,
                'ticket_sellers' => $ticketSellersCount,
                'admins' => $adminsCount,
                'associations_number' => $associations,
            ]
        ]);

    }

    public function yearlyReport(Request $request){

        $attrs = $request->validate([
            'start_year' => 'required|date',
            'end_year' => 'required|date'
        ]);

        $startOfYear = EthiopianDateCustom::input($request->start_year);
        $endOfYear = EthiopianDateCustom::input($request->start_year);

        // Count the number of tickets sold this month
        $yearlyTicketNumbers = Ticket::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

        // Count the number of vehicles created this month
        $yearlyVehicles = Vehicle::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

        // Calculate the total price of all tickets sold this month
        $yearlyTotalPrice = Ticket::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('price');

        $associations = Association::whereDate('created_at',[$startOfYear, $endOfYear] )->count();

        $ticketSellersCount = User::role('ticket seller')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfYear, $endOfYear])
        ->count();


        $adminsCount = User::role('admin')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfYear, $endOfYear])
        ->count();

        return response()->json([
            'status' => true,
            'data' => [
                'ticket_numbers' => $yearlyTicketNumbers,
                'vehicles' => $yearlyVehicles,
                'total_price' => $yearlyTotalPrice,
                'ticket_sellers' => $ticketSellersCount,
                'admins' => $adminsCount,
                'associations_number' => $associations,
            ]
        ]);
    }

    public function customDateReport(Request $request){

        $attrs = $request->validate([
            'start_year' => 'required|date',
            'end_year' => 'required|date'
        ]);

        $startOfYear = EthiopianDateCustom::input($request->start_year);
        $endOfYear = EthiopianDateCustom::input($request->start_year);

        // Count the number of tickets sold this month
        $yearlyTicketNumbers = Ticket::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

        // Count the number of vehicles created this month
        $yearlyVehicles = Vehicle::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

        // Calculate the total price of all tickets sold this month
        $yearlyTotalPrice = Ticket::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('price');

        $associations = Association::whereDate('created_at',[$startOfYear, $endOfYear] )->count();

        $ticketSellersCount = User::role('ticket seller')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfYear, $endOfYear])
        ->count();


        $adminsCount = User::role('admin')
        ->whereHas('roles', function ($query) {
            $query->where('guard_name', 'api');
        })
        ->whereBetween('created_at',[$startOfYear, $endOfYear])
        ->count();

        return response()->json([
            'status' => true,
            'data' => [
                'ticket_numbers' => $yearlyTicketNumbers,
                'vehicles' => $yearlyVehicles,
                'total_price' => $yearlyTotalPrice,
                'ticket_sellers' => $ticketSellersCount,
                'admins' => $adminsCount,
                'associations_number' => $associations,
            ]
        ]);
    }

}
