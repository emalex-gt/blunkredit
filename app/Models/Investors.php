<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investors extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['type','dpi','name','lastname','email','phone','address','status'];
    
    public function stataments() {
        return $this->hasMany('App\Models\FundStatementInvestor','investor_id','id');
    }
}
