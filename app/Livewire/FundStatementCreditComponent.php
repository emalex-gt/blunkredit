<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use App\Models\FundStatementInvestor;
use App\Models\Investors;
use Auth;

class FundStatementCreditComponent extends Component
{
    public $open=false;
    public $fund;
    public $origin=0,$owner,$investor,$receipt_number,$amount,$info;

    public function mount(Fund $fund){
        $this->fund=$fund;
    }

    protected $rules = [
        'owner' => 'required_if:origin,1',
        'investor' => 'required_if:origin,2',
        'receipt_number' => 'required|max:100|min:1',
        'amount' => 'required',
        'info' => 'required'
    ];
    public function render()
    {
        if($this->fund->id==3)
            $this->origin=2;
        $investors=Investors::where('status',1)->where('type',2)->get();
        $owners=Investors::where('status',1)->where('type',1)->get();
        return view('livewire.fund-statement-credit-component',compact('investors','owners'));
    }
    public function save(){

        $this->validate();

        $last_statement=FundStatement::where('fund_id',$this->fund->id)->orderBy('id','desc')->first();
        $user=Auth::user();
        if($this->origin==0)
            $type=3;
        else
            $type=2;
        $fund_statament=FundStatement::create([
            'fund_id' => $this->fund->id,
            'date' => date('Y-m-d H:i:s'),
            'type' => $type,
            'credit' => $this->amount,
            'debit' => 0,
            'balance' => $last_statement->balance + $this->amount,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => '',
            'info' => $this->info,
            'receipt_number' => $this->receipt_number,
            'amount' => $this->amount
        ]);
        if($this->origin==1){
            FundStatementInvestor::create([
                'fund_statement_id' => $fund_statament->id,
                'investor_id' => $this->owner
            ]);
        }
        if($this->origin==2){
            FundStatementInvestor::create([
                'fund_statement_id' => $fund_statament->id,
                'investor_id' => $this->investor
            ]);
        }

        $this->reset('origin','investor','receipt_number','amount','info','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
