<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AmortizationSchedule;
use App\Models\PartialAmortizationSchedule;
use App\Models\Credit;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use Auth;
use DateTime;
use Log;

class AmortizationComponent extends Component
{
    public $open=false;
    public $amortizationschedule;
    public $total_payment, $payment_date;

    protected $rules = [
        'amortizationschedule.receipt_number' => 'required',
        'total_payment' => 'required',
        'payment_date' => 'required',
    ];

    protected $listeners = ['save' => 'save'];

    public function mount(AmortizationSchedule $amortizationschedule){
        $this->amortizationschedule=$amortizationschedule;
        $this->payment_date=date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.amortization-component');
    }
    
    public function save(){
        $this->validate();

        $cuenta=0;

        if(count($this->amortizationschedule->credit->partial_payments()->where('amortization_schedule_id',0)->get()) > 0){
            foreach($this->amortizationschedule->credit->partial_payments()->where('amortization_schedule_id',0)->get() as $partialpayment){
                $cuenta=$cuenta+$partialpayment->amount;
            }
        }
        
        $partial_cuenta_total=0;
        $partial_cuenta_capital=0;
        $partial_cuenta_interest=0;
        $partial_cuenta_delay=0;

        if($this->amortizationschedule->status == 2){
            foreach($this->amortizationschedule->partialpayments()->get() as $partial){
                $partial_cuenta_total=$partial_cuenta_total+$partial->total_payment;
                $partial_cuenta_capital=$partial_cuenta_capital+$partial->capital;
                $partial_cuenta_interest=$partial_cuenta_interest+$partial->interest;
                $partial_cuenta_delay=$partial_cuenta_delay+$partial->delay;
            }
        }

        $ultimo_pago=$this->amortizationschedule->credit->amortizacion_schedule()->orderBy('number','desc')->first()->id;
        if((($this->amortizationschedule->days_delayed > 0) && ($ultimo_pago<>$this->amortizationschedule->id)) or ($this->amortizationschedule->credit->policy_id>2)){
            $this->amortizationschedule->interest=$this->amortizationschedule->interest;
        } else {
            $interes_diario=($this->amortizationschedule->interest / 30);
            $fecha_pago=$this->amortizationschedule->credit->amortizacion_schedule()->where('status','>',2)->orderBy('id','desc')->first()->payment_date;
            $fecha_tabla=$this->amortizationschedule->credit->amortizacion_schedule()->where('status','>',2)->orderBy('id','desc')->first()->share_date;
            if(strtotime($fecha_tabla) <= strtotime($fecha_pago)){
                $date1 = new DateTime(date('Y-m-d',strtotime($this->payment_date)));
                $date2 = new DateTime(date('Y-m-d',strtotime($fecha_tabla)));
            } else {
                $date1 = new DateTime(date('Y-m-d',strtotime($this->payment_date)));
                $date2 = new DateTime(date('Y-m-d',strtotime($fecha_pago)));
            }
            $diff = $date1->diff($date2);
            $this->amortizationschedule->interest=($interes_diario * $diff->days);
        }

        $diferencia=(($this->amortizationschedule->capital+$this->amortizationschedule->interest+$this->amortizationschedule->delay-$cuenta-$partial_cuenta_total)-$this->total_payment);

        if(number_format($diferencia,2,'.','') < 0){
            $this->dispatch('error');
        } else {
            $user = Auth::user();
            $credit = Credit::find($this->amortizationschedule->credit_id);
            
            //Save Amortization
            $total_p=($this->amortizationschedule->capital + $this->amortizationschedule->interest + $this->amortizationschedule->delay);
            if(number_format($diferencia,2,'.','') > 0 or $this->amortizationschedule->status == 2){
                $diference=$this->total_payment;
                if(($this->amortizationschedule->capital - $partial_cuenta_capital) < $diference) {
                    $n_capital=$this->amortizationschedule->capital - $partial_cuenta_capital;
                    $diference=$diference - ($this->amortizationschedule->capital  - $partial_cuenta_capital);
                } else {
                    $n_capital=$diference;
                    $diference=0;
                }
                if(($this->amortizationschedule->interest - $partial_cuenta_interest) < $diference) {
                    $n_interest=$this->amortizationschedule->interest - $partial_cuenta_interest;
                    $diference=$diference - ($this->amortizationschedule->interest - $partial_cuenta_interest);
                    $diference2=$diference;
                } else {
                    $n_interest=$diference;
                    $diference=0;
                }
                if(($this->amortizationschedule->delay - $partial_cuenta_delay) < $diference) {
                    $n_delay=$this->amortizationschedule->delay - $partial_cuenta_delay;
                    $diference=$diference - ($this->amortizationschedule->delay - $partial_cuenta_delay);
                } else {
                    $n_delay=$diference;
                    $diference=0;
                }
                $n_total=$this->total_payment;
                PartialAmortizationSchedule::create([
                    'credit_id' => $credit->id,
                    'payment_date' => $this->payment_date,
                    'amortization_schedule_id' => $this->amortizationschedule->id,
                    'payment_date' => $this->payment_date,
                    'receipt_number' => $this->amortizationschedule->receipt_number,
                    'capital' => $n_capital,
                    'interest' => $n_interest,
                    'delay' => $n_delay,
                    'total' => $n_total,
                    'total_payment' => $n_total,
                    'capital_balance' => $this->amortizationschedule->capital_balance,
                    'interest_balance' => $this->amortizationschedule->interest_balance,
                    'total_balance' => $this->amortizationschedule->total_balance,
                    'capital_balance_payment' => $credit->amortized_credit_capital + $n_capital,
                    'interest_balance_payment' => $credit->interest_paid + $n_interest,
                    'total_balance_payment' => $credit->total_paid + $n_total,
                    'days_delayed' => $this->amortizationschedule->days_delayed,
                    'created_user' => $user->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'payment_user' => $user->id,
                    'payment_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $n_capital=$this->amortizationschedule->capital;
                $n_interest=$this->amortizationschedule->interest;
                $n_total=$this->amortizationschedule->total_payment;
                $n_delay=$this->amortizationschedule->delay;
            }
            $this->amortizationschedule->capital_balance_payment=$credit->amortized_credit_capital + $n_capital;
            $this->amortizationschedule->interest_balance_payment=$credit->interest_paid + $n_interest;
            $this->amortizationschedule->total_balance_payment=$credit->total_paid + $n_total;
            $this->amortizationschedule->payment_user=$user->id;
            $this->amortizationschedule->payment_date=$this->payment_date;
            $this->amortizationschedule->total_payment=$this->amortizationschedule->total_payment + $this->total_payment;;
            $this->amortizationschedule->payment_at=date('Y-m-d H:i:s');
            if(number_format($diferencia,2,'.','') > 0){
                //Se marca como pago parcial
                $this->amortizationschedule->status=2;
            } else {
                //Se marca el pago completo
                if($this->amortizationschedule->status==2)
                    $this->amortizationschedule->status=3;
                else
                    $this->amortizationschedule->status=4;
                
                if($ultimo_pago==$this->amortizationschedule->id){
                    //Si es el ultimo pago marcamos el credito como finalizado.
                    $credit->status=4;
                } else {
                    //Si se pago antes, se modifica el interes del siguiente pago
                    if($this->amortizationschedule->credit->policy_id<3){
                        $siguiente_pago=$this->amortizationschedule->credit->amortizacion_schedule()->where('status',1)->where('id','<>',$this->amortizationschedule->id)->orderBy('id','asc')->first();
                        if ($siguiente_pago) {
                            $siguiente = AmortizationSchedule::find($siguiente_pago->id);
                            $_interes_diario=($siguiente->interest / 30);
                            $_fecha_pago=$this->amortizationschedule->payment_date;
                            $_fecha_tabla=$this->amortizationschedule->share_date;
                            if(strtotime($_fecha_tabla) > strtotime($_fecha_pago)){
                                $_date1 = new DateTime(date('Y-m-d',strtotime($_fecha_pago)));
                                $_date2 = new DateTime(date('Y-m-d',strtotime($_fecha_tabla)));
                                $_diff = $_date1->diff($_date2);
                                $siguiente->interest=($_interes_diario * ($_diff->days + 30));
                                $siguiente->save();
                            }
                        }
                    }
                }
            }
            $this->amortizationschedule->save();

            //Update Credit
            $credit->amortized_credit_capital= $credit->amortized_credit_capital + $n_capital;
            $credit->pending_credit_capital= $credit->pending_credit_capital - $n_capital;
            $credit->interest_paid= $credit->interest_paid + $n_interest;
            $credit->delay_paid= $credit->delay_paid + $n_delay;
            $credit->total_paid= $credit->total_paid + $n_total;
            $credit->save();

            foreach($this->amortizationschedule->credit->partial_payments()->where('amortization_schedule_id',0)->get() as $prepayment){
                $prepayment->amortization_schedule_id = $this->amortizationschedule->id;
                $prepayment->save();

                //Statement
                $last_statement=FundStatement::where('fund_id',4)->orderBy('id','desc')->first();
                if($last_statement===NULL){
                    $bal=0;
                } else {
                    $bal=$last_statement->balance;
                }
                
                $fund_statament=FundStatement::create([
                    'fund_id' => 4,
                    'date' => date('Y-m-d H:i:s'),
                    'type' => 6,
                    'credit' => 0,
                    'debit' => $prepayment->amount,
                    'balance' => $bal - $prepayment->amount,
                    'create_user' => $user->id
                ]);
                FundStatementDetail::create([
                    'fund_statement_id' => $fund_statament->id,
                    'credit_code' => 0,
                    'info' => 'Retiro de Pago Parcial a Abono #'.$this->amortizationschedule->id.' en Crédito '.$this->amortizationschedule->credit->code,
                    'receipt_number' => $prepayment->receipt_number,
                    'amount' => $prepayment->amount
                ]);
            }

            //Statement Capital
            $last_statement=FundStatement::where('fund_id',$credit->fund_id)->orderBy('id','desc')->first();
            if($last_statement===NULL){
                $bal=0;
            } else {
                $bal=$last_statement->balance;
            }
                    
            $fund_statament=FundStatement::create([
                'fund_id' => $credit->fund_id,
                'date' => date('Y-m-d H:i:s'),
                'type' => 5,
                'credit' => $n_capital,
                'debit' => 0,
                'balance' => $bal + $n_capital,
                'create_user' => $user->id
            ]);
            FundStatementDetail::create([
                'fund_statement_id' => $fund_statament->id,
                'credit_code' => $credit->id,
                'info' => 'Abono No. '.$this->amortizationschedule->id.' de Capital a Crédito '.$credit->code,
                'receipt_number' => $this->amortizationschedule->receipt_number,
                'amount' => $n_capital
            ]);

            //Statement Interes
            $last_statement=FundStatement::where('fund_id',1)->orderBy('id','desc')->first();
            if($last_statement===NULL){
                $bal=0;
            } else {
                $bal=$last_statement->balance;
            }
                    
            $fund_statament=FundStatement::create([
                'fund_id' => 1,
                'date' => date('Y-m-d H:i:s'),
                'type' => 5,
                'credit' => $n_interest,
                'debit' => 0,
                'balance' => $bal + $n_interest,
                'create_user' => $user->id
            ]);
            FundStatementDetail::create([
                'fund_statement_id' => $fund_statament->id,
                'credit_code' => $credit->id,
                'info' => 'Abono No. '.$this->amortizationschedule->id.' de Interés a Crédito '.$credit->code,
                'receipt_number' => $this->amortizationschedule->receipt_number,
                'amount' => $n_interest
            ]);

            //Statement Mora
            if($n_delay > 0){
                $last_statement=FundStatement::where('fund_id',1)->orderBy('id','desc')->first();
                if($last_statement===NULL){
                    $bal=0;
                } else {
                    $bal=$last_statement->balance;
                }
                        
                $fund_statament=FundStatement::create([
                    'fund_id' => 1,
                    'date' => date('Y-m-d H:i:s'),
                    'type' => 5,
                    'credit' => $n_delay,
                    'debit' => 0,
                    'balance' => $bal + $n_delay,
                    'create_user' => $user->id
                ]);
                FundStatementDetail::create([
                    'fund_statement_id' => $fund_statament->id,
                    'credit_code' => $credit->id,
                    'info' => 'Abono No. '.$this->amortizationschedule->id.' de Mora a Crédito '.$credit->code,
                    'receipt_number' => $this->amortizationschedule->receipt_number,
                    'amount' => $n_delay
                ]);
            }

            $this->reset('open');
            $this->dispatch('ok');
            $this->dispatch('redirect');
        }
    }
}
