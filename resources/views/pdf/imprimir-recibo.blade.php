<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Recibo de Pago No. {{ $amortization->id }}-{{ $amortization->receipt_number }}</title>
        <style>
        body{
            margin:0;
            font-size:14px;
        }
        .body{
            width:14.9cm;
            height:8.1cm;
            padding-left:6cm;
            padding-top:2cm;
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
        <div class="body">
            RECIBO DE PAGO<br>
            NO.  {{ $amortization->id }}-{{ $amortization->receipt_number }}<br><br>
            <table>
                <tbody>
                    <tr>
                        <td>Fecha</td>
                        <td>{{ date('d/m/Y H:i',strtotime($amortization->payment_date)) }}</td>
                    </tr>
                    <tr>
                        <td>Crédito</td>
                        <td>{{ $amortization->credit->code }}</td>
                    </tr>
                    <tr>
                        <td>Beneficiario</td>
                        <td>{{ $amortization->credit->customer->lastname }}, {{ $amortization->credit->customer->name }}</td>
                    </tr>
                    <tr>
                        <td>Asesor Cobró:</td>
                        <td>{{ $amortization->payment_by->name }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-bottom:5px"></td>
                    </tr>
                    <tr>
                        <td>Capital Inicial</td>
                        <td>Q.{{ number_format($amortization->credit->initial_credit_capital,2,'.',',') }}</td>
                    </tr>
                    <tr>
                        <td>Plazo</td>
                        <td>{{ $amortization->credit->time_limit->name }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:5px;padding-bottom:5px"></td>
                    </tr>
                    <tr>
                        <td>Capital:</td>
                        <td>Q.{{ number_format($amortization->capital,2,'.',',') }}</td>
                    </tr>
                    <tr>
                        <td>Interés:</td>
                        <td>Q.{{ number_format($amortization->interest,2,'.',',') }}</td>
                    </tr>
                    <tr>
                        <td>Mora:</td>
                        <td >Q.{{ number_format($amortization->delay,2,'.',',') }}</td>
                    </tr>
                    <tr>
                        <td>TOTAL:</td>
                        <td>Q.{{ number_format($amortization->total_payment,2,'.',',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:5px;padding-bottom:5px"></td>
                    </tr>
                    <tr>
                        <td>Saldo Capital</td>
                        <td>Q.{{ number_format($amortization->credit->pending_credit_capital,2,'.',',') }}</td>
                    </tr>
                </tbody>
            </table>
            </center>
        </div>
    </body>
</html>
