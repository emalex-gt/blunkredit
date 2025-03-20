<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use App\Models\FundStatementInvestor;
use App\Models\Credit;
use App\Models\AmortizationSchedule;

class FundStatementInfoComponent extends Component
{
    public $open=false;
    public $statement;
    public $fundstatementdetail;
    public $fundstatementinvestor;
    public $credit;
    public $payment;

    public function mount(FundStatement $statement){
        $this->statement=$statement;
    }

    public function render()
    {
        $this->fundstatementdetail=FundStatementDetail::where('fund_statement_id',$this->statement->id)->first();
        $this->fundstatementinvestor=FundStatementInvestor::where('fund_statement_id',$this->statement->id)->first();
        $this->credit=Credit::where('id',$this->fundstatementdetail->credit_code)->first();
        $this->payment=AmortizationSchedule::where('id',$this->fundstatementdetail->credit_code)->first();
        return view('livewire.fund-statement-info-component'); 
    }
}
