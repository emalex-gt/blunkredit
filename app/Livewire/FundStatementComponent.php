<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use App\Models\FundStatementInvestor;

class FundStatementComponent extends Component
{
    protected $listeners=['render','delete'];
    public $id;

    public function construct($id){
        $this->id=$id;
    }

    public function render()
    {
        $statements = FundStatement::where('fund_id',$this->id)
                                ->orderBy('id','desc')
                                ->paginate(30);
        $fund = Fund::find($this->id);

        return view('livewire.fund-statement-component',compact('statements','fund'));
    }
    public function delete($statementId)
    {
        $fund_statement_investor=FundStatementInvestor::where('fund_statement_id',$statementId);
        $fund_statement_investor->delete();
        $fund_statement_detail=FundStatementDetail::where('fund_statement_id',$statementId);
        $fund_statement_detail->delete();
        $fund_statement=FundStatement::find($statementId);
        $fund_statement->delete();
        $this->dispatch('redirect');
    }
}
