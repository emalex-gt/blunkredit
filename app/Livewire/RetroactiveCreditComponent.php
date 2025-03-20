<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Tecnology;
use App\Models\Fund;
use App\Models\Guarantee;
use App\Models\CreditLine;
use App\Models\Policy;
use App\Models\TimeLimit;
use App\Models\Interest;

class RetroactiveCreditComponent extends Component
{
    public $open=false;
    public $customer;
    public $credit_line_id,$guarantee_id,$file_number,$tecnology_id,$policy_id,$time_limit_id,$interest_id,$initial_capital,$expended_at;

    protected $rules = [
        'tecnology_id' => 'required',
        'lastname' => 'required',
        'email' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'dpi' => 'required',
    ];

    public function mount(Customer $customer){
        $this->customer=$customer;
    }

    public function enviarInfoRetroactiva()
    {
        $this->dispatch('infoRecibidaRetroactiva', [
            'credit_line_id' => $this->credit_line_id,
            'guarantee_id' => $this->guarantee_id,
            'file_number' => $this->file_number,
            'tecnology_id' => $this->tecnology_id,
            'policy_id' => $this->policy_id,
            'time_limit_id' => $this->time_limit_id,
            'interest_id' => $this->interest_id,
            'initial_capital' => $this->initial_capital,
            'expended_at' => $this->expended_at
        ]);
    }

    public function render()
    {
        $tecnologies=Tecnology::where('status',1)->get();
        $funds=Fund::where('status',1)->get();
        $guarantees=Guarantee::where('status',1)->get();
        $creditlines=CreditLine::where('status',1)->get();
        $policies=Policy::where('status',1)->get();
        $timelimits=TimeLimit::where('status',1)->get();
        $interests=Interest::where('status',1)->get();
        return view('livewire.retroactive-credit-component',compact('tecnologies','funds','guarantees','creditlines','policies','timelimits','interests'));
    }

    public function save(){
        
    }
}
