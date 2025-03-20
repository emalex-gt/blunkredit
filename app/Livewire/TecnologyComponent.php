<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tecnology;

class TecnologyComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $tecnologies = Tecnology::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.tecnology-component',compact('tecnologies'));
    }
    public function delete($tecnologyId)
    {
        $tecnology=Tecnology::find($tecnologyId);
        $tecnology->status=0;
        $tecnology->save();
        $this->dispatch('redirect');
    }
}
