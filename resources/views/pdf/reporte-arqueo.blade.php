<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte Arqueo {{ date('d/m/Y',strtotime($date)) }}</title>
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
            width:50%;
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
        <h1>REPORTE ARQUEO DE CAJA</h1>
        <div style="margin-left:32%;margin-top:20px">
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">FECHA: {{ date("d/m/Y",strtotime($date)) }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">BILLETES</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">200.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b200,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b200*200),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">100.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b100,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b100*100),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">50.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b50,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b50*50),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">20.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b20,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b20*20),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">10.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b10,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b10*10),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">5.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b200,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b200*200),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">1.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b1,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b1*1),2,'.',',') }}</td>
                </tr>
            </tbody>
            <thead class="bg-gray-200">
                @php
                    $total_billetes=($arqueo->b200*200)+($arqueo->b100*100)+($arqueo->b50*50)+($arqueo->b20*20)+($arqueo->b10*10)+($arqueo->b5*5)+$arqueo->b1;
                @endphp
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-right" colspan="2">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($total_billetes,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </div>
        
        <div style="margin-left:32%;margin-top:20px">
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">MONEDAS</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">1.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m1,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m1*1),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.50</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m05,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m05*0.5),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.25</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m025,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m025*0.25),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.10</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m01,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m01*0.1),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.05</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m005,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m005*0.05),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.01</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m001,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m001*0.01),2,'.',',') }}</td>
                </tr>
            </tbody>
            <thead class="bg-gray-200">
                @php
                    $total_billetes=($arqueo->b200*200)+($arqueo->b100*100)+($arqueo->b50*50)+($arqueo->b20*20)+($arqueo->b10*10)+($arqueo->b5*5)+$arqueo->b1;
                @endphp
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-right" colspan="2">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->total_efectivo-$total_billetes,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </div>
        
        <div style="margin-left:32%;margin-top:20px">
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">DOCUMENTOS</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">No</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">No Cheque</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">Monto</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @php
                    $i=1;
                @endphp
                @if(count($cheques)>0)
                    @foreach($cheques as $cheque)
                        <tr>
                            <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ $i }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ $cheque->number }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($cheque->amount),2,'.',',') }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @else
                    <tr>
                        <td class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">No existen documentos</td>
                    </tr>
                @endif
            </tbody>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-right" colspan="2">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->total_cheque,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </div>
        
        <div style="margin-left:32%;margin-top:20px">
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">TOTAL ARQUEADO</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->total_arqueado,2,'.',',') }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">INFORME DIARIO</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->informe_diario,2,'.',',') }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">DIFERENCIA</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->diferencia,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </div>

        <div style="margin-left:32%;margin-top:20px">
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ $arqueo->info }}</th>
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
    </body>
</html>
