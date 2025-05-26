<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExporterController extends Controller
{
    public function exportClients()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }


}
