<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Créditos</title>
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
            text-align:center;
        }
    </style>
    </head>
    <body>
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
        <h1>INVERIA PRESTAMOS</h1><br><br>
        <h1>REPORTE DE CREDITOS DEL {{ $desde }} AL {{ $hasta }}</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CLIENTE</th>
                        <th class="px-6 py-2 text-xs text-gray-500">FONDO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TECNOLOGÍA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">GARANTÍA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CAPITAL INICIAL</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CAPITAL PENDIENTE</th>
                        <th class="px-6 py-2 text-xs text-gray-500">ESTADO</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($credits))
                        @php
                            $total=0;
                            $total_=0;
                        @endphp
                        @foreach ($credits as $credit)
                            <tr class="border-gray-200 border-b-2">
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->code }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->customer->name }}, {{ $credit->customer->lastname }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->fund->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->tecnology->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->guarantee->name }}</td>
                                <td style="text-align:right">Q.{{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                                <td style="text-align:right">Q.{{ number_format($credit->pending_credit_capital,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">
                                    @switch($credit->status)
                                        @case(1)
                                            <span style="color:yellow;">Registrado</span>
                                            @break
                                        @case(2)
                                            <span style="color:orange">Autorizado</span>
                                            @break
                                        @case(3)
                                            <span style="color:green">Activo</span>
                                            @break
                                        @case(4)
                                            <span style="color:red">Finalizado</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            @php
                                $total=$total+$credit->initial_credit_capital;
                                $total_=$total_+$credit->pending_credit_capital;
                            @endphp
                        @endforeach
                            <tr class="border-gray-200 border-b-2">
                                <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="4"></th>
                                <th style="text-align:right">TOTAL</th>
                                <th style="text-align:right">Q.{{ number_format($total,2,'.',',') }}</th>
                                <th style="text-align:right">Q.{{ number_format($total_,2,'.',',') }}</th>
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
