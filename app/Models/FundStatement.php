<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundStatement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['fund_id','date','type','credit','debit','balance','create_user'];
    
    public function fund() {
        return $this->belongsTo('App\Models\Fund','fund_id','id');
    }
    public function created_by() {
        return $this->belongsTo('App\Models\User','create_user','id');
    }
}
