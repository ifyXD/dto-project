<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class InvoiceComponent extends Component
{
    public $sale_id;

    public function mount($id)
    {
        $this->sale_id = $id;
        // Use $id for further processing or querying if needed
    }

    public function render()
    {

        $data = [
            // Data to be included in the PDF
            'cartItem' => 'Title',
            'overallTotal' => '100',
            // Add any other data you want to include in the PDF
        ];

        // Instantiate an object of the PDF class
        $pdf = app('dompdf.wrapper');

        // Generate the PDF using DOMPDF
        $pdf->loadView('livewire.admin.invoice-component', $data);

        // You can return the PDF as a download response or do other actions
        // return $pdf->download('your-pdf-filename.pdf');
        return view('livewire.admin.invoice-component')->layout('layouts.invoice');
    }
}
