<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AmortizationSchedule;
use App\Models\Prepayment;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use Auth;

class PrepaymentComponent extends Component
{
    public $open=false;
    public $amortizationschedule;
    public $receipt_number;

    protected $rules = [
        'receipt_number' => 'required'
    ];

    public function mount(AmortizationSchedule $amortizationschedule){
        $this->amortizationschedule=$amortizationschedule;
    }

    public function render()
    {
        return view('livewire.prepayment-component');
    }
    
    public function save(){
        $this->validate();

        $user = Auth::user();
        Prepayment::create([
            'amortization_schedule_id' => $this->amortizationschedule->id,
            'date' => $this->amortizationschedule->share_date,
            'payment_date' => date('Y-m-d H:i:s'),
            'receipt_number' => $this->receipt_number,
            'payment_user' => $user->id,
            'payment_at' => date('Y-m-d H:i:s'),
            'status' => 1
        ]);

        //Statement
        $last_statement=FundStatement::where('fund_id',$this->amortizationschedule->credit->fund_id)->orderBy('id','desc')->first();
        if($last_statement===NULL){
            $bal=0;
        } else {
            $bal=$last_statement->balance;
        }

        $fund_statament=FundStatement::create([
            'fund_id' => $this->amortizationschedule->credit->fund_id,
            'date' => date('Y-m-d H:i:s'),
            'type' => 5,
            'credit' => $this->amortizationschedule->capital,
            'debit' => 0,
            'balance' => $bal + $this->amortizationschedule->capital,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => $this->amortizationschedule->credit->id,
            'info' => 'Abono Adelantado de Capital a Crédito '.$this->amortizationschedule->credit->code,
            'receipt_number' => $this->receipt_number,
            'amount' => $this->amortizationschedule->capital
        ]);

        $this->reset('receipt_number','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
