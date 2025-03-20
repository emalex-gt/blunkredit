<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Credit;
use App\Models\AdministrativeExpense;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use App\Models\Cheques;
use Auth;

class CreditExpendComponent extends Component
{

    public $open=false;
    public $credit;
    public $fund_id,$desembolso,$contrato=750,$traspaso=150,$disponible,$cheque_id,$cheque_no,$contract_no;

    public function mount(Credit $credit){
        $this->credit=$credit;
        $this->desembolso=number_format(($this->credit->initial_credit_capital * 0.055),2,'.','');
    }

    protected $rules = [
        'desembolso' => 'required',
        'contrato' => 'required',
        'traspaso' => 'required',
        'fund_id' => 'required',
        'cheque_id' => 'required',
        'cheque_no' => 'required'
    ];
    
    public function render()
    {
        $funds=Fund::where('status',1)->where('id','<>',4)->get();
        $cheques=Cheques::where('status',1)->get();
        return view('livewire.credit-expend-component',compact('funds','cheques'));
    }
    public function save()
    {
        $user = Auth::user();
        $this->validate();
        if($this->disponible == 1){
            if($this->traspaso >= 150){
                AdministrativeExpense::create([
                    'credit_id' => $this->credit->id,
                    'type' => 1,
                    'description' => '',
                    'amount' => $this->desembolso,
                    'created_user' => $user->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                AdministrativeExpense::create([
                    'credit_id' => $this->credit->id,
                    'type' => 2,
                    'description' => '',
                    'amount' => $this->contrato,
                    'created_user' => $user->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                AdministrativeExpense::create([
                    'credit_id' => $this->credit->id,
                    'type' => 3,
                    'description' => '',
                    'amount' => $this->traspaso,
                    'created_user' => $user->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $this->credit->status=3;
                $user=Auth::user();
                $this->credit->fund_id=$this->fund_id;
                $this->credit->cheque_id=$this->cheque_id;
                $this->credit->cheque_no=$this->cheque_no;
                $this->credit->contract_no=$this->contract_no;
                $this->credit->expended_user=$user->id;
                $this->credit->expended_at=date('Y-m-d H:i:s');
                $this->credit->save();
                
                $last_statement=FundStatement::where('fund_id',$this->fund_id)->orderBy('id','desc')->first();
                
                $fund_statament=FundStatement::create([
                    'fund_id' => $this->fund_id,
                    'date' => date('Y-m-d H:i:s'),
                    'type' => 4,
                    'credit' => 0,
                    'debit' => $this->credit->initial_credit_capital,
                    'balance' => $last_statement->balance - $this->credit->initial_credit_capital,
                    'create_user' => $user->id
                ]);
                FundStatementDetail::create([
                    'fund_statement_id' => $fund_statament->id,
                    'credit_code' => $this->credit->id,
                    'info' => 'Desembolso de Crédito '.$this->credit->code,
                    'receipt_number' => '',
                    'amount' => $this->credit->initial_credit_capital
                ]);

                $this->dispatch('ok');
                $this->dispatch('redirect');
            } else {
                $this->dispatch('error');
            }
        } else {
            $this->dispatch('error');
        }
    }
}
