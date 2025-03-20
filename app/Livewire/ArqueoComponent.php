<?php

namespace App\Livewire;

use Livewire\Component;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use App\Models\AmortizationSchedule;
use App\Models\Arqueo;
use App\Models\PagoCheque;

class ArqueoComponent extends Component
{
    public $b200=0,$b100=0,$b50=0,$b20=0,$b10=0,$b5=0,$b1=0;
    public $m1=0,$m05=0,$m025=0,$m01=0,$m005=0,$m001=0;
    public $amortizationschedule;
    public $number=[],$amount=[],$date,$info;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function mount(AmortizationSchedule $amortizationschedule){
        $this->date=date('Y-m-d');
        $this->amortizationschedule = $amortizationschedule;
    }

    public function render()
    {
        if($this->b200<0 || $this->b200=='')
            $this->b200=0;
        if($this->b100<0 || $this->b100=='')
            $this->b100=0;
        if($this->b50<0 || $this->b50=='')
            $this->b50=0;
        if($this->b20<0 || $this->b20=='')
            $this->b20=0;
        if($this->b10<0 || $this->b10=='')
            $this->b10=0;
        if($this->b5<0 || $this->b5=='')
            $this->b5=0;
        if($this->b1<0 || $this->b1=='')
            $this->b1=0;
        if($this->m1<0 || $this->m1=='')
            $this->m1=0;
        if($this->m05<0 || $this->m05=='')
            $this->m05=0;
        if($this->m025<0 || $this->m025=='')
            $this->m025=0;
        if($this->m01<0 || $this->m01=='')
            $this->m01=0;
        if($this->m005<0 || $this->m005=='')
            $this->m005=0;
        if($this->m001<0 || $this->m001=='')
            $this->m001=0;
        return view('livewire.arqueo-component');
    }

    private function resetInputFields(){
        $this->number = '';
        $this->amount = '';
    }

    public function save(){
        $validatedDate = $this->validate([
            'date' => 'required|unique:arqueos,date,'.$this->date.'|before_or_equal:'.date('Y-m-d'),
            'info' => 'required'
        ]);
        //Informe Diario
        $informe=0;
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
            ->whereBetween('payment_date',[$this->date.' 00:00:00',$this->date.' 23:59:59'])
            ->orderBy('id','desc')
            ->get();
        foreach ($amortizations as $amortization){
            $informe=$informe+$amortization->total_payment;
        }
        //Agregar Arqueo
        $total_efectivo=($this->b200*200)+($this->b100*100)+($this->b50*50)+($this->b20*20)+($this->b10*10)+($this->b5*5)+$this->b1+$this->m1+($this->m05*0.5)+($this->m025*0.25)+($this->m01*0.1)+($this->m005*0.05)+($this->m001*0.01);
        $arqueo = Arqueo::create([
            'date' => $this->date,
            'b200' => $this->b200,
            'b100' => $this->b100,
            'b50' => $this->b50,
            'b20' => $this->b20,
            'b10' => $this->b10,
            'b5' => $this->b5,
            'b1' => $this->b1,
            'm1' => $this->m1,
            'm05' => $this->m05,
            'm025' => $this->m025,
            'm01' => $this->m01,
            'm005' => $this->m005,
            'm001' => $this->m001,
            'total_efectivo' => $total_efectivo,
            'total_cheque' => 0,
            'total_arqueado' => $total_efectivo,
            'informe_diario' => $informe,
            'diferencia' => ($total_efectivo - $informe),
            'info' => $this->info
        ]);
        $total_cheque=0;
        foreach ($this->number as $key => $value) {
            PagoCheque::create(['date' => $this->date, 'number' => $this->number[$key], 'amount' => $this->amount[$key]]);
            $total_cheque=$total_cheque+$this->amount[$key];
        }

        $arqueo->total_cheque=$total_cheque;
        $arqueo->total_arqueado=$total_cheque+$total_efectivo;
        $arqueo->diferencia=$total_cheque+$total_efectivo-$informe;
        $arqueo->save();

        $this->inputs = [];

        $this->resetInputFields();

        $this->dispatch('ok');
        $this->dispatch('redirect');
    }
}
