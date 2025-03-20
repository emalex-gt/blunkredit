<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCheque extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['date','number','amount'];
}
