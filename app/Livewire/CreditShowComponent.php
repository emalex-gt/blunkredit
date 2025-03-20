<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Credit;
use Auth;

class CreditShowComponent extends Component
{
    public $credit;

    public function mount($id){
        $this->credit=Credit::find($id);
    }

    public function render()
    {
        return view('livewire.credit-show-component');
    }
    public function authoriz()
    {
        $this->credit->status=2;
        $user=Auth::user();
        $this->credit->authorized_user=$user->id;
        $this->credit->authorized_at=date('Y-m-d H:i:s');
        $this->credit->save();
        $this->dispatch('ok');
        $this->dispatch('redirect');
    }
}
