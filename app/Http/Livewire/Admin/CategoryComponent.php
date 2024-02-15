<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    protected $paginationTheme = 'bootstrap';
    public $isOpen = 0;
    public $messageflash = false;


    // this is fields from database
    public $category_name = '';
    public $description = '';
    public $image = '';
    public $oldimage = '';
    public $iteration = 0;



    public $search = '';

    // initialize for update and delete id
    public $categoryId;

    // delete boolean
    public $isDeleteOpen = 0;


    public function render()
    {
        $categories = Category::where(function ($query) {
            $query->where('category_name', 'like', "%$this->search%")
                ->orWhere('description', 'like', "%$this->search%");
        })
            ->where('user_id', auth()->user()->id)
            ->paginate(10);
        $data = array('red', 'green', 'blue');
        return view('livewire.admin.category-component', compact('categories'));
    }
    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    // start save record
    public function store()
    {
        $validatedData = $this->validate([
            'category_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2080'
        ]);

        $imagePath = 'images/default/default.png'; // Default image path

        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();

            // Store the image in the storage path
            $imagePath = $this->image->storeAs('public/images/categories', $imageName);

            // Remove 'public/' from the beginning of the image path before saving to the database
            $imagePath = str_replace('public/', '', $imagePath);
        }

        Category::create([
            'user_id' => auth()->user()->id,
            'category_name' => $validatedData['category_name'],
            'description' => $this->description, // Assuming $this->location is set somewhere in your code
            'image' => $imagePath,
        ]);
        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'saved');
    }

    public function delete($categoryId)
    {
        $this->isDeleteOpen = true;
        $this->categoryId = $categoryId;
    }

    public function confirmDelete(Category $category)
    {
        // Check if the image is not the default one
        if ($category->image != 'images/default/default.png') {
            // Delete the image
            Storage::delete('public/' . $category->image);
        }

        // Delete the record
        $category->delete();

        // Close the delete confirmation modal and reset fields
        $this->isDeleteOpen = false;

        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'deleted');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->category_name = $category->category_name;
        $this->description = $category->description;
        $this->image = $category->image;
        $this->oldimage = $category->image;

        $this->openModal();
    }

    public function update()
    {
        $validationRules = [
            'category_name' => 'required',
        ];

        // If a new image is selected or the old image value changes, apply the image validation
        if ($this->image instanceof \Livewire\TemporaryUploadedFile || $this->image != $this->oldimage) {
            $validationRules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2080';
        }

        $this->validate($validationRules);

        // Find the product by ID
        if ($this->categoryId) {
            $product = Category::findOrFail($this->categoryId);

            // Check if $this->image is a Livewire temporary uploaded file
            if ($this->image instanceof \Livewire\TemporaryUploadedFile) {
                // New image is selected, handle image upload and deletion of the old image
                $imageName = time() . '.' . $this->image->getClientOriginalExtension();
                $imagePath = 'images/categories/' . $imageName;

                // Store the new image
                $this->image->storeAs('public/images/categories', $imageName);

                // Delete the old image if it's not the default image
                if ($product->image != 'images/default/default.png') {
                    Storage::delete('public/' . $product->image);
                }

                // Update other fields
                $product->update([
                    'category_name' => $this->category_name,
                    'description' => $this->description,
                    'image' => $imagePath,

                    // Add other fields as needed
                ]);
            } else {
                // No new image is selected, update other fields without changing the existing image
                $product->update([
                    'category_name' => $this->category_name,
                    'description' => $this->description,
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
            'category_name',
            'description',
            'image',
            'oldimage',
        ]);
        // Increment $iteration to trigger Livewire re-render
        $this->iteration++;
    }
}
