<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['code','customer_id','tecnology_id','fund_id','guarantee_id','file_number','credit_line_id','time_limit_id','interest_id','initial_credit_capital','amortized_credit_capital','pending_credit_capital','interest_paid','delay_paid','total_paid','share','created_user','created_at','authorized_user','authorized_at','expended_user','expended_at','status','policy_id','initial_interest_balance','initial_total_balance','cheque_id','cheque_no','contract_no','retroactive'];

    public function customer() {
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }
    public function cheque() {
        return $this->belongsTo('App\Models\Cheques','cheque_id','id');
    }
    public function tecnology() {
        return $this->belongsTo('App\Models\Tecnology','tecnology_id','id');
    }
    public function fund() {
        return $this->belongsTo('App\Models\Fund','fund_id','id');
    }
    public function guarantee() {
        return $this->belongsTo('App\Models\Guarantee','guarantee_id','id');
    }
    public function credit_line() {
        return $this->belongsTo('App\Models\CreditLine','credit_line_id','id');
    }
    public function time_limit() {
        return $this->belongsTo('App\Models\TimeLimit','time_limit_id','id');
    }
    public function interest() {
        return $this->belongsTo('App\Models\Interest','interest_id','id');
    }
    public function policy() {
        return $this->belongsTo('App\Models\Policy','policy_id','id');
    }
    public function administrative_expenses() {
        return $this->hasMany('App\Models\AdministrativeExpense','credit_id','id');
    }
    public function amortizacion_schedule() {
        return $this->hasMany('App\Models\AmortizationSchedule','credit_id','id');
    }
    public function created_by() {
        return $this->belongsTo('App\Models\User','created_user','id');
    }
    public function authorized_by() {
        return $this->belongsTo('App\Models\User','authorized_user','id');
    }
    public function expended_by() {
        return $this->belongsTo('App\Models\User','expended_user','id');
    }
    public function partial_payments() {
        return $this->hasMany('App\Models\PartialPayment','credit_id','id');
    }
}
