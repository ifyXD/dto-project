<?php

namespace App\Http\Livewire\Admin;

use App\Models\Store;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StoreComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    protected $paginationTheme = 'bootstrap';
    public $isOpen = 0;
    public $messageflash = false;


    // this is fields from database
    public $store_name = '';
    public $location = '';
    public $image = '';
    public $oldimage = '';
    public $iteration = 0;



    public $search = '';

    // initialize for update and delete id
    public $storeId;

    // delete boolean
    public $isDeleteOpen = 0;

    public function render()
    {
        $stores = Store::where(function ($query) {
            $query->where('store_name', 'like', "%$this->search%")
                ->orWhere('location', 'like', "%$this->search%");
        })
            ->where('user_id', auth()->user()->id)
            ->paginate(10);

        return view('livewire.admin.store-component', [
            'stores' => $stores,
        ]);
    }

    // click create modal
    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    // save data
    public function store()
    {
        $validatedData = $this->validate([
            'store_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2080'
        ]);

        $imagePath = 'images/default/default.png'; // Default image path

        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();

            // Store the image in the storage path
            $imagePath = $this->image->storeAs('public/images/stores', $imageName);

            // Remove 'public/' from the beginning of the image path before saving to the database
            $imagePath = str_replace('public/', '', $imagePath);
        }

        Store::create([
            'user_id' => auth()->user()->id,
            'store_name' => $validatedData['store_name'],
            'location' => $this->location, // Assuming $this->location is set somewhere in your code
            'image' => $imagePath,
        ]);
        $this->resetFields();
        $this->closeModal();
        session()->flash('messageflash', 'saved');
    }



    // update
    public function edit($storeId)
    {
        $store = Store::findOrFail($storeId);
        $this->storeId = $storeId;
        $this->store_name = $store->store_name;
        $this->location = $store->location;
        $this->image = $store->image;
        $this->oldimage = $store->image;

        $this->openModal();
    }

    public function update()
    {
        // Validate other fields
        $validationRules = [
            'store_name' => 'required',
        ];

        // If a new image is selected or the old image value changes, apply the image validation
        if ($this->image instanceof \Livewire\TemporaryUploadedFile || $this->image != $this->oldimage) {
            $validationRules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2080';
        }

        $this->validate($validationRules);

        // Find the store by ID
        if ($this->storeId) {
            $store = Store::findOrFail($this->storeId);

            // Check if $this->image is a Livewire temporary uploaded file
            if ($this->image instanceof \Livewire\TemporaryUploadedFile) {
                // New image is selected, handle image upload and deletion of the old image
                $imageName = time() . '.' . $this->image->getClientOriginalExtension();
                $imagePath = 'images/stores/' . $imageName;

                // Store the new image
                $this->image->storeAs('public/images/stores', $imageName);

                // Delete the old image if it's not the default image
                if ($store->image != 'images/default/default.png') {
                    Storage::delete('public/' . $store->image);
                }

                // Update other fields
                $store->update([
                    'store_name' => $this->store_name,
                    'location' => $this->location,
                    'image' => $imagePath,
                    // Add other fields as needed
                ]);
            } else {
                // No new image is selected, update other fields without changing the existing image
                $store->update([
                    'store_name' => $this->store_name,
                    'location' => $this->location,
                    // Add other fields as needed
                ]);
            }

            // Close modal and  reset fields
            $this->closeModal();
            $this->resetFields();
            session()->flash('messageflash', 'updated');
        }
    }
    // delete

    public function delete($id)
    {
        $this->isDeleteOpen = true;
        $this->storeId = $id;
    }
    public function confirmDelete(Store $store)
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


    // modal
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

    // search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // reset fields
    public function resetFields()
    {
        // Reset all fields including the image
        $this->store_name = '';
        $this->location = '';
        $this->image = null; // Reset the image property to null
        $this->storeId = null;

        // Increment $iteration to trigger Livewire re-render
        $this->iteration++;
    }
}
