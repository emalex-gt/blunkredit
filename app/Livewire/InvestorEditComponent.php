<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Investors;

class InvestorEditComponent extends Component
{
    public $open=false;
    public $investor;

    protected $rules = [
        'investor.type' => 'required',
        'investor.name' => 'required|max:100|min:1',
        'investor.lastname' => 'required|max:100|min:1',
        'investor.email' => 'required|email',
        'investor.address' => 'required',
        'investor.phone' => 'required',
        'investor.dpi' => 'required',
    ];

    public function mount(Investors $investor){
        $this->investor=$investor;
    }

    public function render()
    {
        return view('livewire.investor-edit-component');
    }

    public function save()
    {
        $this->validate();
        $this->investor->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
