<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arqueo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['date','b200','b100','b50','b20','b10','b5','b1','m1','m05','m025','m01','m005','m001','total_efectivo','total_cheque','total_arqueado','informe_diario','diferencia','info'];
}
