<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Recibo de Pago Parcial No. {{ $partialpayment->id }}</title>
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
            max-width:350px;
            border-spacing: 5px;
            border-collapse: collapse;
        }
        th{
            text-align:left;
        }
        td{
            text-align:left;
        }
    </style>
    </head>
    <body onload="window.print()">
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
        <h1>INVERIA PRESTAMOS</h1>
        <h1>RECIBO DE PAGO PARCIAL NO.  {{ $partialpayment->id }}</h1>
        <center>
        <table>
            <tbody>
                <tr>
                    <th style="border-bottom:1px solid #000" colspan="2">Datos Generales</th>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ date('d/m/Y H:i',strtotime($partialpayment->date)) }}</td>
                </tr>
                <tr>
                    <th>Crédito</th>
                    <td>{{ $partialpayment->credit->code }}</td>
                </tr>
                <tr>
                    <th>Beneficiario</th>
                    <td>{{ $partialpayment->credit->customer->lastname }}, {{ $partialpayment->credit->customer->name }}</td>
                </tr>
                <tr>
                    <th>Asesor Cobró:</th>
                    <td>{{ $partialpayment->created_by->name }}</td>
                </tr>
                <tr>
                    <th colspan="2" style="padding-top:5px;padding-bottom:5px"></th>
                </tr>
                <tr>
                    <th style="border-bottom:1px solid #000" colspan="2">Datos del Crédito</th>
                </tr>
                <tr>
                    <th>Línea de Crédito</th>
                    <td>{{ $partialpayment->credit->credit_line->name }}</td>
                </tr>
                <tr>
                    <th>Capital Inicial</th>
                    <td>Q.{{ number_format($partialpayment->credit->initial_credit_capital,2,'.',',') }}</td>
                </tr>
                <tr>
                    <th>Plazo</th>
                    <td>{{ $partialpayment->credit->time_limit->name }}</td>
                </tr>
                <tr>
                    <th>Fecha Inicio:</th>
                    <td>{{ date('d/m/Y',strtotime($partialpayment->credit->expended_at)) }}</td>
                </tr>
                <tr>
                    <th>Fecha Fin:</th>
                    <td>{{ date('d/m/Y',strtotime($partialpayment->credit->amortizacion_schedule->sortDesc()->first()->share_date)) }}</td>
                </tr>
                <tr>
                    <th colspan="2" style="padding-top:5px;padding-bottom:5px"></th>
                </tr>
                <tr>
                    <th style="border-bottom:1px solid #000" colspan="2">Datos del Pago</th>
                </tr>
                <tr>
                    <th style="border-bottom:1px solid #000"><h1 style="text-align:left">Fecha:</h1></th>
                    <td style="border-bottom:1px solid #000"><h1 style="text-align:left">{{ date('d/m/Y H:i',strtotime($partialpayment->date)) }}</h1></td>
                </tr>
                <tr>
                    <th style="border-bottom:1px solid #000"><h1 style="text-align:left">Total:</h1></th>
                    <td style="border-bottom:1px solid #000"><h1 style="text-align:left">Q.{{ number_format($partialpayment->amount,2,'.',',') }}</h1></td>
                </tr>
            </tbody>
        </table>
        </center>
    </body>
</html>
