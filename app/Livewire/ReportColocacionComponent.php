<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Credit;
use App\Models\User;
use DB;
use Excel;

class ReportColocacionComponent extends Component
{
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
        $credits = Credit::where('status','>',2)
                            ->whereHas('expended_by', function (Builder $query) {
                                $query->where('id', $this->comparador, $this->asesor);
                            })
                            ->whereBetween('expended_at',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->paginate(30);
        return view('livewire.report-colocacion-component',compact('credits','asesores'));
    }
    public function export(){
        $amortizations = Credit::where('status','>',3)
                            ->whereHas('expended_by', function (Builder $query) {
                                $query->where('id', $this->comparador, $this->asesor);
                            })
                            ->whereBetween('expended_at',[$this->desde.' 00:00:00',$this->hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->paginate(30);
        //Creando Excel
        $i = 0;
        foreach ($amortizations as $s){
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
			},'reporte-colocacion-component.xlsx');
    }
}
