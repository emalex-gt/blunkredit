<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte Diario</title>
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
    <body>
        @php
            $fecha_inicial = new DateTime($desde);
            $fecha_final = new DateTime($hasta);
            
            $fecha_final = $fecha_final ->modify('+1 day');

            $intervalo = DateInterval::createFromDateString('1 day');
            $periodo = new DatePeriod($fecha_inicial , $intervalo, $fecha_final);
        @endphp
        @foreach($periodo as $dt)
            @php
                $i=1;
                $total_capital=0;
                $total_interes=0;
                $total_delay=0;
                $total=0;
            @endphp
            <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
            <h1>REPORTE DE INGRESOS DIARIOS</h1>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="7">FECHA: {{ $dt->format("d/m/Y") }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">NO.</th>
                        <th class="px-6 py-2 text-xs text-gray-500">NO. BOLETA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">NOMBRE</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                        <th class="px-6 py-2 text-xs text-gray-500">INTERES</th>
                        <th class="px-6 py-2 text-xs text-gray-500">RECARGO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59'])))
                        @foreach ($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59']) as $amortization)
                            <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $i }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->receipt_number }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->credit->customer->lastname }}, {{ $amortization->credit->customer->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->capital,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->interest,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->delay,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->total_payment,2,'.',',') }}</td>
                            </tr>
                            @php
                                $total_capital=$total_capital+$amortization->capital;
                                $total_interes=$total_interes+$amortization->interest;
                                $total_delay=$total_delay+$amortization->delay;
                                $total=$total+$amortization->total_payment;
                                $i++;
                            @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
                                No existen registros
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div style="margin-left:35%;margin-top:50px">
                <table style="width:50%">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500" style="border-top:1px solid #000">CAPITAL</th>
                            <th class="px-6 py-2 text-xs text-gray-500" style="border-top:1px solid #000">{{ number_format($total_capital,2,'.',',') }}</th>
                        </tr>
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500">INTERESES</th>
                            <th class="px-6 py-2 text-xs text-gray-500">{{ number_format($total_interes,2,'.',',') }}</th>
                        </tr>
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500">RECARGOS</th>
                            <th class="px-6 py-2 text-xs text-gray-500">{{ number_format($total_delay,2,'.',',') }}</th>
                        </tr>
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500">OTROS INGRESOS</th>
                            <th class="px-6 py-2 text-xs text-gray-500">-</th>
                        </tr>
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500" style="border-top:2px double #000;border-bottom:2px double #000">TOTAL</th>
                            <th class="px-6 py-2 text-xs text-gray-500" style="border-top:2px double #000;border-bottom:2px double #000">{{ number_format($total,2,'.',',') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div style="margin-left:20%;margin-top:100px">
                <table style="width:50%">
                    <tr>
                        <td>F.______________________</td>
                        <td style="width:150px"></td>
                        <td>F.______________________</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">CAJERA</td>
                        <td style="width:100px"></td>
                        <td style="text-align:center">JEFE DE AGENCIA</td>
                    </tr>
                </table>
            </div>
             <div style="page-break-after:always;"></div>
        @endforeach
    </body>
</html>
