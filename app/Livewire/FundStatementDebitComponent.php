<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use Auth;

class FundStatementDebitComponent extends Component
{
    public $open=false;
    public $fund;
    public $receipt_number,$amount,$info;

    public function mount(Fund $fund){
        $this->fund=$fund;
    }

    protected $rules = [
        'receipt_number' => 'required|max:100|min:1',
        'amount' => 'required',
        'info' => 'required'
    ];
    public function render()
    {
        return view('livewire.fund-statement-debit-component');
    }
    public function save(){

        $this->validate();

        $last_statement=FundStatement::where('fund_id',$this->fund->id)->orderBy('id','desc')->first();
        $user=Auth::user();

        $fund_statament=FundStatement::create([
            'fund_id' => $this->fund->id,
            'date' => date('Y-m-d H:i:s'),
            'type' => 6,
            'credit' => 0,
            'debit' => $this->amount,
            'balance' => $last_statement->balance - $this->amount,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => '',
            'info' => $this->info,
            'receipt_number' => $this->receipt_number,
            'amount' => $this->amount
        ]);

        $this->reset('receipt_number','amount','info','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
