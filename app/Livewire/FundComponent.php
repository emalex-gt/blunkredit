<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;

class FundComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $funds = Fund::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.fund-component',compact('funds'));
    }
    public function delete($fundId)
    {
        $fund=Fund::find($fundId);
        $fund->status=0;
        $fund->save();
        $this->dispatch('redirect');
    }
}
