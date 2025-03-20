<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name','lastname','address','phone','dpi','email','code','status'];

    public function credits() {
        return $this->hasMany('App\Models\Credit','customer_id','id');
    }
}
