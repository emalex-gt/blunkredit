<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['date','amount','info','created_by','fund_id','expense_type_id','fund_statement_id','status'];

    public function fund_statement() {
        return $this->belongsTo('App\Models\FundStatement','fund_statement_id','id');
    }
    public function fund() {
        return $this->belongsTo('App\Models\Fund','fund_id','id');
    }
    public function creator() {
        return $this->belongsTo('App\Models\User','created_by','id');
    }
    public function expense_type() {
        return $this->belongsTo('App\Models\ExpenseType','expense_type_id','id');
    }
    

}
