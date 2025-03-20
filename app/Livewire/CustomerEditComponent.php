<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class CustomerEditComponent extends Component
{
    public $open=false;
    public $customer;

    protected $rules = [
        'customer.name' => 'required|max:100|min:1',
        'customer.lastname' => 'required|max:100|min:1',
        'customer.email' => 'required|email',
        'customer.address' => 'required',
        'customer.phone' => 'required',
        'customer.dpi' => 'required',
    ];

    public function mount(Customer $customer){
        $this->customer=$customer;
    }

    public function render()
    {
        return view('livewire.customer-edit-component');
    }

    public function save()
    {
        $this->validate();
        $this->customer->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
