<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Category;

class Dashboard extends Component
{
    public $currentYear;
    public $totalSales;
    public $todaySalesTotal;
    public $productCount;
    public $categoryCount;

    public function mount()
    {
        $this->currentYear = now()->year;
        $this->calculateTotalSales();
        $this->calculateTodaySalesTotal();
        $this->calculateProductCount();
        $this->calculateCategoryCount();
    }

    public function calculateTotalSales()
    {
        $sales = Sale::whereYear('created_at', $this->currentYear)->get();
        $this->totalSales = $sales->sum('subtotal');
    }

    public function calculateTodaySalesTotal()
    {
        $today = now()->toDateString();
        $todaySales = Sale::whereDate('created_at', $today)->get();
        $this->todaySalesTotal = $todaySales->sum('subtotal');
    }

    public function calculateProductCount()
    {
        $this->productCount = Product::count();
    }

    public function calculateCategoryCount()
    {
        $this->categoryCount = Category::count();
    }

    // public function getMonthlySalesData()
    // {
    //     // Fetch actual data from the database using MONTH() function
    //     $monthlySales = Sale::whereYear('created_at', $this->currentYear)
    //         ->selectRaw('MONTH(created_at) as month, COALESCE(sum(subtotal), 0) as total')
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('total', 'month')
    //         ->toArray();

    //     // Initialize an array with all months and set total sales to 0
    //     $data = array_fill(1, 12, 0);

    //     // Populate data with actual sales values
    //     $data = array_replace($data, $monthlySales);

    //     // Return indexed array
    //     return array_values($data);
    // }



    public function render()
    {
        // $monthlySales = $this->getMonthlySalesData();
        // dd($monthlySales); // Add this line for debugging

        return view('livewire.dashboard', [
            'totalSales' => $this->totalSales ?? 0,
            'todaySalesTotal' => $this->todaySalesTotal ?? 0,
            'productCount' => $this->productCount ?? 0,
            'categoryCount' => $this->categoryCount ?? 0,
            // 'monthlySales' => is_array($monthlySales) ? $monthlySales : [],
        ]);
    }
}
