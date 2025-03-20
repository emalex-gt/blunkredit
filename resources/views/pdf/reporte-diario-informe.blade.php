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
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
        <h1>REPORTE DE INGRESOS DIARIOS</h1>
        @php
            $fecha_inicial = new DateTime($desde);
            $fecha_final = new DateTime($hasta);
            
            $fecha_final = $fecha_final ->modify('+1 day');

            $intervalo = DateInterval::createFromDateString('1 day');
            $periodo = new DatePeriod($fecha_inicial , $intervalo, $fecha_final);
        @endphp
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">NO.</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">INTERES</th>
                    <th class="px-6 py-2 text-xs text-gray-500">RECARGO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TOTAL</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @php
                    $total_capital=0;
                    $total_interes=0;
                    $total_delay=0;
                    $total=0;
                    $i=1;
                @endphp
                @foreach($periodo as $dt)
                    @php
                        $capital=0;
                        $interes=0;
                        $delay=0;
                        $total_p=0;
                    @endphp
                    @if(count($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59'])))
                        @foreach ($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59']) as $amortization)
                            @php
                                $capital=$capital+$amortization->capital;
                                $interes=$interes+$amortization->interest;
                                $delay=$delay+$amortization->delay;
                                $total_p=$total_p+$amortization->total_payment;
                            @endphp
                        @endforeach
                    @endif
                    <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $i }}">
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $i }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $dt->format("d-m-Y") }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($capital,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($interes,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($delay,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_p,2,'.',',') }}</td>
                    </tr>
                    @php
                        $total_capital=$total_capital+$capital;
                        $total_interes=$total_interes+$interes;
                        $total_delay=$total_delay+$delay;
                        $total=$total+$total_p;
                        $i++;
                    @endphp
                @endforeach
                <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                    <td class="px-6 py-4 text-md text-gray-500 text-center"></td>
                    <td class="px-6 py-4 text-md text-gray-500 text-center">TOTAL</td>
                    <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</td>
                    <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</td>
                    <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_delay,2,'.',',') }}</td>
                    <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total,2,'.',',') }}</td>
                </tr>
            </tbody>
        </table>
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
    </body>
</html>
