<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundStatementDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['fund_statement_id','credit_code','info','receipt_number','amount'];
    
    public function fund_statement() {
        return $this->belongsTo('App\Models\FundStatement','fund_statement_id','id');
    }
}
