<?php

namespace App\Livewire;

use Livewire\Component;
use Auth;
use App\Models\PartialPayment;
use App\Models\Credit;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;

class PartialPaymentComponent extends Component
{
    public $open=false;
    public $credit;
    public $receipt_number, $amount;

    protected $rules = [
        'receipt_number' => 'required',
        'amount' => 'required'
    ];

    public function mount(Credit $credit){
        $this->credit=$credit;
    }

    public function render()
    {
        return view('livewire.partial-payment-component');
    }

    public function save()
    {
        $this->validate();
        $cuota=$this->credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->total + $this->credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->delay;
        foreach($this->credit->partial_payments()->where('amortization_schedule_id',0)->get() as $partialpayment){
            $cuota=$cuota-$partialpayment->amount;
        }
        if($this->amount < ($cuota-0.01)){
            $user = Auth::user();
            PartialPayment::create([
                'credit_id' => $this->credit->id,
                'date' => date('Y-m-d H:i:s'),
                'create_user' => $user->id,
                'amount' => $this->amount,
                'receipt_number' => $this->receipt_number,
                'payment_at' => date('Y-m-d H:i:s'),
                'payment_user' => $user->id,
                'amortization_schedule_id' => 0
            ]);

            //Statement
            $last_statement=FundStatement::where('fund_id',4)->orderBy('id','desc')->first();
            if($last_statement===NULL){
                $bal=0;
            } else {
                $bal=$last_statement->balance;
            }
            
            $fund_statament=FundStatement::create([
                'fund_id' => 4,
                'date' => date('Y-m-d H:i:s'),
                'type' => 3,
                'credit' => $this->amount,
                'debit' => 0,
                'balance' => $bal + $this->amount,
                'create_user' => $user->id
            ]);
            FundStatementDetail::create([
                'fund_statement_id' => $fund_statament->id,
                'credit_code' => 0,
                'info' => 'Abono Pago Parcial a Crédito '.$this->credit->code,
                'receipt_number' => $this->receipt_number,
                'amount' => $this->amount
            ]);

            $this->reset('receipt_number','amount');
            $this->dispatch('ok');
            $this->dispatch('redirect');
        } else {
            $this->dispatch('error');
        }
    }
}
