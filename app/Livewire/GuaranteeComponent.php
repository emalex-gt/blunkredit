<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Guarantee;

class GuaranteeComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $guaranties = Guarantee::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.guarantee-component',compact('guaranties'));
    }
    public function delete($guaranteeId)
    {
        $guarantee=Guarantee::find($guaranteeId);
        $guarantee->status=0;
        $guarantee->save();
        $this->dispatch('redirect');
    }
}
