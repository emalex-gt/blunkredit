<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartialPayment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['credit_id','date','create_user','payment_at','payment_user','amount','amortization_schedule_id','receipt_number'];
    
    public function credit() {
        return $this->belongsTo('App\Models\Credit','credit_id','id');
    }
    public function created_by() {
        return $this->belongsTo('App\Models\User','create_user','id');
    }
    public function payment_by() {
        return $this->belongsTo('App\Models\User','payment_user','id');
    }
}
