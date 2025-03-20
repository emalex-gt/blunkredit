<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AmortizationSchedule;
use App\Models\User;

class ReportMorososComponent extends Component
{
    
    public function render()
    {
        $users = User::whereHas('credits', function (Builder $query) {
                        $query->whereHas('amortizacion_schedule', function (Builder $query) {
                            $query->where('days_delayed','>',0)
                                    ->where('total_payment',0);
                        });
                    })->get();
        $users_total=User::get();
        /*$amortizations = AmortizationSchedule::where('days_delayed','>',0)
                            ->where('total_payment',0)
                            ->orderBy('id','desc')
                            ->get();
        $users=User::where('id',1)->get();
        return view('livewire.report-morosos-component',compact('amortizations','users'));*/
        return view('livewire.report-morosos-component',compact('users','users_total'));
    }
}
