<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Prepayment;
use App\Models\User;
use DB;
use Excel;

class ReportAdelantadosComponent extends Component
{
    public $search='';
    public $desde;
    public $hasta;
    public $asesor;
    public $comparador='=';
    
    public function mount(){
        $this->desde=date('Y-m').'-01';
        $this->hasta=date('Y-m-d');
        $this->asesor=0;
    }

    public function render()
    {
        $asesores = User::get();
        if($this->asesor==0)
            $this->comparador='>';
        else
            $this->comparador='=';
        $prepayments = Prepayment::where('status',1)
                            ->where(function ($query) {
                                $query->whereHas('amortization_schedule', function (Builder $query) {
                                    $query->whereHas('credit', function (Builder $query) {
                                        $query->whereHas('customer', function (Builder $query) {
                                            $query->where(DB::raw('CONCAT(name,dpi,email,code)'), 'like','%'.$this->search.'%');
                                        });
                                    });
                                });
                            })
                            ->whereHas('payment_by', function (Builder $query) {
                                $query->where('id', $this->comparador, $this->asesor);
                            })
                            ->whereBetween('date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->paginate(30);
        return view('livewire.report-adelantados-component',compact('prepayments','asesores'));
    }
    public function export(){
        $prepayments = Prepayment::where('status',1)
                            ->where(function ($query) {
                                $query->whereHas('amortization_schedule', function (Builder $query) {
                                    $query->whereHas('credit', function (Builder $query) {
                                        $query->whereHas('customer', function (Builder $query) {
                                            $query->where(DB::raw('CONCAT(name,dpi,email,code)'), 'like','%'.$this->search.'%');
                                        });
                                    });
                                });
                            })
                            ->whereBetween('date',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->paginate(30);
        //Creando Excel
        $i = 0;
        foreach ($prepayments as $s){
            $dat = (array) $s;
            $data[] = $dat;
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        Excel::download(function($excel) use($data) 
			{
				$excel->sheet('datos', function($sheet) use($data) 
				{
					$sheet->fromArray($data);
				});
			},'reporte-adelantados-component.xlsx');
    }
}
