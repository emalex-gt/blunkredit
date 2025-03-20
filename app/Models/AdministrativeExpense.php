<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeExpense extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = ['credit_id','type','description','amount','created_user','created_at'];
    
    public function credit() {
        return $this->belongsTo('App\Models\Credit','credit_id','id');
    }
    public function created_by() {
        return $this->belongsTo('App\Models\User','created_user','id');
    }
}
