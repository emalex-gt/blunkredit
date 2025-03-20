<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class CustomerCreateComponent extends Component
{
    public $open=false;
    public $name,$lastname,$email,$address,$phone,$dpi;

    protected $rules = [
        'name' => 'required|max:100|min:1',
        'lastname' => 'required|max:100|min:1',
        'email' => 'required|email',
        'address' => 'required',
        'phone' => 'required',
        'dpi' => 'required',
    ];

    public function render()
    {
        return view('livewire.customer-create-component');
    }
    
    public function save(){

        $this->validate();
        $last_customer_id=Customer::all()->sortDesc()->first();
        Customer::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'dpi' => $this->dpi,
            'code' => ($last_customer_id->id + 1).'-'.strtotime(now()),
            'status' => 1
        ]);

        $this->reset('name','email','lastname','address','phone','dpi','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
