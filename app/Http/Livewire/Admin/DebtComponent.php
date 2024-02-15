<?php

namespace App\Http\Livewire\Admin;

use App\Models\Debt;
use App\Models\DebtInformation;
use App\Models\DebtLog;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DebtComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    protected $paginationTheme = 'bootstrap';
    public $isOpen = 0;
    public $isOpenLog = 0;
    public $messageflash = false;


    // this is fields from database
    public $debtor_name = '';
    public $debtor_number = '';
    public $debtor_location = '';
    public $debt_amount = '';
    public $description = '';
    public $issue_date = '';
    public $due_date = '';
    public $debt_id = '';
    public $debt_status = '';

    // about the products
    public $product_name = '';
    public $product_price = '';
    public $product_qty = '';


    public $productchecked = [];
    public $checkedProducts = [];
    public $productQuantities = [];

    public $search = '';
    public $productsearch = '';
    public $productss = [];

    // validation
    protected $rules = [
        'debtor_name' => 'required',
        'debtor_number' => 'required',
        'debtor_location' => 'required',
        'debt_amount' => 'required',
        'issue_date' => 'required',
        'due_date' => 'required',
    ];


    // for logs
    // array logs 
    public $logs_arr = [];
    public $debt_log_id = '';
    public $rep_name = '';
    public $debt_log_amount = '';
    public $debt_log_date = '';

    // checking log status
    public $log_status = '';
    public $debt_log_status = '';


    // initialize for update and delete id
    public $productId;

    // delete boolean
    public $isDeleteOpen = 0;
    public $isDeleteOpenLog = 0;


    // for debt logs 
    public $isLogOpen = false;
    public $logfirst = null;

    // total amount for debt logs by id get
    public $totaldebtamount = '';
    public $totaldebts = '';
    public $remainingdebtamount = '';


    public function mount()
    {
        $this->productss = Product::all();

        // Set default quantity for each product ID
        foreach ($this->productss as $product) {
            $this->productQuantities[$product->id] = 1;
        }
        $this->issue_date = now()->toDateString();
        $this->debt_log_date = now()->toDateString();
    }

    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('product_name', 'like', "%$this->productsearch%");
            // ->orWhere('location', 'like', "%$this->productsearch%");
        })
            ->where('user_id', auth()->user()->id)
            ->paginate(5);

        $debts = DebtInformation::where(function ($query) {
            $query->where('debtor_name', 'like', "%$this->search%");
            // ->orWhere('location', 'like', "%$this->productsearch%");
        })
            ->where('user_id', auth()->user()->id)
            ->paginate(5);
        return view('livewire.admin.debt-component', compact('products', 'debts'));
    }


    // create
    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }
    public function createlog()
    {
        $this->resetFieldsLogs();
        $this->openModalLog();
    }

    public function store()
    {
        // Your store logic here
        $this->validate();

        $debt_info = DebtInformation::create([
            'debtor_name' => $this->debtor_name,
            'debtor_number' => $this->debtor_number,
            'debtor_location' => $this->debtor_location,
            'debt_amount' => $this->debt_amount,
            'description' => $this->description,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'status' => 'pending',
            'user_id' => auth()->user()->id,
        ]);

        // Make sure the $debt_info->id is not null before proceeding
        if ($debt_info->id) {
            foreach ($this->checkedProducts as $checkedProduct) {
                Debt::create([
                    'user_id' => auth()->user()->id,
                    'debt_info_id' => $debt_info->id,
                    'product_id' => $checkedProduct['id'],
                    'product_name' => $checkedProduct['product_name'],
                    'product_price' => $checkedProduct['price'],
                    'product_qty' => $checkedProduct['qty'],
                ]);
            }
        } else {
            // Handle the case where $debt_info->id is null, log an error, or perform any necessary actions.
        }


        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'saved');
    }
    public function storeLog()
    {
        $this->validate([
            'rep_name' => 'required',
            'debt_log_amount' => 'required',
            'debt_log_date' => 'required',
            'debt_log_status' => 'required',
        ]);


        if ($this->debt_log_status == 'paid') {
            // Update the DebtInformation status where $this->debt_id
            $debtInformation = DebtInformation::find($this->debt_id);

            if ($debtInformation) {
                $debtInformation->status = 'paid';
                $debtInformation->save();
            }
        }

        // Save the debt_logs
        DebtLog::create([
            'name' => $this->rep_name,
            'debt_info_id' => $this->debt_id,
            'amount' => $this->debt_log_amount,
            'date' => $this->debt_log_date,
            'log_status' => $this->debt_log_status,
        ]);

        $this->closeModalLog();
        $this->fetchLogs($this->debt_id);
    }
    public function edit($debt_id)
    {

        // dd($debt_id);
        // $this->debt_id = $debt_id;

        $this->debt_id = $debt_id;
        $debt = DebtInformation::findOrFail($this->debt_id);

        $this->debtor_name  = $debt->debtor_name;
        $this->debtor_number  = $debt->debtor_number;
        $this->debtor_location  = $debt->debtor_location;
        $this->debt_amount  = $debt->debt_amount;
        $this->description  = $debt->description;
        $this->issue_date  = $debt->issue_date;
        $this->due_date  = $debt->due_date;
        $this->debt_status  = $debt->status;

        $this->openModal();
    }

    public function deleteLogs($id)
    {
        // $this->openModalLog();

        $this->isDeleteOpenLog = true;
        $this->debt_log_id = $id; 
    }

    public function confirmDeleteLog(DebtLog $debtlog)
    {
        $before_id = $debtlog->debt_info_id;
        $debtlog->delete();

        DebtInformation::findOrFail($before_id)->update([
            'status' => 'pending',
        ]);
        // Close the delete confirmation modal and reset fields
        $this->isDeleteOpenLog = false; 
        $this->resetFieldsLogs();
        $this->closeModalLog();
        $this->fetchLogs($before_id);
        session()->flash('messageflash', 'deleted');
    }
    public function editLogs($debt_id)
    {

        $this->debt_log_id = $debt_id;
        $log = DebtLog::findOrFail($debt_id);
        $this->rep_name  = $log->name;
        $this->debt_log_date  = $log->date;
        $this->debt_log_amount  = $log->amount;
        $this->debt_log_status  = $log->log_status;
        $this->debt_id  = $log->debt_info_id;

        $this->openModalLog();
    }
    public function updateLog()
    {

        $this->validate([
            'rep_name' => 'required',
            'debt_log_amount' => 'required',
            'debt_log_date' => 'required',
            'debt_log_status' => 'required',
        ]);

        if ($this->debt_log_status === 'paid') {
            $debt_log = DebtLog::findOrFail($this->debt_log_id);

            $debt_log->update([
                'name' => $this->rep_name,
                'amount' => $this->debt_log_amount,
                'date' => $this->debt_log_date,
                'log_status' => 'paid',
            ]);

            $debt_info = DebtInformation::findOrFail($this->debt_id);
            $debt_info->update([
                'status' => 'paid',
            ]);
        } else {
            $debt_log = DebtLog::findOrFail($this->debt_log_id);

            $debt_log->update([
                'name' => $this->rep_name,
                'amount' => $this->debt_log_amount,
                'date' => $this->debt_log_date,
                'log_status' => 'pending',
            ]);

            $debt_info = DebtInformation::findOrFail($this->debt_id);
            $debt_info->update([
                'status' => 'pending',
            ]);
        }
        $this->fetchLogs($this->debt_id);
        $this->closeModalLog();
        $this->resetFieldsLogs();
        session()->flash('messageflash', 'updated');
    }

    private function fetchLogs($deb_id)
    {
        // Fetch logs associated with the current debt_id
        $this->logs_arr = DebtLog::where('debt_info_id', $deb_id)->get();
        $this->totaldebtamount = $this->logs_arr->sum('amount');

        $this->logfirst = DebtInformation::find($deb_id);
        $this->log_status = $this->logfirst->status;
        $this->totaldebts = $this->logfirst->debt_amount;
        $this->remainingdebtamount = $this->totaldebts - $this->totaldebtamount;
    }

    public function update()
    {


        $this->validate();

        $debt = DebtInformation::findOrFail($this->debt_id);
        $debt->update([
            'debtor_name' => $this->debtor_name,
            'debtor_number' => $this->debtor_number,
            'debtor_location' => $this->debtor_location,
            'debt_amount' => $this->debt_amount,
            'description' => $this->description,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'status' => 'pending',
        ]);

        // Close modal and  reset fields
        $this->closeModal();
        $this->resetFields();
        session()->flash('messageflash', 'updated');
    }
    public function delete($debt_id)
    {
        $this->isDeleteOpen = true;
        $this->debt_id = $debt_id;
    }
    public function confirmDelete(DebtInformation $debt)
    {
        // Check if the image is not the default one
        

        // Delete the record
        $debt->delete();

        // Close the delete confirmation modal and reset fields
        $this->isDeleteOpen = false;

        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'deleted');
    }

    public function logs($debt_id, $con)
    {

        if ($this->isLogOpen) {
            $this->isLogOpen = false;
            $this->isOpenLog = false;
            $this->debt_id = 0;
        } else {
            $this->isLogOpen = true;
            $this->debt_id = $debt_id;
            $this->fetchLogs($this->debt_id);
        }
    }


    // modal
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function openModalLog()
    {
        $this->isOpenLog = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
        $this->isLogOpen = false;
        $this->isDeleteOpen = false;
        $this->resetFields();
    }
    public function closeModalLog()
    {
        $this->isOpenLog = false;
        $this->isDeleteOpenLog = false;
        
        $this->rep_name = '';
        $this->debt_log_amount = '';
        $this->debt_log_status = '';
        $this->debt_log_id = '';
    }

    // search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // reset fields
    public function resetFields()
    {
        $this->reset(
            'messageflash',
            'debtor_name',
            'debtor_number',
            'debtor_location',
            'debt_amount',
            'description',
            'productchecked',
            'checkedProducts',
            'search',
            'productsearch',
            'productId',
            'due_date',
            'debt_status',
            'debt_id'
        );
    }
    public function resetFieldsLogs()
    {
        $this->reset(
            'rep_name',
            'debt_log_amount',
            'debt_log_status',
            'debt_log_id',
        );
    }
    public function incrementQuantity($productId)
    {
        $productStock = Product::find($productId)->stock;

        if (isset($this->productQuantities[$productId])) {
            $this->productQuantities[$productId] = min($this->productQuantities[$productId] + 1, $productStock);
        } else {
            $this->productQuantities[$productId] = 1;
        }

        // Update the checkedProducts array and debt_amount
        $this->updatedProductchecked();
        $this->due_date = $this->formatDueDate($this->due_date);
    }

    public function decrementQuantity($productId)
    {
        if (isset($this->productQuantities[$productId]) && $this->productQuantities[$productId] > 1) {
            $this->productQuantities[$productId]--;
        }

        // Update the checkedProducts array and debt_amount
        $this->updatedProductchecked();
        $this->due_date = $this->formatDueDate($this->due_date);
    }

    private function formatDueDate($dueDate)
    {
        // Check if $dueDate is not empty before formatting
        return $dueDate ? date('Y-m-d', strtotime($dueDate)) : null;
    }


    // Helper method to update checkedProducts array and debt_amount
    public function updatedProductchecked()
    {
        // Remove duplicate values and keep only unique product IDs
        $this->productchecked = array_unique($this->productchecked);

        // Reset the array before updating with new values
        $this->checkedProducts = [];

        // Initialize the total debt amount
        $totalDebtAmount = 0;

        // Loop through the checked product IDs and store the details
        foreach ($this->productchecked as $productId) {
            $product = Product::find($productId);
            $quantity = $this->productQuantities[$productId] ?? 1; // Default to 1 if quantity is not set

            if ($product) {
                $this->checkedProducts[] = [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'qty' => $quantity,
                    'price' => $product->price
                ];

                // Calculate the contribution of this product to the total debt amount
                $totalDebtAmount += $product->price * $quantity;
            }
        }

        // Update the debt_amount property with the calculated total
        $this->debt_amount = $totalDebtAmount;
    }





    // Add a method to display the names based on the checked IDs
    // public function displayCheckedProductNames()
    // {
    //     $names = collect($this->checkedProducts)->pluck('product_name')->implode(', ');
    //     return $names;
    // }
}
