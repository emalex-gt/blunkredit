<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Clientes Saldo</title>
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
        <h1>REPORTE DE SALDOS DE CLIENTES</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">NOMBRE DEL CLIENTE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA DE ALTA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">SALDO CAPITAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">INTERESES</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($customers))
                        @php
                            $total=0;
                            $total_i=0;
                        @endphp
                        @foreach ($customers as $customer)
                            <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $customer->id }}">
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->code }} - {{ $customer->lastname }}, {{ $customer->name }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($customer->credits()->first()->expended_at)) }}</td>
                                @php
                                    $capital=0;
                                    $interes=0;
                                @endphp
                                @foreach($customer->credits()->get() as $credit)
                                    @php
                                        $capital=$capital+$credit->pending_credit_capital;
                                        $interes=$interes+($credit->initial_interest_balance - $credit->interest_paid);
                                    @endphp
                                @endforeach
                                <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($capital,2,'.',',') }}</td>
                                <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($interes,2,'.',',') }}</td>
                            </tr>
                            @php
                                $total=$total+$capital;
                                $total_i=$total_i+$interes;
                            @endphp
                        @endforeach
                            <tr class="border-gray-200 border-b-2">
                                <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="2">TOTAL</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($total,2,'.',',') }}</th>
                                <th class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($total_i,2,'.',',') }}</th>
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
