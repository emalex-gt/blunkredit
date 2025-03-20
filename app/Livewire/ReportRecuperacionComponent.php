<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AmortizationSchedule;
use App\Models\User;
use DB;

class ReportRecuperacionComponent extends Component
{
    public $search='';
    public $desde;
    public $hasta;
    public $asesor;
    public $comparador='=';
    
    public function mount(){
        $this->desde=date('Y-m').'-01';
        $this->hasta=date('Y-m-d');
        $this->asesor=0;
    }

    public function render()
    {
        $asesores = User::get();
        if($this->asesor==0)
            $this->comparador='>';
        else
            $this->comparador='=';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->where(function ($query) {
                                $query->whereHas('credit', function (Builder $query) {
                                    $query->whereHas('customer', function (Builder $query) {
                                        $query->where(DB::raw('CONCAT(name,dpi,email,code)'), 'like','%'.$this->search.'%');
                                    });
                                });
                            })
                            ->whereHas('payment_by', function (Builder $query) {
                                $query->where('id', $this->comparador, $this->asesor);
                            })
                            ->whereBetween('payment_date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->paginate(30);
        return view('livewire.report-recuperacion-component',compact('amortizations','asesores'));
    }
}
