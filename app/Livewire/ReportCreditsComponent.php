<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\User;
use DB;

class ReportCreditsComponent extends Component
{
    public $search;
    
    public function render()
    {
        $customers = Customer::where('status',1)
                            ->where(DB::raw('CONCAT(name," ",lastname,dpi,email,code)'),'like','%'.$this->search.'%')
                            ->orderBy('id','desc')
                            ->paginate(30);
        return view('livewire.report-credits-component',compact('customers'));
    }
}
