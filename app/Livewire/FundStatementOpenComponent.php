<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use Auth;

class FundStatementOpenComponent extends Component
{
    public $open=false;
    public $fund;
    public $amount,$info;

    public function mount(Fund $fund){
        $this->fund=$fund;
    }

    protected $rules = [
        'amount' => 'required',
        'info' => 'required'
    ];
    public function render()
    {
        return view('livewire.fund-statement-open-component');
    }
    public function save(){

        $this->validate();

        $user=Auth::user();

        $fund_statament=FundStatement::create([
            'fund_id' => $this->fund->id,
            'date' => date('Y-m-d H:i:s'),
            'type' => 1,
            'credit' => $this->amount,
            'debit' => 0,
            'balance' => $this->amount,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => '',
            'info' => $this->info,
            'receipt_number' => '',
            'amount' => $this->amount
        ]);

        $this->reset('amount','info','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
