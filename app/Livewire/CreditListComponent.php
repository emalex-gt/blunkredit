<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Credit;
use DB;

class CreditListComponent extends Component
{
    public $search='';
    public $status;
    public $desde,$hasta;
    public $comparador='=';

    public function mount(){
        $this->status=0;
    }

    public function render()
    {
        if($this->status==0)
            $this->comparador='>';
        else
            $this->comparador='=';
        if($this->desde=='')
            $this->desde=date('Y-m').'-01';
        if($this->hasta=='')
            $this->hasta=date('Y-m-d').' 23:59:59';
        $credits = Credit::where(function ($query) {
                                    $query->whereHas('customer', function (Builder $query) {
                                        $query->where(DB::raw('CONCAT(name,dpi,email,code)'),'like','%'.$this->search.'%');
                                    });
                                })
                                ->whereBetween('expended_at',[$this->desde.' 00:00:00',$this->hasta,' 23:59:59'])
                                ->where('status',$this->comparador,$this->status)
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.credit-list-component',compact('credits'));
    }
}
