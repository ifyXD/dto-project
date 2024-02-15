<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SalesReport;
use Dompdf\Options;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($id)
    {
        $sales = Sale::where('reports_id', $id)->get();
        $total = SalesReport::find($id);

        // Create a new instance of Options
        $options = new Options();

        // Set the paper size directly
        $options->set('defaultPaperSize', '78.74mmx7010.4mm');

        // Instantiate the PDF wrapper with the custom options
        $pdf = app('dompdf.wrapper', ['options' => $options]);

        // Generate the PDF using DOMPDF
        $pdf->loadView('livewire.admin.invoice-component', compact('sales', 'total'));

        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}
