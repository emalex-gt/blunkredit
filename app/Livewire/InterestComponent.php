<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Interest;

class InterestComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $interests = Interest::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.interest-component',compact('interests'));
    }
    public function delete($interestId)
    {
        $interest=Interest::find($interestId);
        $interest->status=0;
        $interest->save();
        $this->dispatch('redirect');
    }
}
