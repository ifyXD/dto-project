<?php

namespace App\Http\Livewire\Admin;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SaleComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $monthlySalesData;
    public $monthyear;
    public $search;
    public $loading = false;

    protected $listeners = ['updateChart' => 'loadMonthlySalesData'];
    protected $debug = true;



    public function loadMonthlySalesData()
    {
        $this->loading = true;

        // Check if both monthyear and search are null or empty
        if (empty($this->monthyear) && empty($this->search)) {
            $this->resetfield();
        } else {
            $query = Sale::query();

            // Apply search filter
            if ($this->search) {
                $query->where('name', 'like', '%' . $this->search . '%');
            }

            // Apply month and year filter
            if ($this->monthyear && !$this->search) {
                $query->whereYear('created_at', '=', substr($this->monthyear, 0, 4))
                    ->whereMonth('created_at', '=', substr($this->monthyear, 5, 2));
            }

            // Fetch filtered data from the database and aggregate by month
            $filteredData = $query
                ->select(DB::raw("DATE_FORMAT(created_at, '%M') as month"), DB::raw('SUM(subtotal) as total_sales'))
                ->groupBy('month')
                ->get()
                ->pluck('total_sales', 'month')
                ->toArray();

            // Define all months from January to December
            $allMonths = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December',
            ];

            // Merge statically defined months with filtered data, fill with 0 for missing months
            $this->monthlySalesData = array_map(function ($month) use ($filteredData) {
                return [
                    'month' => $month,
                    'total_sales' => $filteredData[$month] ?? 0,
                ];
            }, $allMonths);
        }

        // Emit event to update the chart
        $this->emit('updateChart', $this->monthlySalesData);

        $this->loading = false;
    }



    public function render()
    {
        $query = Sale::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->monthyear) {
            $query->whereYear('created_at', '=', substr($this->monthyear, 0, 4))
                ->whereMonth('created_at', '=', substr($this->monthyear, 5, 2));
        }

        $sales = $query->paginate(5);

        return view('livewire.admin.sale-component', compact('sales'));
    }

    public function updatedMonthyear()
    {
        $this->search = null;
        $this->loadMonthlySalesData(); // Add this line to trigger the monthly data load
    }
    public function updatedSearch()
    {
        $this->monthyear = null;
        $this->loadMonthlySalesData(); // Add this line to trigger the monthly data load
    }
    public function resetfield()
    {

        $this->monthlySalesData = null;
        $this->monthyear = null;
        $this->search = null;
        // Additional properties if any
    }
}
