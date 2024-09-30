<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketsExport implements FromCollection
{
  public function collection()
  {
    return Ticket::all();
  }
}
