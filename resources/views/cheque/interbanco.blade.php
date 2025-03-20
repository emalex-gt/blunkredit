<html>
    <head>
        <title>Cheque de Crédito No. {{ $credit->id }}</title>
        <style>
            body{
                margin:0;
                font-size:14px;
            }
            .body{
                width:21.6cm;
                height:27.9cm;
            }
        </style>
    </head>
    <body onload="window.print()">  
        <div class="body">
            <?php
                switch (date('n')) {
                    case 1:
                        $month='Enero';
                        break;
                    case 2:
                        $month='Febrero';
                        break;
                    case 3:
                        $month='Marzo';
                        break;
                    case 4:
                        $month='Abril';
                        break;
                    case 5:
                        $month='Mayo';
                        break;
                    case 6:
                        $month='Junio';
                        break;
                    case 7:
                        $month='Julio';
                        break;
                    case 8:
                        $month='Agosto';
                        break;
                    case 9:
                        $month='Septiembre';
                        break;
                    case 10:
                        $month='Octubre';
                        break;
                    case 11:
                        $month='Noviembre';
                        break;
                    case 12:
                        $month='Diciembre';
                        break;
                }
            ?>
            <div style="position:absolute;top:2.1cm;left:3.8cm">Chichicastenango, {{ date('d') }} de {{ $month }} del {{ date('Y') }}</div>
            <div style="position:absolute;top:2.1cm;left:17.3cm">{{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
            <div style="position:absolute;top:2.9cm;left:4.1cm">{{ $credit->customer->name }} {{ $credit->customer->lastname }}</div>
            <?php
                $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                $porcion = explode('.', $credit->initial_credit_capital);
                if ($porcion[1]>0){
                    $decimal='con '.$formatterES->format($porcion[1]).' centavos';
                } else {
                    $decimal='exactos';
                }
            ?>
            <div style="position:absolute;top:3.35cm;left:3.3cm">{{ ucfirst($formatterES->format($porcion[0])) }} {{ $decimal }}</div>
            <div style="position:absolute;top:4.6cm;left:2cm">NO NEGOCIABLE</div>
            <div style="position:absolute;top:7.6cm;left:1.6cm">8101-52535-1</div>
            <div style="position:absolute;top:7.6cm;left:4.7cm">Fondos Pre-Inveria</div>
            <div style="position:absolute;top:7.6cm;left:14.6cm">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
            <div style="position:absolute;top:8.1cm;left:1.6cm">8101-52535-1</div>
            <div style="position:absolute;top:8.1cm;left:4.7cm">Desembolso de Crédito</div>
            <div style="position:absolute;top:8.1cm;left:17.5cm">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
            <div style="position:absolute;top:11.7cm;left:14.6cm">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
            <div style="position:absolute;top:11.7cm;left:17.5cm">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
        </div>
    </body>
</html>