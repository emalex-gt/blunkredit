<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Hash;

class UserEditComponent extends Component
{
    public $open=false;
    public $user;
    public $role,$password;

    protected $rules = [
        'user.name' => 'required|max:100|min:1',
        'user.email' => 'required|email',
        'user.address' => 'required',
        'user.phone' => 'required',
        'user.dpi' => 'required',
        'role' => 'required'
    ];

    public function mount(User $user){
        $this->user=$user;
        $this->role = $this->user->roles->first()->name;
    }

    public function render()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('livewire.user-edit-component',compact('roles'));
    }

    public function save()
    {
        $this->validate();
        $this->user->save();

        //Asignar rol
        $this->user->roles()->detach();
        $this->user->assignRole($this->role);

        //Cambiar Password
        if($this->password!=''){
            $this->user->password=Hash::make($this->password);
            $this->user->save;
        }

        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
