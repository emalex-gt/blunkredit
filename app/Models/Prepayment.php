<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prepayment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['amortization_schedule_id','date','payment_date','receipt_number','payment_user','payment_at','status'];
    
    public function amortization_schedule() {
        return $this->belongsTo('App\Models\AmortizationSchedule','amortization_schedule_id','id');
    }
    public function payment_by() {
        return $this->belongsTo('App\Models\User','payment_user','id');
    }
}
