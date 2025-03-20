<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartialAmortizationSchedule extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['credit_id','amortization_schedule_id','payment_date','receipt_number','capital','interest','delay','total','total_payment','capital_balance','interest_balance','total_balance','capital_balance_payment','interest_balance_payment','total_balance_payment','days_delayed','created_user','created_at','payment_user','payment_at'];
    
    public function amortization_schedule() {
        return $this->belongsTo('App\Models\AmortizationSchedule','amortization_schedule_id ','id');
    }
    public function credit() {
        return $this->belongsTo('App\Models\Credit','credit_id','id');
    }
    public function created_by() {
        return $this->belongsTo('App\Models\User','created_user','id');
    }
    public function payment_by() {
        return $this->belongsTo('App\Models\User','payment_user','id');
    }
}
