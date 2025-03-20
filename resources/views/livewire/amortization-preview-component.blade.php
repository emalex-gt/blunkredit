<div>
    @if(
        $credit_line_id!='' &&
        $guarantee_id!='' &&
        $tecnology_id!='' &&
        $policy_id!='' &&
        $time_limit_id!='' &&
        $interest_id!='' &&
        $initial_capital!=''
    )
        <a onclick="printDiv('tabla')" class="cursor-pointer inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
            <i class="fa-solid fa-print"></i>&nbsp;Imprimir Tabla
        </a><br><br>
        <div style="overflow:auto" id="tabla">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500" colspan="6">{{ $customer->code }} - {{ $customer->lastname }}, {{ $customer->name }}</th> 
                    </tr>
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">No.</th>
                        <th class="px-6 py-2 text-xs text-gray-500">Fecha</th>
                        <th class="px-6 py-2 text-xs text-gray-500">Cuota Capital</th>
                        <th class="px-6 py-2 text-xs text-gray-500">Interes</th>
                        <th class="px-6 py-2 text-xs text-gray-500">Total</th>
                        <th class="px-6 py-2 text-xs text-gray-500">Saldo Capital</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr>
                        <td class="px-6 py-2 text-xs text-gray-500" colspan="5"></td>
                        <td class="px-6 py-2 text-xs text-gray-500">
                            {{ number_format($initial_capital,2,'.',',') }}
                        </td>
                    </tr>
                    @php
                        $total_interes=0;
                        $total_a_pagar=0;
                    @endphp
                    @if($policy_id==1)        
                        @php
                            $cuota = $amortization->cuota_nivelada($initial_capital,$interest_id,$time_limit_id);
                            $interes = $interest->find($interest_id);
                            $plazo = $timelimit->find($time_limit_id);
                            $saldo_capital = $initial_capital;
                            $fecha=date('Y-m-d');
                        @endphp
                        @for($i=1; $i <= $plazo->name; $i++)
                            @php
                                $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
                                $interes_cuota = $saldo_capital * ($interes->name / 12 / 100);
                                $capital_cuota = $cuota - $interes_cuota;
                                $saldo_capital = $saldo_capital - $capital_cuota;
                                $total_interes=$total_interes + $interes_cuota;
                                $total_a_pagar=$total_a_pagar + $cuota;
                            @endphp
                            <tr>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ $i }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ date('d/m/Y',strtotime($fecha)) }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($capital_cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($interes_cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($saldo_capital,2,'.',',') }}
                                </td>
                            </tr>
                        @endfor
                    @elseif($policy_id==2)
                        @php
                            $interes = $interest->find($interest_id);
                            $plazo = $timelimit->find($time_limit_id);
                            $saldo_capital = $initial_capital;
                            $fecha=date('Y-m-d');
                        @endphp
                        @for($i=1; $i <= $plazo->name; $i++)
                            @php
                                $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
                                $interes_cuota = ((($saldo_capital * ($interes->name / 100))/365)*31);
                                $capital_cuota = $initial_capital/$plazo->name;
                                $saldo_capital = $saldo_capital - $capital_cuota;
                                $cuota=$interes_cuota+$capital_cuota;
                                $total_interes=$total_interes + $interes_cuota;
                                $total_a_pagar=$total_a_pagar + $cuota;
                            @endphp
                            <tr>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ $i }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ date('d/m/Y',strtotime($fecha)) }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($capital_cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($interes_cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($saldo_capital,2,'.',',') }}
                                </td>
                            </tr>
                        @endfor
                    @else
                        @php
                            $interes = $interest->find($interest_id);
                            $plazo = $timelimit->find($time_limit_id);
                            $saldo_capital = $initial_capital;
                            $capital_cuota = $initial_capital / $plazo->name;
                            $interes_cuota = (((((($saldo_capital * ($interes->name / 100))/365)*31)*$plazo->name))/$plazo->name);
                            $fecha=date('Y-m-d');
                        @endphp
                        @for($i=1; $i <= $plazo->name; $i++)
                            @php
                                $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
                                $saldo_capital = $saldo_capital - $capital_cuota;
                                $cuota=$interes_cuota+$capital_cuota;
                                $total_interes=$total_interes + $interes_cuota;
                                $total_a_pagar=$total_a_pagar + $cuota;
                            @endphp
                            <tr>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ $i }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ date('d/m/Y',strtotime($fecha)) }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($capital_cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($interes_cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($cuota,2,'.',',') }}
                                </td>
                                <td class="px-6 py-2 text-xs text-gray-500">
                                    {{ number_format($saldo_capital,2,'.',',') }}
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
                <tfooter>
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500"></th>
                        <th class="px-6 py-2 text-xs text-gray-500"></th>
                        <th class="px-6 py-2 text-xs text-gray-500 text-right">Total:</th>
                        <th class="px-6 py-2 text-xs text-gray-500">{{ number_format($total_interes,2,'.',',') }}</th>
                        <th class="px-6 py-2 text-xs text-gray-500">{{ number_format($total_a_pagar,2,'.',',') }}</th>
                        <th class="px-6 py-2 text-xs text-gray-500"></th>
                    </tr>
                </tfooter>
            </table>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
            <x-danger-button wire:click="save" class="mt-4 mb-4">
                Registrar Solicitud de Crédito
            </x-danger-button>
        </div>
    @else
        <h4 class="py-4">Debe llenar todos los datos anteriores.</h4>
    @endif
    
</div>
