<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de {{ $fund->name }}</title>
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
        <h1>Reporte de {{ $fund->name }}</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CRÉDITO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">DÉBITO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">SALDO</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($statements))
                    @foreach ($statements as $statement)
                        <tr class="border-gray-200 border-b-2">
                            <td style="text-align:center">{{ date('Y-m-d H:i',strtotime($statement->date)) }}</td>
                            <td style="text-align:left">
                                @switch($statement->type)
                                    @case(1)
                                        Apertura de Fondo
                                        @break
                                    @case(2)
                                        Suma de Capital de Inversor/Dueño
                                        @break
                                    @case(3)
                                        Suma de Capital de Fondo
                                        @break
                                    @case(4)
                                        Desembolso de Crédito
                                        @break
                                    @case(5)
                                        Abono de Crédito
                                        @break
                                    @case(6)
                                        Retiro de Capital de Fondo
                                        @break
                                    @default
                                        Otros
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">{{ number_format($statement->credit,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">{{ number_format($statement->debit,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">{{ number_format($statement->balance,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">
                                @livewire('fund-statement-info-component',['statement'=>$statement],key($statement->id))
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
                            No existen registros
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
    </body>
</html>
