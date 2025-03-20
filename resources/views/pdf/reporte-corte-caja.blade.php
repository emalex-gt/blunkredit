<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte Corte de Caja</title>
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
        <h1>REPORTE DE CORTE DE CAJA</h1>
        @php
            $i=0;
            $ii=1;
            $date='';
            $fon='';
            $total_fecha=0;
            $total_fecha_fondo=0;
            $total=0;
        @endphp
        @foreach($statements as $statement)
            @php
                $detail=$fund_statement_detail->where('fund_statement_id',$statement->id)->first();
            @endphp
            @if($i==0)
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">FECHA: {{ date('d/m/Y',strtotime($statement->date)) }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">{{ strtoupper($statement->fund->name) }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500">NO.</th>
                        <th class="px-6 py-1 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-1 text-xs text-gray-500">DESCRIPCION</th>
                        <th class="px-6 py-1 text-xs text-gray-500">CANTIDAD</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            @endif
            @if($date!='' && $date!=date('Y-m-d',strtotime($statement->date)))
                </tbody>
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500" style="text-align:right">TOTAL</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha_fondo,2,'.',',') }}</th>
                    </tr>
                    @php
                        $total_fecha_fondo=0;
                    @endphp
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500" style="text-align:right">TOTAL {{ date('d/m/Y',strtotime($date)) }}</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha,2,'.',',') }}</th>
                    </tr>
                    @php
                        $total_fecha=0;
                        $new_date=1;
                    @endphp
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4"></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">FECHA: {{ date('d/m/Y',strtotime($statement->date)) }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            @else
                @php
                    $new_date=0;
                @endphp
            @endif
            @if($new_date==1 || ($fon!='' && $fon!=$statement->fund->id))
                </tbody>
                <thead class="bg-gray-200">
                    @if($new_date==0)
                        <tr>
                            <th class="px-6 py-1 text-xs text-gray-500"></th>
                            <th class="px-6 py-1 text-xs text-gray-500"></th>
                            <th class="px-6 py-1 text-xs text-gray-500" style="text-align:right">TOTAL</th>
                            <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha_fondo,2,'.',',') }}</th>
                        </tr>
                        @php
                            $total_fecha_fondo=0;
                        @endphp
                    @endif
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">{{ strtoupper($statement->fund->name) }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500">NO.</th>
                        <th class="px-6 py-1 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-1 text-xs text-gray-500">DESCRIPCION</th>
                        <th class="px-6 py-1 text-xs text-gray-500">CANTIDAD</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            @endif
                    <tr class="border-gray-200 border-b-2" wire:key="statement-{{ $statement->id }}">
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ $ii }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ $statement->date }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ $detail->info }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ number_format($statement->credit,2,'.',',') }}</td>
                    </tr>
            @php
                $ii++;
                $total_fecha=$total_fecha+$statement->credit;
                $total_fecha_fondo=$total_fecha_fondo+$statement->credit;
                $total=$total+$statement->credit;
                $date=date('Y-m-d',strtotime($statement->date));
                $fon=$statement->fund->id;
                $i++;
            @endphp
        @endforeach
                </tbody>
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500" style="text-align:right">TOTAL {{ date('d/m/Y',strtotime($date)) }}</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha,2,'.',',') }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500" style="text-align:right">TOTAL</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total,2,'.',',') }}</th>
                    </tr>
                </thead>
            </table>
    </body>
</html>
