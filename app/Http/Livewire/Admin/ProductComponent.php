<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    protected $paginationTheme = 'bootstrap';
    public $isOpen = 0;
    public $messageflash = false;
    public $isDeleteOpen = 0;
    public $iteration = 0;
    public $productId;
    public $image;
    public $oldimage;




    // public fields
    public $product_name = '';
    public $description = '';
    public $product_price = '';
    public $product_stock = 0;
    public $product_unit = '';

    // by categoryId
    public $selectCategory = '';
    public $categoryId = '';
    public $store_cat_id = '';


    // Query
    public $search = '';


    public function render()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();
        $categoryBy = Category::where('user_id', Auth::user()->id)->where('id', $this->selectCategory)->first();
        $this->categoryId = $this->selectCategory != '' ? $categoryBy->id : '';
        $units = ProductUnit::orderBy('unit_name', 'ASC')->get();


        $products = Product::where('user_id', Auth::user()->id)
            ->where(function ($query) {
                $query->where('product_name', 'like', "%$this->search%")
                    ->orWhere('price', 'like', "%$this->search%");
            })
            ->when($this->selectCategory, function ($query) {
                return $query->where('category_id', $this->selectCategory);
            })->orderBy('product_name', 'ASC')
            ->paginate(10);

        return view('livewire.admin.product-component', compact('categories', 'categoryBy', 'units', 'products'));
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }


    public function store()
    {
        $this->validateData();

        $imagePath = 'images/default/default.png'; // Default image path

        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();

            // Store the image in the storage path
            $imagePath = $this->image->storeAs('public/images/products', $imageName);

            // Remove 'public/' from the beginning of the image path before saving to the database
            $imagePath = str_replace('public/', '', $imagePath);
        }

        Product::create([
            'user_id' => auth()->user()->id,
            'category_id' => $this->store_cat_id,
            'product_name' => $this->product_name,
            'product_description' => $this->description,
            'stock' => $this->product_stock,
            'price' => $this->product_price,
            'unit' => $this->product_unit,
            'image' => $imagePath,
        ]);
        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'saved');
    }

    public function delete($id)
    {
        $this->isDeleteOpen = true;
        $this->productId = $id;
    }

    public function confirmDelete(Product $store)
    {
        // Check if the image is not the default one
        if ($store->image != 'images/default/default.png') {
            // Delete the image
            Storage::delete('public/' . $store->image);
        }

        // Delete the record
        $store->delete();

        // Close the delete confirmation modal and reset fields
        $this->isDeleteOpen = false;

        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'deleted');
    }


    // update
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->store_cat_id  = $product->category_id;
        $this->product_name = $product->product_name;
        $this->description = $product->product_description;
        $this->product_price = $product->price;
        $this->product_unit = $product->unit;
        $this->product_stock = $product->stock;
        $this->image = $product->image;
        $this->oldimage = $product->image;

        $this->openModal();
    }

    public function validateData()
    {
        $this->validate(
            [
                'store_cat_id' => 'required',
                'product_name' => 'required',
                'product_price' => 'required',
                'product_unit' => 'required',
            ],

            [
                'store_cat_id.required' => 'The category field is required.',
            ]
        );
    }

    public function update()
    {
        $validationRules = [
            'store_cat_id' => 'required',
            'product_name' => 'required',
            'product_price' => 'required',
            'product_unit' => 'required',
        ];


        // If a new image is selected or the old image value changes, apply the image validation
        if ($this->image instanceof \Livewire\TemporaryUploadedFile || $this->image != $this->oldimage) {
            $validationRules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2080';
        }

        $this->validate($validationRules);

        // Find the product by ID
        if ($this->productId) {
            $product = Product::findOrFail($this->productId);

            // Check if $this->image is a Livewire temporary uploaded file
            if ($this->image instanceof \Livewire\TemporaryUploadedFile) {
                // New image is selected, handle image upload and deletion of the old image
                $imageName = time() . '.' . $this->image->getClientOriginalExtension();
                $imagePath = 'images/products/' . $imageName;

                // Store the new image
                $this->image->storeAs('public/images/products', $imageName);

                // Delete the old image if it's not the default image
                if ($product->image != 'images/default/default.png') {
                    Storage::delete('public/' . $product->image);
                }

                // Update other fields
                $product->update([
                    'category_id' => $this->store_cat_id,
                    'product_name' => $this->product_name,
                    'product_description' => $this->description,
                    'price' => $this->product_price, 
                    'unit' => $this->product_unit, 
                    'stock' => $this->product_stock, 
                    'image' => $imagePath, 

                    // Add other fields as needed
                ]);
            } else {
                // No new image is selected, update other fields without changing the existing image
                $product->update([
                    'category_id' => $this->store_cat_id,
                    'product_name' => $this->product_name,
                    'product_description' => $this->description,
                    'price' => $this->product_price, 
                    'unit' => $this->product_unit, 
                    'stock' => $this->product_stock,  
                    // Add other fields as needed
                ]);
            } 

            // Close modal and  reset fields
            $this->closeModal();
            $this->resetFields();
            session()->flash('messageflash', 'updated');
        }
    }


    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
        $this->isDeleteOpen = false;
        $this->resetFields();
    }
    public function resetFields()
    {
        $this->reset([
            'productId',
            'image',
            'oldimage',
            'product_name',
            'description',
            'product_price',
            'product_stock',
            'product_unit',
            'selectCategory',
            'categoryId',
            'store_cat_id',
        ]);

        // Increment $iteration to trigger Livewire re-render
        $this->iteration++;
    }
}
