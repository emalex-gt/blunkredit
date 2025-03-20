<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Credit;
use App\Models\AmortizationSchedule;
use App\Models\PartialAmortizationSchedule;
use App\Models\User;
use App\Models\Prepayment;
use App\Models\PartialPayment;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Arqueo;
use App\Models\PagoCheque;
use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class PrintController extends Controller
{
    //
    public function imprimir_recibo($id){
        $amortization=AmortizationSchedule::find($id);
        return view('pdf.imprimir-recibo',compact('amortization'));
    }
    public function imprimir_recibo_partial($id){
        $amortization=PartialAmortizationSchedule::find($id);
        return view('pdf.imprimir-recibo',compact('amortization'));
    }
    public function imprimir_adelanto($id){
        $prepayment=Prepayment::find($id);
        return view('pdf.imprimir-adelanto',compact('prepayment'));
    }
    public function imprimir_parcial($id){
        $partialpayment=PartialPayment::find($id);
        return view('pdf.imprimir-parcial',compact('partialpayment'));
    }
    public function reglamodificada($id){
        $credit=Credit::find($id);
        //return view('pdf.regla-modificada',compact('credit'));
        $pdf = Pdf::loadView('pdf.regla-modificada',compact('credit'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'portrait');
        return $pdf->download('regla-modificada-'.$id.'.pdf');
    }
    public function reglamodificada_word($id){
        $credit=Credit::find($id);
        return view('pdf.regla-modificada-word',compact('credit'));
    }
    public function reglageneral($id){
        $credit=Credit::find($id);
        //return view('pdf.regla-general',compact('credit'));
        $pdf = Pdf::loadView('pdf.regla-general',compact('credit'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'portrait');
        return $pdf->download('regla-general-'.$id.'.pdf');
    }
    public function reglageneral_word($id){
        $credit=Credit::find($id);
        return view('pdf.regla-general-word',compact('credit'));
    }
    public function print_reporte_morosos(){
        /*$amortizations = AmortizationSchedule::where('days_delayed','>',0)
                            ->where('total_payment',0)
                            ->orderBy('id','desc')
                            ->get();
        $users=User::where('id',1)->get();*/
        $users = User::whereHas('credits', function (Builder $query) {
                        $query->whereHas('amortizacion_schedule', function (Builder $query) {
                            $query->where('days_delayed','>',0)
                                    ->where('total_payment',0);
                        });
                    })->get();
        $users_total=User::get();
        //return view('pdf.reporte-morosos',compact('amortizations','users'));
        $pdf = Pdf::loadView('pdf.reporte-morosos',compact('users_total','users'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-morosos.pdf');
    }
    public function export_reporte_morosos(){
        /*$amortizations = AmortizationSchedule::where('days_delayed','>',0)
                            ->where('total_payment',0)
                            ->orderBy('id','desc')
                            ->get();
        $users=User::where('id',1)->get();*/
        $users = User::whereHas('credits', function (Builder $query) {
                        $query->whereHas('amortizacion_schedule', function (Builder $query) {
                            $query->where('days_delayed','>',0)
                                    ->where('total_payment',0);
                        });
                    })->get();
        $users_total=User::get();
        $total_total_monto=0;
        $total_total_saldo=0;
        $total_total_capital_atrasado=0;
        $total_total_capital=0;
        $total_total_interes=0;
        $total_total_mora=0;
        $total_total_total=0;

        $total_cartera_monto=0;
        $total_cartera_saldo=0;
        foreach($users as $user){
            $data[] = [
                'Crédito / Dirección',
                'Usuario',
                'Fondo',
                'Monto',
                'Cuota',
                'Saldo Actual',
                'Capital Atrasado',
                'Capital',
                'Interés',
                'Mora',
                'Descuento',
                'Total',
                'Días Atraso',
                'Fecha Venc.',
                'Día Pago'
            ];
            $data[] = [
                ''
            ];
            $data[]= [
                $user->name
            ];
            $data[] = [
                ''
            ];
            $total_monto=0;
            $total_saldo=0;
            $total_capital_atrasado=0;
            $total_capital=0;
            $total_interes=0;
            $total_mora=0;
            $total_total=0;
            foreach($user->credits as $credit){
                foreach($credit->amortizacion_schedule->where('days_delayed','>',0) as $amortization){
                    $data[] = [
                        $amortization->credit->code.' '.$amortization->credit->customer->name.' '.$amortization->credit->customer->lastname.' / '.$amortization->credit->customer->address.' '.$amortization->credit->customer->phone,
                        $amortization->credit->created_by->name,
                        $amortization->credit->fund->name,
                        number_format($amortization->credit->initial_credit_capital,2,'.',','),
                        number_format(($amortization->total),2,'.',','),
                        number_format($amortization->credit->pending_credit_capital,2,'.',','),
                        number_format($amortization->capital,2,'.',','),
                        number_format($amortization->capital,2,'.',','),
                        number_format($amortization->interest,2,'.',','),
                        number_format($amortization->delay,2,'.',','),
                        '0.00',
                        number_format(($amortization->total + $amortization->delay),2,'.',','),
                        $amortization->days_delayed,
                        date('d/m/Y',strtotime($amortization->share_date)),
                        date('d',strtotime($amortization->share_date))
                    ];
                    $total_monto=$total_monto+$amortization->credit->initial_credit_capital;
                    $total_saldo=$total_saldo+$amortization->credit->pending_credit_capital;
                    $total_capital_atrasado=$total_capital_atrasado+$amortization->capital;
                    $total_capital=$total_capital+$amortization->capital;
                    $total_interes=$total_interes+$amortization->interest;
                    $total_mora=$total_mora+$amortization->delay;
                    $total_total=$total_total+($amortization->total + $amortization->delay);
                }
            }
            $total_total_monto=$total_total_monto+$total_monto;
            $total_total_saldo=$total_total_saldo+$total_saldo;
            $total_total_capital_atrasado=$total_total_capital_atrasado+$total_capital_atrasado;
            $total_total_capital=$total_total_capital+$total_capital;
            $total_total_interes=$total_total_interes+$total_interes;
            $total_total_mora=$total_total_mora+$total_mora;
            $total_total_total=$total_total_total+$total_total;
            $data[] = [
                '',
                '',
                'Total por Asesor',
                number_format($total_monto,2,'.',','),
                '',
                number_format($total_saldo,2,'.',','),
                number_format($total_capital_atrasado,2,'.',','),
                number_format($total_capital,2,'.',','),
                number_format($total_interes,2,'.',','),
                number_format($total_mora,2,'.',','),
                '',
                number_format(($total_total),2,'.',','),
                '',
                '',
                ''
            ];
            $cartera_monto=0;
            $cartera_saldo=0;
            foreach($user->credits as $credit){
                $cartera_monto=$cartera_monto+$credit->initial_credit_capital;
                $cartera_saldo=$cartera_saldo+$credit->pending_credit_capital;
            }
            $data[] = [
                '',
                '',
                'Cartera Total',
                number_format($cartera_monto,2,'.',','),
                '',
                number_format($cartera_saldo,2,'.',','),
                '',
                '',
                '',
                '',
                '',
                '',
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                'Coeficientes de la Cartera'
            ];
            $data[] = [
                'Monto Entregado',
                $cartera_monto,
                '100%',
            ];
            $data[] = [
                'Cartera Pagada',
                number_format(($cartera_monto - $cartera_saldo),2,'.',','),
                number_format(((($cartera_monto-$cartera_saldo)/$cartera_monto)*100),2,'.',',').'%'
            ];
            $data[] = [
                'Cartera Mora',
                number_format($total_capital_atrasado,2,'.',','),
                number_format((($total_capital_atrasado/$cartera_monto)*100),2,'.',',').'%'
            ];
            $data[] = [
                'Capital en Riesgo',
                number_format($total_saldo,2,'.',','),
                number_format((($total_saldo/$cartera_monto)*100),2,'.',',').'%'
            ];
            $data[] = [
                'Saldo de la Cartera',
                number_format($cartera_saldo,2,'.',','),
                number_format((($cartera_saldo/$cartera_monto)*100),2,'.',',').'%'
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
        }
        foreach($users_total as $us){
            foreach($us->credits as $cred){
                $total_cartera_monto=$total_cartera_monto+$cred->initial_credit_capital;
                $total_cartera_saldo=$total_cartera_saldo+$cred->pending_credit_capital;
            }
        }
        $data[]=[
            '',
            'Monto / Cuota',
            'Saldo Actual',
            'Capital Atrasado',
            'Capital',
            'Interés',
            'Mora / Descuento'
        ];
        $data[]=[
            'Total General',
            number_format($total_total_monto,2,'.',','),
            number_format($total_total_saldo,2,'.',','),
            number_format($total_total_capital_atrasado,2,'.',','),
            number_format($total_total_capital,2,'.',','),
            number_format($total_total_interes,2,'.',','),
            number_format($total_total_mora,2,'.',','),
        ];
        $data[]=[
            'Cartera Total',
            number_format($total_cartera_monto,2,'.',','),
            number_format($total_cartera_saldo,2,'.',','),
            '',
            '',
            '',
            '',
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'Coeficientes de la Cartera'
        ];
        $data[] = [
            'Monto Entregado',
            $total_cartera_monto,
            '100%',
        ];
        $data[] = [
            'Cartera Pagada',
            number_format(($total_cartera_monto - $total_cartera_saldo),2,'.',','),
            number_format(((($total_cartera_monto-$total_cartera_saldo)/$total_cartera_monto)*100),2,'.',',').'%'
        ];
        $data[] = [
            'Cartera Mora',
            number_format($total_total_capital_atrasado,2,'.',','),
            number_format((($total_total_capital_atrasado/$total_cartera_monto)*100),2,'.',',').'%'
        ];
        $data[] = [
            'Capital en Riesgo',
            number_format($total_total_saldo,2,'.',','),
            number_format((($total_total_saldo/$total_cartera_monto)*100),2,'.',',').'%'
        ];
        $data[] = [
            'Saldo de la Cartera',
            number_format($total_cartera_saldo,2,'.',','),
            number_format((($total_cartera_saldo/$total_cartera_monto)*100),2,'.',',').'%'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        //return view('pdf.reporte-morosos',compact('amortizations','users'));
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-morosos.xlsx');
    }

    public function print_reporte_proyeccion($desde,$hasta){
        $amortizations = DB::table('amortization_schedules as a')
                            ->select('a.id','a.share_date','c.code','c.created_user','cl.lastname','cl.name','cl.address','cl.phone','u.name as user','a.capital','a.interest','a.total','a.delay','f.name as fund')
                            ->join('credits as c','c.id','=','a.credit_id')
                            ->join('funds as f','f.id','=','c.fund_id')
                            ->join('users as u','u.id','=','c.created_user')
                            ->join('customers as cl','cl.id','=','c.customer_id')
                            ->where('a.total_payment',0)
                            ->where(function($query) use($desde, $hasta)
                            {
                                $query->where(function($query) use($desde, $hasta)
                                {
                                    $query->whereBetween('a.share_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                                    ->where('a.delay',0);

                                })
                                ->orWhere('a.delay','>',0);
                            })
                            ->orderBy('c.created_user','asc')
                            ->orderBy('a.share_date','asc')
                            ->get();
        //return view('pdf.reporte-proyeccion',compact('amortizations','desde','hasta'));
        $pdf = Pdf::loadView('pdf.reporte-proyeccion',compact('amortizations','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-proyeccion.pdf');
    }
    public function export_reporte_proyeccion($desde,$hasta){
        $amortizations = DB::table('amortization_schedules as a')
                            ->select('a.id','a.share_date','c.code','c.created_user','cl.lastname','cl.name','cl.address','cl.phone','u.name as user','a.capital','a.interest','a.total','a.delay','f.name as fund')
                            ->join('credits as c','c.id','=','a.credit_id')
                            ->join('funds as f','f.id','=','c.fund_id')
                            ->join('users as u','u.id','=','c.created_user')
                            ->join('customers as cl','cl.id','=','c.customer_id')
                            ->where('a.total_payment',0)
                            ->where(function($query) use($desde, $hasta)
                            {
                                $query->where(function($query) use($desde, $hasta)
                                {
                                    $query->whereBetween('a.share_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                                    ->where('a.delay',0);

                                })
                                ->orWhere('a.delay','>',0);
                            })
                            ->orderBy('c.created_user','asc')
                            ->orderBy('a.share_date','asc')
                            ->get();
        $data[]=[
            'Crédito',
            'Nombre Completo',
            'Dirección',
            'Fondo',
            'Teléfono',
            'Capital',
            'Interés',
            'Mora',
            'Total'
        ];
        $total_capital=0;
        $total_interes=0;
        $total_delay=0;
        $total=0;

        $total_day_capital=0;
        $total_day_interes=0;
        $total_day_delay=0;
        $total_day=0;

        $dia='';
        $asesor='';
        foreach ($amortizations as $amortization){
            if($asesor!=$amortization->created_user){
                $data[]=[
                    $amortization->user
                ];
                $asesor=$amortization->created_user;
            }
            if($dia!='' && $dia!=date('Y-m-d',strtotime($amortization->share_date))){
                $data[]=[
                    '',
                    '',
                    '',
                    'Total del día '.date('d/m/Y',strtotime($dia)),
                    '',
                    number_format($total_day_capital,2,'.',','),
                    number_format($total_day_interes,2,'.',','),
                    number_format($total_day_delay,2,'.',','),
                    number_format($total_day,2,'.',',')
                ];
                $data[]=[
                    ''
                ];
                $total_day_capital=0;
                $total_day_interes=0;
                $total_day_delay=0;
                $total_day=0;
            }
            $data[]=[
                $amortization->code,
                $amortization->lastname.', '.$amortization->name,
                $amortization->address,
                $amortization->fund,
                $amortization->phone,
                number_format($amortization->capital,2,'.',','),
                number_format($amortization->interest,2,'.',','),
                number_format($amortization->delay,2,'.',','),
                number_format(($amortization->total+$amortization->delay),2,'.',','),
            ];
            $dia=date('Y-m-d',strtotime($amortization->share_date));
            $total_capital=$total_capital+$amortization->capital;
            $total_interes=$total_interes+$amortization->interest;
            $total_delay=$total_delay+$amortization->delay;
            $total=$total+($amortization->total+$amortization->delay);

            $total_day_capital=$total_day_capital+$amortization->capital;
            $total_day_interes=$total_day_interes+$amortization->interest;
            $total_day_delay=$total_day_delay+$amortization->delay;
            $total_day=$total_day+($amortization->total+$amortization->delay);
        }
        $data[]=[
            '',
            '',
            '',
            'Total del día '.date('d/m/Y',strtotime($dia)),
            '',
            number_format($total_day_capital,2,'.',','),
            number_format($total_day_interes,2,'.',','),
            number_format($total_day_delay,2,'.',','),
            number_format($total_day,2,'.',',')
        ];
        $data[]=[
            ''
        ];
        $data[]=[
            '',
            '',
            '',
            'Total por periodo',
            '',
            number_format($total_capital,2,'.',','),
            number_format($total_interes,2,'.',','),
            number_format($total_delay,2,'.',','),
            number_format($total,2,'.',',')
        ];
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-proyeccion.xlsx');
    }

    public function print_reporte_recuperacion($asesor,$desde,$hasta){
        if($asesor==0)
            $comparador='>';
        else
            $comparador='=';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereHas('payment_by', function (Builder $query) use($comparador,$asesor) {
                                $query->where('id', $comparador, $asesor);
                            })
                            ->whereBetween('payment_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        $pdf = Pdf::loadView('pdf.reporte-recuperacion',compact('amortizations','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-recuperacion.pdf');
    }
    public function export_reporte_recuperacion($asesor,$desde,$hasta){
        if($asesor==0)
            $comparador='>';
        else
            $comparador='=';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereHas('payment_by', function (Builder $query) use($comparador,$asesor) {
                                $query->where('id', $comparador, $asesor);
                            })
                            ->whereBetween('payment_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'FECHA',
            'CODIGO',
            'NOMBRE DEL CLIENTE',
            'FONDO',
            'CAPITAL',
            'INTERES',
            'MORA',
            'TOTAL',
            'ASESOR'
        ];
        foreach ($amortizations as $amortization){
            $data[] = [
                date('d/m/Y',strtotime($amortization->payment_date)),
                $amortization->credit->customer->code,
                $amortization->credit->customer->lastname.', '.$amortization->credit->customer->name,
                $amortization->credit->fund->name,
                number_format($amortization->capital,2,'.',''),
                number_format($amortization->interest,2,'.',''),
                number_format($amortization->delay,2,'.',''),
                number_format($amortization->total_payment,2,'.',''),
                $amortization->payment_by->name
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-recuperacion.xlsx');
    }

    public function print_reporte_adelantados($asesor,$desde,$hasta){
        if($asesor==0)
            $comparador='>';
        else
            $comparador='=';
        $prepayments = Prepayment::where('status',1)
                            ->whereHas('payment_by', function (Builder $query) use($comparador,$asesor) {
                                $query->where('id', $comparador, $asesor);
                            })
                            ->whereBetween('date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        
        $pdf = Pdf::loadView('pdf.reporte-adelantados',compact('prepayments','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-adelantados.pdf');
    }
    public function export_reporte_adelantados($asesor,$desde,$hasta){
        if($asesor==0)
            $comparador='>';
        else
            $comparador='=';
        $prepayments = Prepayment::where('status',1)
                            ->whereHas('payment_by', function (Builder $query) use($comparador,$asesor) {
                                $query->where('id', $comparador, $asesor);
                            })
                            ->whereBetween('date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'FECHA',
            'CODIGO',
            'NOMBRE DEL CLIENTE',
            'FONDO',
            'CAPITAL',
            'INTERES',
            'MORA',
            'TOTAL',
            'ASESOR'
        ];
        foreach ($prepayments as $prepayment){
            $data[] = [
                date('d/m/Y',strtotime($prepayment->date)),
                $prepayment->amortization_schedule->credit->customer->code,
                $prepayment->amortization_schedule->credit->customer->lastname.', '.$prepayment->amortization_schedule->credit->customer->name,
                $prepayment->amortization_schedule->credit->fund->name,
                number_format($prepayment->amortization_schedule->capital,2,'.',''),
                number_format($prepayment->amortization_schedule->interest,2,'.',''),
                number_format($prepayment->amortization_schedule->delay,2,'.',''),
                number_format($prepayment->amortization_schedule->total,2,'.',''),
                $prepayment->payment_by->name
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-adelantados.xlsx');
    }

    public function print_reporte_colocacion($asesor,$desde,$hasta){
        if($asesor==0)
            $comparador='>';
        else
            $comparador='=';
        $credits = Credit::where('status','>',2)
                            ->whereHas('expended_by', function (Builder $query) use($comparador,$asesor) {
                                $query->where('id', $comparador, $asesor);
                            })
                            ->whereBetween('expended_at',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        $pdf = Pdf::loadView('pdf.reporte-colocacion',compact('credits','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-colocacion.pdf');
    }
    public function export_reporte_colocacion($asesor,$desde,$hasta){
        if($asesor==0)
            $comparador='>';
        else
            $comparador='=';
        $credits = Credit::where('status','>',2)
                            ->whereHas('expended_by', function (Builder $query) use($comparador,$asesor) {
                                $query->where('id', $comparador, $asesor);
                            })
                            ->whereBetween('expended_at',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'CODIGO DEL CREDITO',
            'NOMBRE DEL CLIENTE',
            'TIPO',
            'CAPITAL',
            'FECHA DESEMBOLSO'
        ];
        foreach ($credits as $credit){
            $data[] = [
                $credit->code,
                $credit->customer->lastname.', '.$credit->customer->name,
                'NUEVO',
                number_format($credit->initial_credit_capital,2,'.',''),
                date('d/m/Y',strtotime($credit->expended_at)),
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-colocacion.xlsx');
    }

    public function print_statement($id){
        $statements = FundStatement::where('fund_id',$id)
                                ->orderBy('id','desc')
                                ->get();
        $fund = Fund::find($id);
        $pdf = Pdf::loadView('pdf.reporte-fondo',compact('statements','fund'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-fondo.pdf');
    }
    public function export_statement($id){
        $statements = FundStatement::where('fund_id',$id)
                                ->orderBy('id','desc')
                                ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'FECHA',
            'TIPO',
            'CRÉDITO',
            'DÉBITO',
            'SALDO'
        ];
        foreach ($statements as $statement){
            switch ($statement->type) {
                case 1:
                    $type='Apertura de Fondo';
                    break;
                case 2:
                    $type='Suma de Capital de Inversor/Dueño';
                    break;
                case 3:
                    $type='Suma de Capital de Fondo';
                    break;
                case 4:
                    $type='Desembolso de Crédito';
                    break;
                case 5:
                    $type='Abono de Crédito';
                    break;
                case 6:
                    $type='Retiro de Capital de Fondo';
                    break;
                default:
                    $type='Otros'; 
            }
            $data[] = [
                date('Y-m-d H:i',strtotime($statement->date)),
                $type,
                number_format($statement->credit,2,'.',','),
                number_format($statement->debit,2,'.',','),
                number_format($statement->balance,2,'.',',')
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-fondo.xlsx');
    }

    public function print_reporte_gastos($desde,$hasta){
        if($desde==''){
            $desde=date('Y-m').'-01';
        }
        if($hasta==''){
            $hasta=date('Y-m-d').' 23:59:59';
        }
        $expenses = Expense::where('status',1)
                                ->whereBetween('date',[$desde.' 00:00:00',$hasta,' 23:59:59'])
                                ->orderBy('id','desc')
                                ->get();
        $pdf = Pdf::loadView('pdf.reporte-gastos',compact('expenses','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-gastos.pdf');
    }
    public function export_reporte_gastos($desde,$hasta){
        if($desde==''){
            $desde=date('Y-m').'-01';
        }
        if($hasta==''){
            $hasta=date('Y-m-d').' 23:59:59';
        }
        $expenses = Expense::where('status',1)
                                ->whereBetween('date',[$desde.' 00:00:00',$hasta,' 23:59:59'])
                                ->orderBy('id','desc')
                                ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'FECHA',
            'TIPO',
            'CANTIDAD',
            'FONDO ORIGEN',
            'OBSERVACION',
            'USUARIO'
        ];
        foreach ($expenses as $expense){
            $data[] = [
                date('d/m/Y',strtotime($expense->date)),
                $expense->expense_type->name,
                number_format($expense->amount,2,'.',''),
                $expense->info,
                $expense->fund->name,
                $expense->creator->name
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-gastos.xlsx');
    }

    public function print_reporte_clientes($search=''){
        $customers = Customer::where('status',1)
                                ->where(DB::raw('CONCAT(name," ",lastname,dpi,email,code)'),'like','%'.$search.'%')
                                ->orderBy('id','desc')
                                ->get();
        $pdf = Pdf::loadView('pdf.reporte-clientes',compact('customers'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-clientes.pdf');
    }
    public function export_reporte_clientes($search=''){
        $customers = Customer::where('status',1)
                                ->where(DB::raw('CONCAT(name," ",lastname,dpi,email,code)'),'like','%'.$search.'%')
                                ->orderBy('id','desc')
                                ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'CODIGO',
            'DPI',
            'NOMBRE',
            'TELEFONO',
            'EMAIL'
        ];
        foreach ($customers as $customer){
            $data[] = [
                $customer->code,
                $customer->dpi,
                $customer->lastname.', '.$customer->name,
                $customer->phone,
                $customer->email
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-clientes.xlsx');
    }

    public function print_reporte_creditos($desde='',$hasta='',$estado='',$cliente=''){
        if($estado=='' or $estado==0)
            $comparador='>';
        else
            $comparador='=';
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d').' 23:59:59';
        $credits = Credit::where(function ($query) use ($cliente) {
                                    $query->whereHas('customer', function (Builder $query) use ($cliente) {
                                        $query->where(DB::raw('CONCAT(name,dpi,email,code)'),'like','%'.$cliente.'%');
                                    });
                                })
                                ->whereBetween('expended_at',[$desde.' 00:00:00',$hasta,' 23:59:59'])
                                ->where('status',$comparador,$estado)
                                ->orderBy('id','desc')
                                ->get();
        $pdf = Pdf::loadView('pdf.reporte-creditos',compact('credits','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-creditos.pdf');
    }
    public function export_reporte_creditos($desde='',$hasta='',$estado='',$cliente=''){
        if($estado=='' or $estado==0)
            $comparador='>';
        else
            $comparador='=';
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d').' 23:59:59';
        $credits = Credit::where(function ($query) use ($cliente) {
                                    $query->whereHas('customer', function (Builder $query) use ($cliente) {
                                        $query->where(DB::raw('CONCAT(name,dpi,email,code)'),'like','%'.$cliente.'%');
                                    });
                                })
                                ->whereBetween('expended_at',[$desde.' 00:00:00',$hasta,' 23:59:59'])
                                ->where('status',$comparador,$estado)
                                ->orderBy('id','desc')
                                ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'CODIGO',
            'CLIENTE',
            'FONDO',
            'TECNOLOGÍA',
            'GARANTÍA',
            'CAPITAL INICIAL',
            'CAPITAL PENDIENTE',
            'ESTADO'
        ];
        foreach ($credits as $credit){
            switch($credit->status){
                case(1):
                    $estado='Registrado';
                    break;
                case(2):
                    $estado='Autorizado';
                    break;
                case(3):
                    $estado='Activo';
                    break;
                case(4):
                    $estado='Finalizado';
                    break;
            }
            $data[] = [
                $credit->code,
                $credit->customer->lastname.', '.$credit->customer->name,
                $credit->fund->name,
                $credit->tecnology->name,
                $credit->guarantee->name,
                number_format($credit->initial_credit_capital,2,'.',','),
                number_format($credit->pending_credit_capital,2,'.',','),
                $estado,
            ];
            $i++;
        }
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-clientes.xlsx');
    }

    public function print_reporte_creditos_clientes($search=''){
        $customers = Customer::where('status',1)
                        ->where(DB::raw('CONCAT(name," ",lastname,dpi,email,code)'),'like','%'.$search.'%')
                        ->orderBy('id','desc')
                        ->get();
        $pdf = Pdf::loadView('pdf.reporte-clientes-saldo',compact('customers'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00], 'landscape');
        return $pdf->download('reporte-clientes-saldo.pdf');
    }
    public function export_reporte_creditos_clientes($search=''){
        $customers = Customer::where('status',1)
                        ->where(DB::raw('CONCAT(name," ",lastname,dpi,email,code)'),'like','%'.$search.'%')
                        ->orderBy('id','desc')
                        ->get();
        //Creando Excel
        $i = 0;
        //print_r($amortizations);
        $data[] = [
            'NOMBRE DEL CLIENTE',
            'FECHA DE ALTA',
            'SALDO CAPITAL',
            'INTERESES'
        ];
        $total=0;
        $total_i=0;
        foreach ($customers as $customer){
            $capital=0;
            $interes=0;
            foreach($customer->credits()->get() as $credit){
                $capital=$capital+$credit->pending_credit_capital;
                $interes=$interes+($credit->initial_interest_balance - $credit->interest_paid);
            }
            $data[] = [
                $customer->code.' - '.$customer->lastname.', '.$customer->name,
                date('d/m/Y',strtotime($customer->credits()->first()->expended_at)),
                number_format($capital,2,'.',','),
                number_format($interes,2,'.',',')
            ];
            $total=$total+$capital;
            $total_i=$total_i+$interes;
            $i++;
        }
        $data[] = [
                '',
                'TOTAL',
                number_format($total,2,'.',','),
                number_format($total_i,2,'.',',')
            ];
        if ($i==0) {
            $data[] = ['Sin Registros' => ''];
        }
        //print_r($data);
        //die();
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-clientes-saldo.xlsx');
    }

    public function imprimir_cheque($credito){
        $credit = Credit::find($credito);
        return view('cheque.'.$credit->cheque->view,compact('credit'));
    }

    public function print_reporte_diario($desde='',$hasta=''){
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d').' 23:59:59';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereBetween('payment_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        $pdf = Pdf::loadView('pdf.reporte-diario',compact('amortizations','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00]);
        return $pdf->download('reporte-diario.pdf');
    }
    public function export_reporte_diario($desde='',$hasta=''){
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d').' 23:59:59';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereBetween('payment_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        $fecha_inicial = new DateTime($desde);
        $fecha_final = new DateTime($hasta);
        
        $fecha_final = $fecha_final ->modify('+1 day');

        $intervalo = DateInterval::createFromDateString('1 day');
        $periodo = new DatePeriod($fecha_inicial , $intervalo, $fecha_final);
        foreach($periodo as $dt){
            $i=1;
            $total_capital=0;
            $total_interes=0;
            $total_delay=0;
            $total=0;
            $data[] = [
                'REPORTE DE INGRESOS DIARIOS'
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                'FECHA:',
                $dt->format("d/m/Y")
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                'NO.',
                'NO. BOLETA',
                'NOMBRE',
                'CAPITAL',
                'INTERESES',
                'RECARGO',
                'TOTAL'
            ];
            foreach ($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59']) as $amortization){
                $data[] = [
                    $i,
                    $amortization->receipt_number,
                    $amortization->credit->customer->lastname.', '.$amortization->credit->customer->name,
                    number_format($amortization->capital,2,'.',','),
                    number_format($amortization->interest,2,'.',','),
                    number_format($amortization->delay,2,'.',','),
                    number_format($amortization->total_payment,2,'.',',')
                ];
                $total_capital=$total_capital+$amortization->capital;
                $total_interes=$total_interes+$amortization->interest;
                $total_delay=$total_delay+$amortization->delay;
                $total=$total+$amortization->total_payment;
                $i++;
            }
            if($i==1){
                $data[] = [
                    'No existen registros'
                ];
            }
            $data[] = [
                ''
            ];
            $data[] = [
                '',
                'CAPITAL',
                number_format($total_capital,2,'.',',')
            ];
            $data[] = [
                '',
                'INTERESES',
                number_format($total_interes,2,'.',',')
            ];
            $data[] = [
                '',
                'RECARGOS',
                number_format($total_delay,2,'.',',')
            ];
            $data[] = [
                '',
                'OTROS INGRESOS',
                '-'
            ];
            $data[] = [
                '',
                'TOTAL',
                number_format($total,2,'.',',')
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                '',
                '',
                'F._________________',
                '',
                'F._________________',
            ];
            $data[] = [
                '',
                '',
                'CAJERA',
                '',
                'JEFE DE AGENCIA',
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
            $data[] = [
                ''
            ];
        }
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-diario.xlsx');
    }

    public function print_reporte_informe_diario($desde='',$hasta=''){
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d').' 23:59:59';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereBetween('payment_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        $pdf = Pdf::loadView('pdf.reporte-diario-informe',compact('amortizations','desde','hasta'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00]);
        return $pdf->download('reporte-informe-diario.pdf');
    }
    public function export_reporte_informe_diario($desde='',$hasta=''){
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d').' 23:59:59';
        $amortizations = AmortizationSchedule::where('total_payment','>',0)
                            ->whereBetween('payment_date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                            ->orderBy('id','desc')
                            ->get();
        $data[] = [
            '',
            'REPORTE DE INGRESOS DIARIOS'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            'NO.',
            'FECHA',
            'CAPITAL',
            'INTERESES',
            'RECARGO',
            'TOTAL'
        ];
        $fecha_inicial = new DateTime($desde);
        $fecha_final = new DateTime($hasta);
        
        $fecha_final = $fecha_final ->modify('+1 day');

        $intervalo = DateInterval::createFromDateString('1 day');
        $periodo = new DatePeriod($fecha_inicial , $intervalo, $fecha_final);

        $total_capital=0;
        $total_interes=0;
        $total_delay=0;
        $total=0;
        $i=1;
        foreach($periodo as $dt){
            $capital=0;
            $interes=0;
            $delay=0;
            $total_p=0;
            if(count($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59']))){
                foreach ($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59']) as $amortization){
                    $capital=$capital+$amortization->capital;
                    $interes=$interes+$amortization->interest;
                    $delay=$delay+$amortization->delay;
                    $total_p=$total_p+$amortization->total_payment;
                }
                $data[] = [
                    '',
                    $i,
                    $dt->format("d-m-Y"),
                    number_format($capital,2,'.',','),
                    number_format($interes,2,'.',','),
                    number_format($delay,2,'.',','),
                    number_format($total_p,2,'.',',')
                ];
                $total_capital=$total_capital+$capital;
                $total_interes=$total_interes+$interes;
                $total_delay=$total_delay+$delay;
                $total=$total+$total_p;
                $i++;
            }
        }
        $data[] = [
            '',
            '',
            'TOTAL',
            number_format($total_capital,2,'.',','),
            number_format($total_interes,2,'.',','),
            number_format($total_delay,2,'.',','),
            number_format($total,2,'.',',')
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            '',
            'F._________',
            '___________',
            '',
            'F._________',
            '___________',
        ];
        $data[] = [
            '',
            '',
            'CAJERA',
            '',
            '',
            'JEFE DE AGENCIA',
        ];
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-informe-diario.xlsx');
    }

    public function print_reporte_arqueo($date=''){
        if($date=='')
            $date=date('Y-m-d');
        $arqueo=Arqueo::where('date',$date)->first();
        $cheques=PagoCheque::where('date',$date)->get();
        $pdf = Pdf::loadView('pdf.reporte-arqueo',compact('arqueo','cheques','date'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00]);
        return $pdf->download('reporte-arqueo.pdf');
    }

    public function export_reporte_arqueo($date=''){
        if($date=='')
            $date=date('Y-m-d');
        $arqueo=Arqueo::where('date',$date)->first();
        $cheques=PagoCheque::where('date',$date)->get();
        $data[] = [
            '',
            'REPORTE ARQUEO DE CAJA',
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            date('d/m/Y',strtotime($date)),
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            'BILLETES',
        ];
        $data[] = [
            '',
            '200.00',
            number_format($arqueo->b200,0,'.',','),
                    number_format(($arqueo->b200*200),2,'.',','),
                ];
        $data[] = [
            '',
            '100.00',
                    number_format($arqueo->b100,0,'.',','),
                    number_format(($arqueo->b100*100),2,'.',','),
                ];
        $data[] = [
            '',
            '50.00',
                    number_format($arqueo->b50,0,'.',','),
                    number_format(($arqueo->b50*50),2,'.',','),
                ];
        $data[] = [
            '',
            '20.00',
                    number_format($arqueo->b20,0,'.',','),
                    number_format(($arqueo->b20*20),2,'.',','),
                ];
        $data[] = [
            '',
            '10.00',
                    number_format($arqueo->b10,0,'.',','),
                    number_format(($arqueo->b10*10),2,'.',','),
                ];
        $data[] = [
            '',
            '5.00',
                    number_format($arqueo->b200,0,'.',','),
                    number_format(($arqueo->b200*200),2,'.',','),
                ];
        $data[] = [
            '',
            '1.00',
                    number_format($arqueo->b1,0,'.',','),
                    number_format(($arqueo->b1*1),2,'.',','),
                ];
        $total_billetes=($arqueo->b200*200)+($arqueo->b100*100)+($arqueo->b50*50)+($arqueo->b20*20)+($arqueo->b10*10)+($arqueo->b5*5)+$arqueo->b1;
        $data[] = [
            '',
            '',
            'TOTAL',
            number_format($total_billetes,2,'.',',')
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            'MONEDAS',
        ];
        $data[] = [
            '',
            '1.00',
                    number_format($arqueo->m1,0,'.',','),
                    number_format(($arqueo->m1*1),2,'.',','),
                ];
                $data[] = [
            '',
            '0.50',
                    number_format($arqueo->m05,0,'.',','),
                    number_format(($arqueo->m05*0.5),2,'.',','),
                ];
                $data[] = [
            '',
            '0.25',
                    number_format($arqueo->m025,0,'.',','),
                    number_format(($arqueo->m025*0.25),2,'.',','),
                ];
                $data[] = [
            '',
            '0.10',
                    number_format($arqueo->m01,0,'.',','),
                    number_format(($arqueo->m01*0.1),2,'.',','),
                ];
                $data[] = [
            '',
            '0.05',
                    number_format($arqueo->m005,0,'.',','),
                    number_format(($arqueo->m005*0.05),2,'.',','),
                ];
                $data[] = [
            '',
            '0.01',
                    number_format($arqueo->m001,0,'.',','),
                    number_format(($arqueo->m001*0.01),2,'.',','),
                ];
        $total_billetes=($arqueo->b200*200)+($arqueo->b100*100)+($arqueo->b50*50)+($arqueo->b20*20)+($arqueo->b10*10)+($arqueo->b5*5)+$arqueo->b1;
        $data[] = [
            '',
            '',
            'TOTAL',
             number_format($arqueo->total_efectivo-$total_billetes,2,'.',',')
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            'DOCUMENTOS',
        ];
        $data[] = [
            '',
            'No',
            'No Cheque',
            'Monto',
        ];
        $i=1;
        if(count($cheques)>0){
            foreach($cheques as $cheque){
                $data[] = [
                    '',
                    $i,
                    $cheque->number,
                    number_format(($cheque->amount),2,'.',','),
                ];
                $i++;
            }
        } else {
            $data[] = [
                '',
                'No existen documentos'
            ];
        }
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            'TOTAL ARQUEADO',
            number_format($arqueo->total_cheque,2,'.',',')
        ];
        $data[] = [
            '',
            'INFORME DIARIO',
            number_format($arqueo->informe_diario,2,'.',',')
        ];
        $data[] = [
            '',
            'DIFERENCIA',
            number_format($arqueo->diferencia,2,'.',',')
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            '',
            $arqueo->info
        ];
        
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'F.___________________',
            '',
            'F.___________________',
        ];
        $data[] = [
            'CAJERA',
            '',
            'JEFE DE AGENCIA',
        ];
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-arqueo.xlsx');
    }

    public function print_reporte_corte_caja($desde='',$hasta='',$fondo=''){
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d');
        if($fondo=='' || $fondo==0)
            $comparador='>';
        else
            $comparador='=';
        $fund_statement_detail=new FundStatementDetail;
        $statements=FundStatement::whereBetween('date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                                ->where('fund_id',$comparador,$fondo)
                                ->where('type',5)
                                ->orderBy(DB::raw('CAST(date As Date)'), 'asc')
                                ->orderBy('fund_id', 'asc')
                                ->get();
        $pdf = Pdf::loadView('pdf.reporte-corte-caja',compact('statements','desde','hasta','fondo','fund_statement_detail'));
        $pdf->setPaper([0.0, 0.0, 612.00, 936.00],'landscape');
        return $pdf->download('reporte-corte-caja.pdf');
    }
    public function export_reporte_corte_caja($desde='',$hasta='',$fondo=''){
        if($desde=='')
            $desde=date('Y-m').'-01';
        if($hasta=='')
            $hasta=date('Y-m-d');
        if($fondo=='' || $fondo==0)
            $comparador='>';
        else
            $comparador='=';
        $statements=FundStatement::whereBetween('date',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                                ->where('fund_id',$comparador,$fondo)
                                ->where('type',5)
                                ->orderBy(DB::raw('CAST(date As Date)'), 'asc')
                                ->orderBy('fund_id', 'asc')
                                ->get();
        $data[] = [
            '',
            'REPORTE CORTE DE CAJA',
        ];
        $data[] = [
            ''
        ];
        $i=0;
        $ii=1;
        $date='';
        $fon='';
        $total_fecha=0;
        $total_fecha_fondo=0;
        $total=0;
        foreach($statements as $statement){
            $detail=FundStatementDetail::where('fund_statement_id',$statement->id)->first();
            if($i==0){
            
                    $data[] = [
                        'FECHA: '.date('d/m/Y',strtotime($statement->date))
                    ];
                    $data[] = [
                        strtoupper($statement->fund->name)
                    ];
                    $data[] = [
                        'NO.',
                        'FECHA',
                        'DESCRIPCION',
                        'CANTIDAD',
                    ];
            }
            if($date!='' && $date!=date('Y-m-d',strtotime($statement->date))){
                    $data[] = [
                        '',
                        '',
                        'TOTAL',
                        number_format($total_fecha_fondo,2,'.',',')
                    ];
                    $total_fecha_fondo=0;
                    $data[] = [
                        '',
                        '',
                        'TOTAL '.date('d/m/Y',strtotime($date)),
                        number_format($total_fecha,2,'.',',')
                    ];
                    $total_fecha=0;
                    $new_date=1;
                    $data[] = [
                            ''
                        ];
                    $data[] = [
                        'FECHA: '.date('d/m/Y',strtotime($statement->date))
                    ];
            } else {
                $new_date=0;
            }
            if($new_date==1 || ($fon!='' && $fon!=$statement->fund->id)){
                    if($new_date==0){
                        $data[] = [
                            '',
                            '',
                            'TOTAL',
                            number_format($total_fecha_fondo,2,'.',',')
                        ];
                        $total_fecha_fondo=0;
                    }
                    $data[] = [
                        strtoupper($statement->fund->name)
                    ];
                    $data[] = [
                        'NO.',
                        'FECHA',
                        'DESCRIPCION',
                        'CANTIDAD',
                    ];
            }
                    $data[] = [
                        $ii,
                        $statement->date,
                        $detail->info,
                        number_format($statement->credit,2,'.',',')
                    ];
            $ii++;
            $total_fecha=$total_fecha+$statement->credit;
            $total_fecha_fondo=$total_fecha_fondo+$statement->credit;
            $total=$total+$statement->credit;
            $date=date('Y-m-d',strtotime($statement->date));
            $fon=$statement->fund->id;
            $i++;
        }
                    $data[] = [
                        '',
                        '',
                        'TOTAL '.date('d/m/Y',strtotime($date)),
                        number_format($total_fecha,2,'.',',')
                    ];
                    $data[] = [
                        '',
                        '',
                        'TOTAL',
                        number_format($total,2,'.',',')
                    ];
        $export = new ExcelExport($data);
        return Excel::download($export,'reporte-corte-caja.xlsx');
    }

}
