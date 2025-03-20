<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interest;
use App\Models\TimeLimit;

class AmortizationSchedule extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['credit_id','share_number','number','share_date','payment_date','receipt_number','capital','interest','delay','total','capital_balance','interest_balance','total_balance','days_delayed','created_user','created_at','payment_user','payment_at','total_payment','capital_balance_payment','interest_balance_payment','total_balance_payment','status'];
    
    public function credit() {
        return $this->belongsTo('App\Models\Credit','credit_id','id');
    }
    public function created_by() {
        return $this->belongsTo('App\Models\User','created_user','id');
    }
    public function payment_by() {
        return $this->belongsTo('App\Models\User','payment_user','id');
    }
    public function prepayment() {
        return $this->hasMany('App\Models\Prepayment','amortization_schedule_id','id');
    }
    public function partialpayments() {
        return $this->hasMany('App\Models\PartialAmortizationSchedule','amortization_schedule_id','id');
    }
    public function cuota_nivelada($capital,$interes_id,$plazo_id){
        $interes = Interest::find($interes_id);
        $plazo = TimeLimit::find($plazo_id);
        $i = $interes->name / 12 / 100 ;
        $i2 = $i + 1 ;
        $i2 = pow($i2,-$plazo->name) ;

        $cuota = ($i * $capital) / (1 - $i2) ;

        return $cuota;

    }
}
