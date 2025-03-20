<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CreditLine;

class CreditLineComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $creditlines = CreditLine::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.credit-line-component',compact('creditlines'));
    }
    public function delete($creditlineId)
    {
        $creditline=CreditLine::find($creditlineId);
        $creditline->status=0;
        $creditline->save();
        $this->dispatch('redirect');
    }
}
