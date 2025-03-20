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
        <h1>REPORTE DE COLOCACION DEL {{ $desde }} AL {{ $hasta }}</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">CODIGO DEL CRÉDITO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">NOMBRE DEL CLIENTE</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                        <th class="px-6 py-2 text-xs text-gray-500">FECHA DESEMBOLSO</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($credits))
                        @php
                            $total=0;
                        @endphp
                        @foreach ($credits as $credit)
                            <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $credit->id }}">
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->code }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->customer->code }} - {{ $credit->customer->lastname }}, {{ $credit->customer->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">NUEVO</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($credit->expended_at)) }}</td>
                            </tr>
                            @php
                                $total=$total+$credit->initial_credit_capital;
                            @endphp
                        @endforeach
                            <tr class="border-gray-200 border-b-2">
                                <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="2"></th>
                                <th class="px-6 py-4 text-md text-gray-500 text-right">TOTAL</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($total,2,'.',',') }}</th>
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
