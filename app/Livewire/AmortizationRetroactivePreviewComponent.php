<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Credit;
use App\Models\AmortizationSchedule;
use App\Models\Interest;
use App\Models\TimeLimit;
use Auth;

class AmortizationRetroactivePreviewComponent extends Component
{
    public $amortization,$interest,$timelimit;

    public $customer;
    public $credit_line_id,$guarantee_id,$file_number,$tecnology_id,$policy_id,$time_limit_id,$interest_id,$initial_capital,$expended_at;
    protected $listeners = ['infoRecibidaRetroactiva'];

    public function infoRecibidaRetroactiva($data)
    {
        $this->credit_line_id = $data['credit_line_id'];
        $this->guarantee_id = $data['guarantee_id'];
        $this->file_number = $data['file_number'];
        $this->tecnology_id = $data['tecnology_id'];
        $this->policy_id = $data['policy_id'];
        $this->time_limit_id = $data['time_limit_id'];
        $this->interest_id = $data['interest_id'];
        $this->initial_capital = $data['initial_capital'];
        $this->expended_at = $data['expended_at'];
    }
    public function mount(AmortizationSchedule $amortization,Interest $interest,TimeLimit $timelimit){
        $this->amortization = $amortization;
        $this->interest = $interest;
        $this->timelimit = $timelimit;
    }
    public function render()
    {
        return view('livewire.amortization-retroactive-preview-component');
    }
    public function save()
    {
        $user=Auth::user();
        $last_credit_id=Credit::all()->sortDesc()->first();
        if($this->file_number===null){
            $file='';
        } else {
            $file=$this->file_number;
        }
        $credit = Credit::create([
            'code' => $this->customer->code.'-'.($last_credit_id->id + 1).'-'.strtotime(now()),
            'customer_id' => $this->customer->id,
            'tecnology_id' => $this->tecnology_id,
            'fund_id' => 1,
            'guarantee_id' => $this->guarantee_id,
            'file_number' => $file,
            'credit_line_id' => $this->credit_line_id,
            'time_limit_id' => $this->time_limit_id,
            'interest_id' => $this->interest_id,
            'policy_id' => $this->policy_id,
            'initial_credit_capital' => $this->initial_capital,
            'amortized_credit_capital' => 0,
            'pending_credit_capital' => $this->initial_capital,
            'interest_paid' => 0,
            'delay_paid' => 0,
            'total_paid' => 0,
            'share' => 0,
            'created_user' => $user->id,
            'created_at' => date('Y-m-d H:i:s'),
            'authorized_user' => $user->id,
            'authorized_at' => date('Y-m-d',strtotime($this->expended_at)),
            'expended_user' => $user->id,
            'expended_at' => date('Y-m-d',strtotime($this->expended_at)),
            'status' => 1,
            'initial_interest_balance' => 0,
            'initial_total_balance' => 0,
            'retroactive' => 1,
        ]);
            $total_interes=0;
            if($this->policy_id==1){
                $cuota = $this->amortization->cuota_nivelada($this->initial_capital,$this->interest_id,$this->time_limit_id);
                $interes = Interest::find($this->interest_id);
                $plazo = TimeLimit::find($this->time_limit_id);
                $saldo_capital = $this->initial_capital;
                $fecha=date('Y-m-d',strtotime($this->expended_at));
                for($i=1; $i<=$plazo->name; $i++) {
                    $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
                    $interes_cuota = $saldo_capital * ($interes->name / 12 / 100);
                    $capital_cuota = $cuota - $interes_cuota;
                    $saldo_capital = $saldo_capital - $capital_cuota;
                    AmortizationSchedule::create([
                        'credit_id' => $credit->id,
                        'share_number' => date('Y-m-d H:i:s'),
                        'number' => $i,
                        'share_date' => $fecha.' 00:00:00',
                        'payment_date' => date('Y-m-d H:i:s'),
                        'receipt_number' => '',
                        'capital' => $capital_cuota,
                        'interest' => $interes_cuota,
                        'delay' => 0,
                        'total' => $cuota,
                        'total_payment' => 0,
                        'capital_balance' => $saldo_capital,
                        'interest_balance' => 0,
                        'total_balance' => $saldo_capital,
                        'capital_balance_payment' => 0,
                        'interest_balance_payment' => 0,
                        'total_balance_payment' => 0,
                        'days_delayed' => 0,
                        'created_user' => $user->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'payment_user' => $user->id,
                        'payment_at' => date('Y-m-d H:i:s'),
                    ]);
                    $credit->share=$cuota;
                    $credit->save();
                    $total_interes=$total_interes+$interes_cuota;
                    $fixed_total_interes=$total_interes;
                }
            } elseif($this->policy_id==2){
                $interes = Interest::find($this->interest_id);
                $plazo = TimeLimit::find($this->time_limit_id);
                $saldo_capital = $this->initial_capital;
                $fecha=date('Y-m-d',strtotime($this->expended_at));
                for($i=1; $i<=$plazo->name; $i++) {
                    $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
                    //$interes_cuota = $saldo_capital * ($interes->name / 12 / 100);
                    $interes_cuota = ((($saldo_capital * ($interes->name / 100))/365)*31);
                    $capital_cuota = $this->initial_capital/$plazo->name;
                    $saldo_capital = $saldo_capital - $capital_cuota;
                    $cuota=$interes_cuota+$capital_cuota;
                    AmortizationSchedule::create([
                        'credit_id' => $credit->id,
                        'share_number' => date('Y-m-d H:i:s'),
                        'number' => $i,
                        'share_date' => $fecha.' 00:00:00',
                        'payment_date' => date('Y-m-d H:i:s'),
                        'receipt_number' => '',
                        'capital' => $capital_cuota,
                        'interest' => $interes_cuota,
                        'delay' => 0,
                        'total' => $cuota,
                        'total_payment' => 0,
                        'capital_balance' => $saldo_capital,
                        'interest_balance' => 0,
                        'total_balance' => $saldo_capital,
                        'capital_balance_payment' => 0,
                        'interest_balance_payment' => 0,
                        'total_balance_payment' => 0,
                        'days_delayed' => 0,
                        'created_user' => $user->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'payment_user' => $user->id,
                        'payment_at' => date('Y-m-d H:i:s'),
                    ]);
                    $total_interes=$total_interes+$interes_cuota;
                    $fixed_total_interes=$total_interes;
                }
            } else {
                $interes = Interest::find($this->interest_id);
                $plazo = TimeLimit::find($this->time_limit_id);
                $saldo_capital = $this->initial_capital;
                $capital_cuota = $this->initial_capital / $plazo->name;
                //$interes_cuota = ($this->initial_capital * (($interes->name / 12 / 100)*$plazo->name))/$plazo->name;
                //$interes_total = ($this->initial_capital * (($interes->name / 12 / 100)*$plazo->name));
                $interes_cuota = (((((($saldo_capital * ($interes->name / 100))/365)*31)*$plazo->name))/$plazo->name);
                $interes_total = ((((($saldo_capital * ($interes->name / 100))/365)*31)*$plazo->name));
                $fecha=date('Y-m-d',strtotime($this->expended_at));
                for($i=1; $i<=$plazo->name; $i++) {
                    $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
                    $saldo_capital = $saldo_capital - $capital_cuota;
                    $cuota=$interes_cuota+$capital_cuota;
                    $interes_total=$interes_total - $interes_cuota;
                    AmortizationSchedule::create([
                        'credit_id' => $credit->id,
                        'share_number' => date('Y-m-d H:i:s'),
                        'number' => $i,
                        'share_date' => $fecha.' 00:00:00',
                        'payment_date' => date('Y-m-d H:i:s'),
                        'receipt_number' => '',
                        'capital' => $capital_cuota,
                        'interest' => $interes_cuota,
                        'delay' => 0,
                        'total' => $cuota,
                        'total_payment' => 0,
                        'capital_balance' => $saldo_capital,
                        'interest_balance' => $interes_total,
                        'total_balance' => $saldo_capital + $interes_total,
                        'capital_balance_payment' => 0,
                        'interest_balance_payment' => 0,
                        'total_balance_payment' => 0,
                        'days_delayed' => 0,
                        'created_user' => $user->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'payment_user' => $user->id,
                        'payment_at' => date('Y-m-d H:i:s'),
                    ]);
                    $total_interes=$total_interes+$interes_cuota;
                    $fixed_total_interes=$total_interes;
                }
            }
        if($this->policy_id<3){
            foreach($credit->amortizacion_schedule as $amortizacion){
                $amortizacion->interest_balance=$total_interes-$amortizacion->interest;
                $amortizacion->total_balance=$amortizacion->interest_balance+$amortizacion->capital_balance;
                $total_interes=$amortizacion->interest_balance;
                $amortizacion->save();
            }
        }
        $credit->initial_interest_balance=$fixed_total_interes;
        $credit->initial_total_balance=$fixed_total_interes+$credit->initial_credit_capital;
        $credit->save();
        $this->dispatch('ok');
        $this->dispatch('redirect');
    }
}
