@php
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=regla-general-".$credit->id.".doc");
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Datos de Crédito - Regla General</title>
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
                    <td style="text-align:left">Nombre del Usuario:</td>
                    <td style="text-align:left" colspan="3">{{ $credit->customer->name }} {{ $credit->customer->lastname }}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Grupo/Banco:</td>
                    <td style="text-align:left" colspan="3">{{ $credit->tecnology->name }}</td>
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
        <h1>REGLA DE PAGO ORIGINAL</h1>
        <center>
            <table style="width:75%">
                <tr>
                    <th style="border:1px solid #000">Fecha Prevista<br>de Pago</th>
                    <th style="border:1px solid #000">Días</th>
                    <th style="border:1px solid #000">Cuota<br>Capital</th>
                    <th style="border:1px solid #000">Cuota<br>Interés</th>
                    <th style="border:1px solid #000">Cuota<br>Total</th>
                    <th style="border:1px solid #000">Deuda<br>Residual</th>
                </tr>
                @php
                    $fecha_anterior=$credit->expended_at;
                    $tot_dias=0;
                    $tot_capital=0;
                    $tot_interes=0;
                    $tot_total=0;
                @endphp
                @foreach($credit->amortizacion_schedule->where('total_payment',0) as $table)
                    <tr>
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
                        <td>{{ number_format($table->capital,2,'.',',') }}</td>
                        <td>{{ number_format($table->interest,2,'.',',') }}</td>
                        <td>{{ number_format($table->total,2,'.',',') }}</td>
                        <td>{{ number_format($table->capital_balance,2,'.',',') }}</td>
                        @php
                            $tot_dias=$tot_dias+$diff->days;
                            $tot_capital=$tot_capital+$table->capital;
                            $tot_interes=$tot_interes+$table->interest;
                            $tot_total=$tot_total+$table->total;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <th style="text-align:right">TOTALES</th>
                    <th style="border:1px solid #000">{{ $tot_dias }}</th>
                    <th style="border:1px solid #000;text-align:right">{{ number_format($tot_capital,2,'.',',') }}</th>
                    <th style="border:1px solid #000;text-align:right">{{ number_format($tot_interes,2,'.',',') }}</th>
                    <th style="border:1px solid #000;text-align:right">{{ number_format($tot_total,2,'.',',') }}</th>
                    <th style="border:0"></th>
                </tr>
            </table>
            <br><br><br><br><br>
            <table style="width:50%">
                <tr>
                    <td style="width:40%;border-bottom:1px solid #000;text-align:left">(f)</td>
                    <td style="width:20%;"></td>
                    <td style="width:40%;border-bottom:1px solid #000;text-align:left">(f)</td>
                </tr>
                <tr>
                    <td style="text-align:center">Por institución</td>
                    <td></td>
                    <td style="text-align:center">Usuario por Aceptación</td>
                </tr>
            </table>
        </center>
    </body>
</html>