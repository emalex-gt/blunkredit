<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AmortizationSchedule;
use App\Models\Prepayment;
use App\Models\Credit;
use DateTime;

class CronController extends Controller
{
    //
    public function mora(){
        $amortizations=AmortizationSchedule::where('total_payment',0)
                                        ->where('share_date','<',date('Y-m-d').' 00:00:00')
                                        ->get();
        foreach($amortizations as $amortization){
            $datetime1 = new DateTime(date('Y-m-d',strtotime($amortization->share_date)));
            $datetime2 = new DateTime(date('Y-m-d'));
            $interval = $datetime1->diff($datetime2);
            $dias = $interval->format('%a');
            $mora_diaria = (($amortization->total*0.75)/365);
            $amortization->delay=$mora_diaria*$dias;
            $amortization->days_delayed=$dias;
            $amortization->save();
        }
    }
    public function adelantados(){
        $today=date('Y-m-d').' 23:59:59';
        $prepayments=Prepayment::where('status',1)
                                        ->where('date','<',$today)
                                        ->get();
        foreach($prepayments as $prepayment){
            $amortizationschedule=AmortizationSchedule::find($prepayment->amortization_schedule_id);
            $credit = Credit::find($amortizationschedule->credit_id);
        
            //Save Amortization
            $amortizationschedule->receipt_number=$prepayment->receipt_number;
            $amortizationschedule->payment_date=$prepayment->payment_date;
            $amortizationschedule->total_payment=($amortizationschedule->capital + $amortizationschedule->interest + $amortizationschedule->delay);
            $amortizationschedule->capital_balance_payment=$credit->amortized_credit_capital + $amortizationschedule->capital;
            $amortizationschedule->interest_balance_payment=$credit->interest_paid + $amortizationschedule->interest;
            $amortizationschedule->total_balance_payment=$credit->total_paid + $amortizationschedule->total_payment;
            $amortizationschedule->payment_user=$prepayment->payment_user;
            $amortizationschedule->payment_at=$prepayment->payment_at;
            $amortizationschedule->save();

            //Update Credit
            $credit->amortized_credit_capital= $credit->amortized_credit_capital + $amortizationschedule->capital;
            $credit->pending_credit_capital= $credit->pending_credit_capital - $amortizationschedule->capital;
            $credit->interest_paid= $credit->interest_paid + $amortizationschedule->interest;
            $credit->delay_paid= $credit->delay_paid + $amortizationschedule->delay;
            $credit->total_paid= $credit->total_paid + $amortizationschedule->total_payment;
            $credit->save();

            $prepayment->status=0;
            $prepayment->save();
        }
    }
}
