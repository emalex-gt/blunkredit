<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Proyección de Pagos</title>
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
        <h1>REPORTE DE PROYECCION DE PAGOS</h1>
        <h4 style="text-align:center">Del {{ date('d/m/Y',strtotime($desde)) }} al {{ date('d/m/Y H:i',strtotime($hasta)) }}</h4>
        <p style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</p>
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">Crédito</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Nombre Completo</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Dirección</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Fondo</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Teléfono</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Capital</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Interés</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Mora</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @php
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
                @endphp
                @foreach ($amortizations as $amortization)
                    @if($asesor!=$amortization->created_user)
                        <tr>
                            <th colspan="9" class="px-6 py-4 text-md text-gray-500" style="text-align:left">{{ $amortization->user }}</th>
                        </tr>
                        @php
                            $asesor=$amortization->created_user;
                        @endphp
                    @endif
                    @if($dia!='' && $dia!=date('Y-m-d',strtotime($amortization->share_date)))
                        <tr class="border-gray-200 border-b-2">
                            <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="5">Total del día {{ date('d/m/Y',strtotime($dia)) }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_capital,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_interes,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_delay,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day,2,'.',',') }}</th>
                        </tr>
                        @php
                            $total_day_capital=0;
                            $total_day_interes=0;
                            $total_day_delay=0;
                            $total_day=0;
                        @endphp
                    @endif
                    <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->code }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->lastname }}, {{ $amortization->name }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->address }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->fund }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->phone }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->capital,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->interest,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->delay,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format(($amortization->total+$amortization->delay),2,'.',',') }}</td>
                    </tr>
                    @php
                        $dia=date('Y-m-d',strtotime($amortization->share_date));
                        $total_capital=$total_capital+$amortization->capital;
                        $total_interes=$total_interes+$amortization->interest;
                        $total_delay=$total_delay+$amortization->delay;
                        $total=$total+($amortization->total+$amortization->delay);

                        $total_day_capital=$total_day_capital+$amortization->capital;
                        $total_day_interes=$total_day_interes+$amortization->interest;
                        $total_day_delay=$total_day_delay+$amortization->delay;
                        $total_day=$total_day+($amortization->total+$amortization->delay);
                    @endphp
                @endforeach
                    <tr class="border-gray-200 border-b-2">
                        <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="5">Total del día {{ date('d/m/Y',strtotime($dia)) }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_capital,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_interes,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_delay,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day,2,'.',',') }}</th>
                    </tr>
                    <tr class="border-gray-200 border-b-2">
                        <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="5">Total por periodo</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_delay,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total,2,'.',',') }}</th>
                    </tr>
            </tbody>
        </table>
    </body>
</html>
