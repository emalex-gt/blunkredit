<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AmortizationSchedule;
use DB;

class ReportProyeccionComponent extends Component
{
    public $desde;
    public $hasta;
    
    public function mount(){
        $this->desde=date('Y-m').'-01';
        $this->hasta=date('Y-m-d');
    }

    public function render()
    {
        /*$amortizations = AmortizationSchedule::whereHas('credit')
                            ->where('total_payment',0)
                            ->whereBetween('share_date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('share_date','asc')
                            ->paginate(30);*/
        $amortizations = DB::table('amortization_schedules as a')
                            ->select('a.id','a.share_date','c.code','c.created_user','cl.lastname','cl.name','cl.address','cl.phone','u.name as user','a.capital','a.interest','a.total','a.delay','f.name as fund')
                            ->join('credits as c','c.id','=','a.credit_id')
                            ->join('funds as f','f.id','=','c.fund_id')
                            ->join('users as u','u.id','=','c.created_user')
                            ->join('customers as cl','cl.id','=','c.customer_id')
                            ->where('a.total_payment',0)
                            ->where(function($query)
                            {
                                $query->where(function($query)
                                {
                                    $query->whereBetween('a.share_date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                                    ->where('a.delay',0);

                                })
                                ->orWhere('a.delay','>',0);
                            })
                            ->orderBy('c.created_user','asc')
                            ->orderBy('a.share_date','asc')
                            ->get();
        return view('livewire.report-proyeccion-component',compact('amortizations'));
    }
}
