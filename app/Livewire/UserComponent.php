<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use DB;

class UserComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $users = User::where(DB::raw('CONCAT(name,dpi,email)'),'like','%'.$this->search.'%')
                        ->orderBy('id','desc')
                        ->paginate(30);
        return view('livewire.user-component',compact('users'));
    }
    public function delete($userId)
    {
        $user=User::find($userId);
        $user->status=0;
        $user->save();
        $this->dispatch('redirect');
    }
}
