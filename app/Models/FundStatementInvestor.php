<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundStatementInvestor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['fund_statement_id','investor_id'];
    
    public function fund_statement() {
        return $this->belongsTo('App\Models\FundStatement','fund_statement_id','id');
    }
    public function investor() {
        return $this->belongsTo('App\Models\Investors','investor_id','id');
    }
}
