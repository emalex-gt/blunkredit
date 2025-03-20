<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Investors;
use DB;

class InvestorComponent extends Component
{
    public $search='';
    public $type=0;
    protected $listeners=['render','delete'];

    public function render()
    {
        if($this->type==0)
            $comparador='>';
        else
            $comparador='=';
        $investors = Investors::where(DB::raw('CONCAT(name," ",lastname,dpi,email)'),'like','%'.$this->search.'%')
                        ->where('type',$comparador,$this->type)
                        ->where('status',1)
                        ->orderBy('id','desc')
                        ->paginate(30);
        return view('livewire.investor-component',compact('investors'));
    }
    public function delete($investorId)
    {
        $investor=Investors::find($investorId);
        $investor->status=0;
        $investor->save();
        $this->dispatch('redirect');
    }
}
