<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Customer;
use DB;


class CreditsComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $customers = Customer::where('status',1)
                                ->where(function ($query) {
                                    $query->whereHas('credits', function (Builder $query) {
                                                $query->where('code', 'like','%'.$this->search.'%');
                                            })
                                            ->orWhere(DB::raw('CONCAT(name,dpi,email,code)'),'like','%'.$this->search.'%');
                                })
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.credits-component',compact('customers'));
    }
}
