<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Morosos</title>
        <style>
        body{
            font-size:12px;
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
    <body onload="window.print()">
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
        <h1>INVERIA PRESTAMOS</h1><br><br>
        <h1>REPORTE DE MOROSOS</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            @php
                $total_total_monto=0;
                $total_total_saldo=0;
                $total_total_capital_atrasado=0;
                $total_total_capital=0;
                $total_total_interes=0;
                $total_total_mora=0;
                $total_total_total=0;

                $total_cartera_monto=0;
                $total_cartera_saldo=0;
            @endphp
            @foreach($users as $user)
                <div>
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 text-xs text-gray-500">Crédito<br>Dirección</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Usuario</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Fondo<br>Fecha Último Pago</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Monto<br>Cuota</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Saldo<br>Actual</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Capital<br>Atrasado</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Capital</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Interés</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Mora<br>Descuento</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Total</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Días<br>Atraso</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Fecha<br>Venc.</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Día<br>Pago</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr wire:key="user-1">
                                <td style="text-align:left" colspan="13">{{ $user->name }}</td>
                            </tr>
                            @php
                                $total_monto=0;
                                $total_saldo=0;
                                $total_capital_atrasado=0;
                                $total_capital=0;
                                $total_interes=0;
                                $total_mora=0;
                                $total_total=0;
                            @endphp
                            @foreach($user->credits as $credit)
                                @foreach($credit->amortizacion_schedule->where('days_delayed','>',0) as $amortization)
                                <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center" style="text-align:center">{{ $amortization->credit->code }} {{ $amortization->credit->customer->name }} {{ $amortization->credit->customer->lastname }}<br>{{ $amortization->credit->customer->address }} {{ $amortization->credit->customer->phone }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center" style="text-align:center">{{ $amortization->credit->created_by->name }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center" style="text-align:center">{{ $amortization->credit->fund->name }}<br>DATE</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($amortization->credit->initial_credit_capital,2,'.',',') }}<br>{{ number_format(($amortization->total),2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($amortization->credit->pending_credit_capital,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($amortization->capital,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($amortization->capital,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($amortization->interest,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($amortization->delay,2,'.',',') }}<br>0.00</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format(($amortization->total + $amortization->delay),2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ $amortization->days_delayed }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ date('d/m/Y',strtotime($amortization->share_date)) }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ date('d',strtotime($amortization->share_date)) }}</td>
                                </tr>
                                    @php
                                        $total_monto=$total_monto+$amortization->credit->initial_credit_capital;
                                        $total_saldo=$total_saldo+$amortization->credit->pending_credit_capital;
                                        $total_capital_atrasado=$total_capital_atrasado+$amortization->capital;
                                        $total_capital=$total_capital+$amortization->capital;
                                        $total_interes=$total_interes+$amortization->interest;
                                        $total_mora=$total_mora+$amortization->delay;
                                        $total_total=$total_total+($amortization->total + $amortization->delay);
                                    @endphp
                                @endforeach
                            @endforeach
                                @php
                                    $total_total_monto=$total_total_monto+$total_monto;
                                    $total_total_saldo=$total_total_saldo+$total_saldo;
                                    $total_total_capital_atrasado=$total_total_capital_atrasado+$total_capital_atrasado;
                                    $total_total_capital=$total_total_capital+$total_capital;
                                    $total_total_interes=$total_total_interes+$total_interes;
                                    $total_total_mora=$total_total_mora+$total_mora;
                                    $total_total_total=$total_total_total+$total_total;
                                @endphp
                                <tr class="border-gray-200 border-b-2">
                                    <td class="px-2 py-4 text-xs text-gray-500 text-right" colspan="3">Total por Asesor</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_monto,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_saldo,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_capital_atrasado,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_mora,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format(($total_total),2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                </tr>
                                @php
                                    $cartera_monto=0;
                                    $cartera_saldo=0;
                                @endphp
                                @foreach($user->credits as $credit)
                                    @php
                                        $cartera_monto=$cartera_monto+$credit->initial_credit_capital;
                                        $cartera_saldo=$cartera_saldo+$credit->pending_credit_capital;
                                    @endphp
                                @endforeach
                                <tr class="border-gray-200 border-b-2">
                                    <td class="px-2 py-4 text-xs text-gray-500 text-right" colspan="3">Cartera Total</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($cartera_monto,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($cartera_saldo,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br>
            <center>
                <div class="w-1/2" style="width:50%;background-color:#fff;margin:0 auto">
                    <div>
                        <table  class="w-full">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-2 py-2 text-xs text-gray-500" colspan="3">Coeficientes de la Cartera</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">Monto Entregado</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ $cartera_monto }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">100%</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">Cartera Pagada</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format(($cartera_monto - $cartera_saldo),2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format(((($cartera_monto-$cartera_saldo)/$cartera_monto)*100),2,'.',',') }}%</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">Cartera Mora</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_capital_atrasado,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format((($total_capital_atrasado/$cartera_monto)*100),2,'.',',') }}%</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">Capital en Riesgo</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_saldo,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format((($total_saldo/$cartera_monto)*100),2,'.',',') }}%</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">Saldo de la Cartera</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($cartera_saldo,2,'.',',') }}</td>
                                    <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format((($cartera_saldo/$cartera_monto)*100),2,'.',',') }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </center>
            <br><br><br>
            @endforeach
            <div>
                @foreach($users_total as $us)
                    @foreach($us->credits as $cred)
                        @php
                            $total_cartera_monto=$total_cartera_monto+$cred->initial_credit_capital;
                            $total_cartera_saldo=$total_cartera_saldo+$cred->pending_credit_capital;
                        @endphp
                    @endforeach
                @endforeach
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-2 py-2 text-xs text-gray-500"></th>
                            <th class="px-2 py-2 text-xs text-gray-500">Monto<br>Cuota</th>
                            <th class="px-2 py-2 text-xs text-gray-500">Saldo<br>Actual</th>
                            <th class="px-2 py-2 text-xs text-gray-500">Capital<br>Atrasado</th>
                            <th class="px-2 py-2 text-xs text-gray-500">Capital</th>
                            <th class="px-2 py-2 text-xs text-gray-500">Interés</th>
                            <th class="px-2 py-2 text-xs text-gray-500">Mora<br>Descuento</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-gray-200 border-b-2">
                            <td class="px-2 py-4 text-xs text-gray-500 text-right">Total General</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_monto,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_saldo,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_capital_atrasado,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_capital,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_interes,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_mora,2,'.',',') }}</td>
                        </tr>
                        <tr class="border-gray-200 border-b-2">
                            <td class="px-2 py-4 text-xs text-gray-500 text-right">Cartera Total</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_cartera_monto,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_cartera_saldo,2,'.',',') }}</td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                            <td class="px-2 py-4 text-xs text-gray-500 text-center"></td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <br><br><br>
            
            <center>
            <div  class="w-1/2" style="width:50%;background-color:#fff;margin:0 auto">
                <div>
                    <table  class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 text-xs text-gray-500" colspan="3">Coeficientes de la Cartera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">Monto Entregado</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ $total_cartera_monto }}</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">100%</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">Cartera Pagada</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format(($total_cartera_monto - $total_cartera_saldo),2,'.',',') }}</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format(((($total_cartera_monto-$total_cartera_saldo)/$total_cartera_monto)*100),2,'.',',') }}%</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">Cartera Mora</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_capital_atrasado,2,'.',',') }}</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format((($total_total_capital_atrasado/$total_cartera_monto)*100),2,'.',',') }}%</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">Capital en Riesgo</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_total_saldo,2,'.',',') }}</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format((($total_total_saldo/$total_cartera_monto)*100),2,'.',',') }}%</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">Saldo de la Cartera</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format($total_cartera_saldo,2,'.',',') }}</td>
                                <td class="px-2 py-4 text-xs text-gray-500 text-center">{{ number_format((($total_cartera_saldo/$total_cartera_monto)*100),2,'.',',') }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </center>

        </div>
    </body>
</html>
