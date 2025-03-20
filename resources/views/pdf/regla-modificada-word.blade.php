@php
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=regla-modificada-".$credit->id.".doc");
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Datos de Crédito - Regla Modificada</title>
        <style>
        body{
            font-size:12px;
            width:95%;
            overflow:hidden;
        }
        h1{
            text-align: center;
            text-transform: uppercase;
            font-size:16px;
        }
        .borde{
            border:1px solid #000;
            padding:20px;
        }
        table{
            width:100%;
            border-spacing: 5px;
            border-collapse: collapse;
        }
        th{
            text-align:center;
            border-bottom:1px solid #000;
        }
        td{
            text-align:right;
        }
    </style>
    </head>
    <body>
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="100px"/></center>
        <h4>Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div class="borde">
            <h1>DATOS GENERAL DEL CRÉDITO</h1>
            <table>
                <tr>
                    <td style="text-align:left">Tecnología:</td>
                    <td style="text-align:left" colspan="3">{{ $credit->tecnology->name }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Nombre del Usuario:</td>
                    <td style="text-align:left" colspan="3">{{ $credit->customer->name }} {{ $credit->customer->lastname }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Dirección:</td>
                    <td style="text-align:left" colspan="3">{{ $credit->customer->address }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Nombre Fondo:</td>
                    <td style="text-align:left">{{ $credit->fund->name }}</td>
                    <td style="text-align:left">NIT:</td>
                    <td style="text-align:left"></td>
                </tr>
                <tr>
                    <td style="text-align:left">Código de Usuario:</td>
                    <td style="text-align:left">{{ $credit->customer->code }}</td>
                    <td style="text-align:left">Número de Crédito:</td>
                    <td style="text-align:left">{{ $credit->code }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Fecha de Entrega:</td>
                    <td style="text-align:left">{{ date('d/m/Y',strtotime($credit->expended_at)) }}</td>
                    <td style="text-align:left">Fecha de Vencim.:</td>
                    <td style="text-align:left">{{ date('d/m/Y',strtotime($credit->amortizacion_schedule->sortDesc()->first()->share_date)) }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Plazo en Meses:</td>
                    <td style="text-align:left">{{ $credit->time_limit->name }}</td>
                    <td style="text-align:left">Capital:</td>
                    <td style="text-align:left">{{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Tasa de Interés:</td>
                    <td style="text-align:left">{{ $credit->interest->name }}%</td>
                    <td style="text-align:left">Política:</td>
                    <td style="text-align:left">{{ $credit->policy->name }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Cédula/DPI:</td>
                    <td style="text-align:left">{{ $credit->customer->dpi }}</td>
                    <td style="text-align:left">Usuario Operó</td>
                    <td style="text-align:left">{{ $credit->created_by->id }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Asesor:</td>
                    <td style="text-align:left">{{ $credit->created_by->name }}</td>
                    <td style="text-align:left"></td>
                    <td style="text-align:left"></td>
                </tr>
                <tr>
                    <td style="text-align:left">Garantía:</td>
                    <td style="text-align:left">{{ $credit->guarantee->name }}</td>
                    <td style="text-align:left">Primer Pago:</td>
                    <td style="text-align:left">{{ date('d/m/Y',strtotime($credit->amortizacion_schedule->sort()->first()->share_date)) }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Línea de Crédito:</td>
                    <td style="text-align:left">{{ $credit->credit_line->name }}</td>
                    <td style="text-align:left">Cuota:</td>
                    <td style="text-align:left">{{ number_format($credit->amortizacion_schedule->sort()->first()->capital,2,'.',',') }}</td>
                </tr>
            </table>
        </div>
        <h1>REGLA DE PAGO MODIFICADA</h1>
        <h4>PAGOS REALIZADOS</h4>
        <table style="width:100%">
            <tr>
                <th></th>
                <th style="text-align:center">Fecha<br>de Pago</th>
                <th style="text-align:center">Fecha<br>de Cálculo</th>
                <th style="text-align:center">Tipo<br>Trn.</th>
                <th style="text-align:center">No.<br>Trn</th>
                <th style="text-align:center">Días</th>
                <th style="text-align:center">Cuota<br>Capital</th>
                <th style="text-align:center">Cuota<br>Interés</th>
                <th style="text-align:center">Cuota<br>Mora</th>
                <th style="text-align:center">Cuota<br>Total</th>
                <th style="text-align:center">Saldo<br>Capital</th>
                <th style="text-align:center">Saldo<br>Interés</th>
                <th style="text-align:center">Saldo<br>Total</th>
                <th style="text-align:center">CP</th>
                <th style="text-align:center">Usuario</th>
            </tr>
            @php
                $fecha_anterior=$credit->expended_at;
                $tot_dias=0;
                $tot_capital=0;
                $tot_interes=0;
                $tot_mora=0;
                $tot_total=0;             
            @endphp
            @foreach($credit->amortizacion_schedule->where('total_payment','>',0) as $table)
                <tr>
                    <td>{{ $table->number }}</td>
                    <td style="text-align:center">{{ date('d/m/Y',strtotime($table->payment_date)) }}</td>
                    <td style="text-align:center">{{ date('d/m/Y',strtotime($table->share_date)) }}</td>
                    <td style="text-align:center">REI</td>
                    <td style="text-align:center">{{ $table->id }}</td>
                    <td style="text-align:center">
                        @php
                            $date1 = new DateTime(date('Y-m-d',strtotime($fecha_anterior)));
                            $date2 = new DateTime(date('Y-m-d',strtotime($table->share_date)));
                            $diff = $date1->diff($date2);
                            $fecha_anterior=$table->share_date;
                        @endphp
                        {{ $diff->days }}
                    </td>
                    <td style="text-align:center">{{ number_format($table->capital,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->interest,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->delay,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->total_payment,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->capital_balance,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->interest_balance,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->total_balance,2,'.',',') }}</td>
                    <td style="text-align:center">{{ $table->payment_by->id }}</td>
                    <td style="text-align:center">{{ $table->payment_by->name }}</td>
                    @php
                        $tot_dias=$tot_dias+$diff->days;
                        $tot_capital=$tot_capital+$table->capital;
                        $tot_interes=$tot_interes+$table->interest;
                        $tot_mora=$tot_mora+$table->delay;
                        $tot_total=$tot_total+$table->total;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align:right">Total Pagado</td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_dias }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_capital }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_interes }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_mora }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_total }}</td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000"></td>
            </tr>
        </table>
        <h4>SALDO A LA FECHA</h4>
        <h4>DIAS DE ATRASO EN EL PAGO: {{ $credit->days_delayed }}</h4>
        <center>
            <table style="width:100%">
                <tr>
                    <th style="border-top:1px solid #000;border-left:1px solid #000;border-bottom:0">Fecha Cálculo</th>
                    <th style="border-top:1px solid #000;border-left:1px solid #000;border-bottom:0">Capital</th>
                    <th style="border-top:1px solid #000;border-left:1px solid #000;border-bottom:0">Interés</th>
                    <th style="border-top:1px solid #000;border-left:1px solid #000;border-bottom:0">Mora</th>
                    <th style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;border-bottom:0">Total a Pagar</th>
                </tr>
                <tr>
                    <td style="border-left:1px solid #000;text-align:center">{{ date('d/m/Y') }}</td>
                    <td style="border-left:1px solid #000;text-align:center">{{ number_format($credit->amortizacion_schedule->where('total_payment',0)->first()->capital,2,'.',',') }}</td>
                    <td style="border-left:1px solid #000;text-align:center">{{ number_format($credit->amortizacion_schedule->where('total_payment',0)->first()->interest,2,'.',',') }}</td>
                    <td style="border-left:1px solid #000;text-align:center">{{ number_format($credit->amortizacion_schedule->where('total_payment',0)->first()->delay,2,'.',',') }}</td>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:center">{{ number_format($credit->amortizacion_schedule->where('total_payment',0)->first()->total,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:center">Cancelación Anticipada</td>
                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:center">{{ number_format($credit->amortizacion_schedule->where('total_payment',0)->first()->capital,2,'.',',') }}</td>
                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:center">{{ number_format($credit->amortizacion_schedule->where('total_payment',0)->first()->interest,2,'.',',') }}</td>
                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;text-align:center">0.00</td>
                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;text-align:center">
                        @php
                            $tota=$credit->amortizacion_schedule->where('total_payment',0)->first()->total;
                            $delay=$credit->amortizacion_schedule->where('total_payment',0)->first()->delay;
                            $tot=$tota-$delay;
                        @endphp
                        {{ number_format(($tot),2,'.',',') }}
                    </td>
                </tr>
            </table>
        </center>
        <h4>PAGOS PENDIENTES</h4>
        <table style="width:100%">
            <tr>
                <th></th>
                <th style="text-align:center">Fecha Prevista<br>de Pago</th>
                <th style="text-align:center">Días</th>
                <th style="text-align:center">Cuota<br>Capital</th>
                <th style="text-align:center">Cuota<br>Interés</th>
                <th style="text-align:center">Cuota<br>Mora</th>
                <th style="text-align:center">Cuota<br>Total</th>
                <th style="text-align:center">Saldo<br>Capital</th>
                <th style="text-align:center">Saldo<br>Interés</th>
                <th style="text-align:center">Saldo<br>Total</th>
            </tr>
            @php
                $tot_dias_p=0;
                $tot_capital_p=0;
                $tot_interes_p=0;
                $tot_mora_p=0;
                $tot_total_p=0;             
            @endphp
            @foreach($credit->amortizacion_schedule->where('total_payment',0) as $table)
                <tr>
                    <td style="text-align:center">{{ $table->number }}</td>
                    <td style="text-align:center">{{ date('d/m/Y',strtotime($table->share_date)) }}</td>
                    <td style="text-align:center">
                        @php
                            $date1 = new DateTime(date('Y-m-d',strtotime($fecha_anterior)));
                            $date2 = new DateTime(date('Y-m-d',strtotime($table->share_date)));
                            $diff = $date1->diff($date2);
                            $fecha_anterior=$table->share_date;
                        @endphp
                        {{ $diff->days }}
                    </td>
                    <td style="text-align:center">{{ number_format($table->capital,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->interest,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->delay,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->total,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->capital_balance,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->interest_balance,2,'.',',') }}</td>
                    <td style="text-align:center">{{ number_format($table->total_balance,2,'.',',') }}</td>
                    @php
                        $tot_dias=$tot_dias+$diff->days;
                        $tot_capital=$tot_capital+$table->capital;
                        $tot_interes=$tot_interes+$table->interest;
                        $tot_mora=$tot_mora+$table->delay;
                        $tot_total=$tot_total+$table->total;
                        $tot_dias_p=$tot_dias_p+$diff->days;
                        $tot_capital_p=$tot_capital_p+$table->capital;
                        $tot_interes_p=$tot_interes_p+$table->interest;
                        $tot_mora_p=$tot_mora_p+$table->delay;
                        $tot_total_p=$tot_total_p+$table->total;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="text-align:right">Total Pagado</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_dias_p }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_capital_p }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_interes_p }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_mora_p }}</td>
                <td style="border-top:1px solid #000;text-align:center">{{ $tot_total_p }}</td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000"></td>
                <td style="border-top:1px solid #000"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right">TOTAL GENERAL</td>
                <td style="text-align:center">{{ $tot_dias }}</td>
                <td style="text-align:center">{{ $tot_capital }}</td>
                <td style="text-align:center">{{ $tot_interes }}</td>
                <td style="text-align:center">{{ $tot_mora }}</td>
                <td style="text-align:center">{{ $tot_total }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </body>
</html>