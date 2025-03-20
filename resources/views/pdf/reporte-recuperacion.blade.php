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
    <body>
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
        <h1>INVERIA PRESTAMOS</h1><br><br>
        <h1>REPORTE DE RECUPERACION DEL {{ $desde }} AL {{ $hasta }}</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">NOMBRE DEL CLIENTE</th>
                        <th class="px-6 py-2 text-xs text-gray-500">FONDO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                        <th class="px-6 py-2 text-xs text-gray-500">INTERES</th>
                        <th class="px-6 py-2 text-xs text-gray-500">MORA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TOTAL</th>
                        <th class="px-6 py-2 text-xs text-gray-500">ASESOR</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($amortizations))
                        @php
                            $total_capital=0;
                            $total_interes=0;
                            $total_delay=0;
                            $total=0;
                        @endphp
                        @foreach ($amortizations as $amortization)
                            <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($amortization->payment_date)) }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->credit->customer->code }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->credit->customer->lastname }}, {{ $amortization->credit->customer->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->credit->fund->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->capital,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->interest,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->delay,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->total_payment,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->payment_by->name }}</td>
                            </tr>
                            @php
                                $total_capital=$total_capital+$amortization->capital;
                                $total_interes=$total_interes+$amortization->interest;
                                $total_delay=$total_delay+$amortization->delay;
                                $total=$total+$amortization->total_payment;
                            @endphp
                        @endforeach
                            <tr class="border-gray-200 border-b-2">
                                <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="3"></th>
                                <th class="px-6 py-4 text-md text-gray-500 text-right">TOTAL</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_delay,2,'.',',') }}</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total,2,'.',',') }}</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center"></th>
                            </tr>
                    @else
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
                                No existen registros
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>
