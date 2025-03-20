<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Hash;

class UserCreateComponent extends Component
{
    public $open=false;
    public $name,$email,$password,$address,$phone,$dpi;
    public $role;

    protected $rules = [
        'name' => 'required|max:100|min:1',
        'email' => 'required|email',
        'password' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'dpi' => 'required',
        'role' => 'required'
    ];

    public function render()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('livewire.user-create-component',compact('roles'));
    }
    
    public function save(){

        $this->validate();
        $last_user_id=User::all()->sortDesc()->first();
        $user=User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'address' => $this->address,
            'phone' => $this->phone,
            'dpi' => $this->dpi,
            'code' => ($last_user_id->id + 1).'-'.strtotime(now())
        ]);
        //Asignar rol
        $user->roles()->detach();
        $user->assignRole($this->role);

        $this->reset('name','email','password','address','phone','dpi','role','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
