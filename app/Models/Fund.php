<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','status'];

    public function statements() {
        return $this->hasMany('App\Models\FundStatement','fund_id','id');
    }
    public function expenses() {
        return $this->hasMany('App\Models\Expense','expense_type_id','id');
    }
}
