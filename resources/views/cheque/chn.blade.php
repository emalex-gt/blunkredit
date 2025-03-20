<html>
    <head>
        <title>Cheque de Crédito No. {{ $credit->id }}</title>
        <style>
            body{
                margin:0;
                font-size:14px;
            }
            .body{
                width:21.59cm;
                height:27.94cm;
            }
            .hoja2{
                width:21.59cm;
                margin:0.5cm;
            }
            table{
                border-collapse: collapse;
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
            <div style="position:absolute;top:3.1cm;left:3cm">Chichicastenango, {{ date('d') }} de {{ $month }} del {{ date('Y') }}</div>
            <div style="position:absolute;top:3.1cm;left:17.2cm">{{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
            <div style="position:absolute;top:3.95cm;left:2.4cm">{{ $credit->customer->name }} {{ $credit->customer->lastname }}</div>
            <?php
                $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                $porcion = explode('.', $credit->initial_credit_capital);
                if ($porcion[1]>0){
                    $decimal='con '.$formatterES->format($porcion[1]).' centavos';
                } else {
                    $decimal='exactos';
                }
            ?>
            <div style="position:absolute;top:4.8cm;left:2.1cm">{{ ucfirst($formatterES->format($porcion[0])) }} {{ $decimal }}</div>
            <div style="position:absolute;top:7.2cm;left:4.6cm">NO NEGOCIABLE</div>
        </div>
        <div class="hoja2">
            <div>
                <div style="float:left;width:30%"><img src="{{asset('build/assets/img/logo.png')}}" height="75px"/></div>
                <div style="float:left;width:60%;text-align:right;font-size:14px">
                    <center><b>INVERIA SOCIEDAD ANÓNIMA</b><br><b>5a avenida 10-34 ZONA 1, CHICHICASTENANGO, EL QUICHE</b></center>
                    <b>CHEQUE VOUCHER No. {{ $credit->cheque_no }}</b>
                </div>
                <div style="clear:both"></div>
                <div style="margin-bottom:10px">.</div>
                <div style="border:1px solid #000;position:relative">
                    <div style="position:absolute;top:3.1cm;left:3cm">Chichicastenango, {{ date('d') }} de {{ $month }} del {{ date('Y') }}</div>
                    <div style="position:absolute;top:3.1cm;left:17.2cm">{{ number_format($credit->initial_credit_capital,2,'.',',') }}</div>
                    <div style="position:absolute;top:3.95cm;left:2.4cm">{{ $credit->customer->name }} {{ $credit->customer->lastname }}</div>
                    <div style="position:absolute;top:4.8cm;left:2.1cm">{{ ucfirst($formatterES->format($porcion[0])) }} {{ $decimal }}</div>
                    <div style="padding-left:10px;margin-top:8cm;margin-bottom:20px">NOMBRE: INVERIA SOCIEDAD ANÓNIMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No cta: 01-064-006344-3</div>
                </div>
                <div style="border:1px solid #000;position:relative;padding:10px">
                    <?php
                        switch (date('n',strtotime($credit->expended_at))) {
                            case 1:
                                $month='enero';
                                break;
                            case 2:
                                $month='febrero';
                                break;
                            case 3:
                                $month='marzo';
                                break;
                            case 4:
                                $month='abril';
                                break;
                            case 5:
                                $month='mayo';
                                break;
                            case 6:
                                $month='junio';
                                break;
                            case 7:
                                $month='julio';
                                break;
                            case 8:
                                $month='agosto';
                                break;
                            case 9:
                                $month='septiembre';
                                break;
                            case 10:
                                $month='octubre';
                                break;
                            case 11:
                                $month='noviembre';
                                break;
                            case 12:
                                $month='diciembre';
                                break;
                        }
                    ?>
                    <b>CONCEPTO: </b>Pago de interés del {{ ($credit->interest->name/12)}}% mensual, según contrato mutuo número {{ $credit->contract_no }}, correspondiente al mes de {{ $month }} del {{ date('Y',strtotime($credit->expended_at)) }} 
                </div>
                <table cellspacing="0" cellpadding="0" width="100%" style="widht:100%">
                    <tr>
                        <th style="border:1px solid #000;padding:5px">CUENTA</th>
                        <th style="border:1px solid #000;padding:5px">DESCRIPCIÓN</th>
                        <th style="border:1px solid #000;padding:5px">DEBE</th>
                        <th style="border:1px solid #000;padding:5px">HABER</th>
                    </tr>
                    <tr>
                        <th style="border:1px solid #000;padding:5px">01-064-006344-3</th>
                        <th style="border:1px solid #000;padding:5px">FONDOS INVERIA</th>
                        <th style="border:1px solid #000;padding:5px">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</th>
                        <th style="border:1px solid #000;padding:5px"></th>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:5px">01-064-006344-3</td>
                        <td style="border:1px solid #000;padding:5px">Pago de Interés según contrato mutuo número {{ $credit->contract_no }}</td>
                        <td style="border:1px solid #000;padding:5px"></td>
                        <td style="border:1px solid #000;padding:5px">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:5px;height:280px"></td>
                        <td style="border:1px solid #000;padding:5px"></td>
                        <td style="border:1px solid #000;padding:5px"></td>
                        <td style="border:1px solid #000;padding:5px"></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:5px"></td>
                        <td style="border:1px solid #000;padding:5px">TOTAL</td>
                        <td style="border:1px solid #000;padding:5px">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                        <td style="border:1px solid #000;padding:5px">Q. {{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" width="100%" style="widht:100%">
                    <tr>
                        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;padding:5px">HECHO POR:</td>
                        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;padding:5px">REVISADO POR:</td>
                        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;padding:5px">AUTORIZADO POR:</td>
                        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;padding:5px">AUTORIZADO POR:</td>
                    </tr>
                    <tr>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;height:75px"></td>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;height:75px"></td>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;height:75px"></td>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;height:75px"></td>
                    </tr>
                    <tr>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;text-align:center">K.Y.P.I</td>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;text-align:center">P.G.I.P</td>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;text-align:center">R.M.O</td>
                        <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;text-align:center">C.M.L</td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" width="100%" style="widht:100%">
                    <tr>
                        <td style="border:1px solid #000;padding:10px">RECIBIDO POR:<br><br>DPI:</td>
                        <td style="border:1px solid #000;padding:10px">FIRMA:</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>