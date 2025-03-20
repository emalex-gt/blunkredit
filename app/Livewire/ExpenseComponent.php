<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Expense;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use Auth;

class ExpenseComponent extends Component
{
    public $desde,$hasta;
    protected $listeners=['render','delete'];

    

    public function render()
    {
        if($this->desde==''){
            $this->desde=date('Y-m').'-01';
        }
        if($this->hasta==''){
            $this->hasta=date('Y-m-d').' 23:59:59';
        }
        $expenses = Expense::where('status',1)
                                ->whereBetween('date',[$this->desde.' 00:00:00',$this->hasta,' 23:59:59'])
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.expense-component',compact('expenses'));
    }
    public function delete($expenseId)
    {
        $expense=Expense::find($expenseId);
        $expense->status=0;
        $expense->save();

        //Statement
        $last_statement=FundStatement::where('fund_id',$expense->fund->id)->orderBy('id','desc')->first();
        $user=Auth::user();
        $fund_statament=FundStatement::create([
            'fund_id' => $expense->fund->id,
            'date' => date('Y-m-d H:i:s'),
            'type' => 3,
            'credit' => $expense->amount,
            'debit' => 0,
            'balance' => $last_statement->balance + $expense->amount,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => '',
            'info' => 'Anulación de Gasto No. '.$expense->id,
            'receipt_number' => 'AGST'.$expense->id,
            'amount' => $expense->amount
        ]);

        $this->dispatch('redirect');
    }
}
