<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ticket; // Replace with your relevant model
use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index');
    }

    public function exportCsv()
    {
        $tickets = Ticket::all(); // Fetch the data you want to export

        $response = new StreamedResponse(function() use ($tickets) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Price']); // Add the appropriate headers
            
            foreach ($tickets as $ticket) {
                fputcsv($handle, [$ticket->id, $ticket->name, $ticket->price]); // Adjust based on your model
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="tickets.csv"');

        return $response;
    }

    public function exportExcel()
    {
        // You can use a package like Maatwebsite Excel for exporting to Excel
        return Excel::download(new TicketsExport, 'tickets.xlsx');
    }
}
