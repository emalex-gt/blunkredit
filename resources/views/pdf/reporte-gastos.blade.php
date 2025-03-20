<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Gastos</title>
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
        <h1>REPORTE DE GASTOS DEL {{ $desde }} AL {{ $hasta }}</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CANTIDAD</th>
                        <th class="px-6 py-2 text-xs text-gray-500">FONDO DE ORIGEN</th>
                        <th class="px-6 py-2 text-xs text-gray-500">OBSERVACION</th>
                        <th class="px-6 py-2 text-xs text-gray-500">USUARIO</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($expenses))
                        @php
                            $total=0;
                        @endphp
                        @foreach ($expenses as $expense)
                            <tr class="border-gray-200 border-b-2">
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($expense->date)) }}</td>
                                <td>{{ $expense->expense_type->name }}</td>
                                <td style="text-align:right">Q.{{ number_format($expense->amount,2,'.','') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $expense->info }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $expense->fund->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $expense->creator->name }}</td>
                            </tr>
                            @php
                                $total=$total+$expense->amount;
                            @endphp
                        @endforeach
                            <tr class="border-gray-200 border-b-2">
                                <th class="px-6 py-4 text-md text-gray-500 text-right"></th>
                                <th style="text-align:right">TOTAL</th>
                                <th style="text-align:right">Q.{{ number_format($total,2,'.',',') }}</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center" colspan="3"></th>
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
