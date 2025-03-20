<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use DB;

class CustomerComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $customers = Customer::where('status',1)
                                ->where(DB::raw('CONCAT(name," ",lastname,dpi,email,code)'),'like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.customer-component',compact('customers'));
    }
    public function delete($customerId)
    {
        $customer=Customer::find($customerId);
        $customer->status=0;
        $customer->save();
        $this->dispatch('redirect');
    }
    public function save(){ }
}
