<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AmortizationSchedule;

class ReportDiaryComponent extends Component
{
    public $desde;
    public $hasta;
    
    public function mount(){
        $this->desde=date('Y-m').'-01';
        $this->hasta=date('Y-m-d');
    }

    public function render()
    {
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereBetween('payment_date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        return view('livewire.report-diary-component',compact('amortizations'));
    }
}
