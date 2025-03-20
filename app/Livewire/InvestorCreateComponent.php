<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Investors;

class InvestorCreateComponent extends Component
{
    public $open=false;
    public $type,$name,$lastname,$email,$address,$phone,$dpi;

    protected $rules = [
        'type' => 'required',
        'name' => 'required|max:100|min:1',
        'lastname' => 'required|max:100|min:1',
        'email' => 'required|email',
        'address' => 'required',
        'phone' => 'required',
        'dpi' => 'required',
    ];

    public function render()
    {
        return view('livewire.investor-create-component');
    }
    
    public function save(){

        $this->validate();
        Investors::create([
            'type' => $this->type,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'dpi' => $this->dpi,
            'status' => 1
        ]);

        $this->reset('type','name','email','lastname','address','phone','dpi','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
