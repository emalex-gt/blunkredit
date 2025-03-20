<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use DB;

class ReportCorteComponent extends Component
{
    public $desde,$hasta,$fondo,$comparador,$fund_statement_detail;

    public function mount(FundStatementDetail $fund_statement_detail){
        $this->desde=date('Y-m').'-01';
        $this->hasta=date('Y-m-d');
        $this->fondo=0;
        $this->fund_statement_detail=$fund_statement_detail;
    }

    public function render()
    {
        $funds=Fund::where('status',1)->get();
        if($this->fondo==0)
            $this->comparador='>';
        else
            $this->comparador='=';
        $statements=FundStatement::whereBetween('date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                                ->where('fund_id',$this->comparador,$this->fondo)
                                ->where('type',5)
                                ->orderBy(DB::raw('CAST(date As Date)'), 'asc')
                                ->orderBy('fund_id', 'asc')
                                ->get();
        return view('livewire.report-corte-component',compact('statements','funds'));
    }
}
