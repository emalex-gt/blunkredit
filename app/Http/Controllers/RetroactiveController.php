<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\AmortizationSchedule;

class RetroactiveController extends Controller
{
    //
    public function save(Request $request){
        $post = $request->all();
        //print_r($post);die();
        $i=0;
        foreach($post['share_date'] as $key => $value){
            if($i==0)
                $initial=$key;
            $final=$key;
            $i++;
        }
        $payment_capital=0;
        $payment_interest=0;
        $payment_delay=0;
        $payment_total=0;
        for ($i = $initial; $i <= $final; $i++) {
            if($post['status'][$i]==1){
                $table=AmortizationSchedule::find($i);
                if($post['receipt_number'][$i]!='')
                    $table->receipt_number=$post['receipt_number'][$i];
                $table->share_date=$post['share_date'][$i];
                $table->capital=$post['capital'][$i];
                $payment_capital=$payment_capital+$post['capital'][$i];
                $table->interest=$post['interest'][$i];
                $payment_interest=$payment_interest+$post['interest'][$i];
                $table->days_delayed=$post['days_delayed'][$i];
                $table->delay=$post['delay'][$i];
                $payment_delay=$payment_delay+$post['delay'][$i];
                $table->total_payment=$post['total_payment'][$i];
                $payment_total=$payment_total+$post['total_payment'][$i];
                $table->payment_date=$post['payment_date'][$i];
                $table->payment_at=$post['payment_date'][$i];
                $table->save();
            }
        }
        $credit=Credit::find($table->credit_id);
        $credit->amortized_credit_capital=$payment_capital;
        $credit->pending_credit_capital=$credit->initial_credit_capital - $payment_capital;
        $credit->interest_paid=$payment_interest;
        $credit->delay_paid=$payment_delay;
        $credit->total_paid=$payment_total;
        $credit->status=3;
        $credit->save();
        return redirect('/credito/'.$credit->id);
    }

}
