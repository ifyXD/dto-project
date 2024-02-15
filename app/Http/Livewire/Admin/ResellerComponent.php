<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ResellerComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    protected $paginationTheme = 'bootstrap';
    public $isOpen = 0;
    public $messageflash = false;


    // this is fields from database
    public $reseller_name = '';
    public $location = '';
    public $contact_number = '';
    public $image = '';
    public $oldimage = '';
    public $iteration = 0;



    public $search = '';

    // initialize for update and delete id
    public $resellerId;

    // delete boolean
    public $isDeleteOpen = 0;

    public function render()
    {
        return view('livewire.admin.reseller-component');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }
    public function store() {
        
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
            'reseller_name',
            'location',
            'contact_number',
            'image',
            'oldimage',
            'resellerId',
        ]);
        // Increment $iteration to trigger Livewire re-render
        $this->iteration++;
    }
}
