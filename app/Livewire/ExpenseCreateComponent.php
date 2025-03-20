<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use App\Models\Fund;
use Auth;

class ExpenseCreateComponent extends Component
{
    public $open=false;
    public $amount,$expense_type,$fund_id,$info,$disponible;

    protected $rules = [
        'amount' => 'required',
        'expense_type' => 'required',
        'fund_id' => 'required',
        'info' => 'required'
    ];

    public function render()
    {
        $funds=Fund::where('status',1)->get();
        $expenses_types=ExpenseType::where('status',1)->get();
        return view('livewire.expense-create-component',compact('funds','expenses_types'));
    }
    public function save(){

        $this->validate();
        if($this->disponible == 1){
            $user=Auth::user();

            //Statement
            $last_statement=FundStatement::where('fund_id',$this->fund_id)->orderBy('id','desc')->first();
            $user=Auth::user();

            $fund_statament=FundStatement::create([
                'fund_id' => $this->fund_id,
                'date' => date('Y-m-d H:i:s'),
                'type' => 6,
                'credit' => 0,
                'debit' => $this->amount,
                'balance' => $last_statement->balance - $this->amount,
                'create_user' => $user->id
            ]);
            $details= FundStatementDetail::create([
                'fund_statement_id' => $fund_statament->id,
                'credit_code' => '',
                'info' => $this->info,
                'receipt_number' => '',
                'amount' => $this->amount
            ]);

            //Saving Expense
            $expense = Expense::create([
                'date' => date('Y-m-d H:i:s'),
                'amount' => $this->amount,
                'info' => $this->info,
                'created_by' => $user->id,
                'fund_id' => $this->fund_id,
                'expense_type_id' => $this->expense_type,
                'fund_statement_id' => $fund_statament->id,
                'status' => 1
            ]);

            $details->info='Gasto No. '.$expense->id.' | '.$this->info;
            $details->receipt_number='GST'.$expense->id;
            $details->save();

            $this->dispatch('ok');
            $this->dispatch('redirect');
        } else {
            $this->dispatch('error');
        }

    }
}
