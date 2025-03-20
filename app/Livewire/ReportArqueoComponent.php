<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Arqueo;
use App\Models\PagoCheque;

class ReportArqueoComponent extends Component
{
    public $date;
    
    public function mount(){
        $this->date=date('Y-m-d');
    }

    public function render()
    {
        $arqueo=Arqueo::where('date',$this->date)->first();
        $cheques=PagoCheque::where('date',$this->date)->get();
        return view('livewire.report-arqueo-component',compact('arqueo','cheques'));
    }
}
