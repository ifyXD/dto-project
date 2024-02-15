<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesReport;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PosComponent extends Component
{

    // query
    public $categoryId = '';
    public $search = '';
    public $itemCount = 0;
    public $itemCountChanged = false;

    public $showItem = false;
    public $cartItem = [];
    public $currentQtyById =  [];
    public $overallTotal = 0;
    public $cashInput = 0;
    public $balance = 0;
    
    public $salesReportId = '';

    // paid
    public $isPaid = false;


    public function render()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();

        $products = Product::where('user_id', Auth::user()->id)
            ->where(function ($query) {
                $query->where('product_name', 'like', "%$this->search%")
                    ->orWhere('price', 'like', "%$this->search%");
            })
            ->when($this->categoryId, function ($query) {
                return $query->where('category_id', $this->categoryId);
            })->orderBy('product_name', 'ASC')
            ->paginate(10);
        return view('livewire.admin.pos-component', compact('categories', 'products'))->layout('layouts.pos.base');
    }
    public function byCategory($id)
    {
        if ($id == 0) {
            $this->categoryId = '';
            // dd($categoryId);
        } else {
            $this->categoryId = $id;
            // dd($categoryId);
        }
    }

    public function increment($id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404); // Or handle the case where the product is not found in a way that makes sense for your application.
        }

        // Check if the product is already in the cart
        $existingCartItemIndex = collect($this->cartItem)->search(function ($cartItem) use ($product) {
            return $cartItem['id'] == $product->id;
        });

        if ($existingCartItemIndex !== false) {
            // If the product is already in the cart, check if incrementing exceeds the stock limit
            if ($this->cartItem[$existingCartItemIndex]['quantity'] < $product->stock && $product->stock > 0) {
                // Increment the quantity for the specific product
                $this->cartItem[$existingCartItemIndex]['quantity']++;
                $this->currentQtyById[$id]++;

                // Decrease the stock
                $product->stock--;

                $this->itemCountChanged = true;
            } else {
                // Handle the case where quantity exceeds or equals the stock limit
                // You may want to show a message, prevent further incrementing, etc.
                // For now, let's just prevent further incrementing without any message
                return;
            }
        } else {
            // If the product is not in the cart, add it with quantity 1
            $this->cartItem[] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'quantity' => 1,
                'price' => $product->price,
                'stock' => $product->stock
            ];
            $this->currentQtyById[$id] = 1;

            // Decrease the stock
            $product->stock--;

            $this->itemCountChanged = true;
        }

        // Recalculate the total quantity
        $this->itemCount = collect($this->cartItem)->sum('quantity');
        $this->updateOverallTotal();
    }




    public function decrement($id)
    {
        $this->itemCountChanged = true;
        $product = Product::find($id);

        if (!$product) {
            abort(404); // Or handle the case where the product is not found in a way that makes sense for your application.
        }

        // Check if the product is already in the cart
        $existingCartItemIndex = collect($this->cartItem)->search(function ($cartItem) use ($product) {
            return $cartItem['id'] == $product->id;
        });

        if ($existingCartItemIndex !== false) {
            // If the product is already in the cart, check if decrementing is possible
            if ($this->cartItem[$existingCartItemIndex]['quantity'] > 1) {
                $this->cartItem[$existingCartItemIndex]['quantity']--;
                $this->currentQtyById[$id]--; // Decrement the quantity for the specific product
            } else {
                // If the quantity is 1 or less, you may want to remove the item from the cart
                array_splice($this->cartItem, $existingCartItemIndex, 1);
                unset($this->currentQtyById[$id]); // Remove the quantity for the specific product
            }
        }

        // Recalculate the total quantity
        $this->itemCount = collect($this->cartItem)->sum('quantity');
        $this->updateOverallTotal();
    }

    private function updateOverallTotal()
    {
        // Calculate the overall total based on the price and quantity of each item
        $this->overallTotal = collect($this->cartItem)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Update balance when overallTotal changes
        $this->updatedCashInput();
    }
    public function updatedCashInput()
    {
        // Ensure the cash input is a valid number
        $cash = is_numeric($this->cashInput) ? floatval($this->cashInput) : 0;

        // Calculate the balance
        $this->balance =  $cash - $this->overallTotal;

        // If cash is zero, set cashInput to empty string
        if ($cash == 0) {
            $this->cashInput = '';
        }
    }



    public function bastketItem()
    {
        $this->itemCountChanged = false;

        if ($this->showItem) {
            $this->showItem = false;
        } else {
            $this->showItem = true;
        }
    }
    public function generatePDF($id)
    {
        $newTabUrl = route('invoice', ['id' => $id]);

        // Emit a Livewire event to inform the front-end about the new URL
        $this->emit('openNewTab', $newTabUrl);
    }

    public function confirmPayment()
    {
        $this->emit('confirmPayment');
    }

    public function pay()
    {
        // Ensure there are items in the cart before proceeding
        if (count($this->cartItem) > 0) {
            $this->isPaid = true;

            // Loop through cart items and create Sale records
            foreach ($this->cartItem as $item) {
                // Update the stock in the Product model
                $product = Product::find($item['id']);

                if ($product) {
                    // Ensure the stock is greater than or equal to the quantity being sold
                    if ($product->stock >= $item['quantity']) {
                        $product->stock -= $item['quantity'];
                        $product->save();
                    } else {
                        // Handle the case where the stock is insufficient (optional)
                        // You may want to show a message, prevent further processing, etc.
                        // Example: throw new \Exception("Insufficient stock for product: {$product->product_name}");
                    }
                }
            }

            // Create a new SalesReport
            $salesReport = SalesReport::create([
                'user_id' => auth()->user()->id,
                'cash' => $this->cashInput,
                'total' => $this->overallTotal,
                'balance' => $this->balance,
                'date' => now(),
            ]);

            $this->salesReportId = $salesReport->id;

            // Loop through cart items and create Sale records
            foreach ($this->cartItem as $item) {
                Sale::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $item['id'],
                    'reports_id' => $salesReport->id,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            } 
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Payment Successful!',
                'text' => 'Your payment has been processed successfully.',
            ]);
        }
    }

    public function close()
    {
        $this->reset([
            'categoryId',
            'search',
            'itemCount',
            'itemCountChanged',
            'showItem',
            'cartItem',
            'currentQtyById',
            'overallTotal',
            'cashInput',
            'balance',
            'isPaid',
            'salesReportId',
        ]);
    }
}
