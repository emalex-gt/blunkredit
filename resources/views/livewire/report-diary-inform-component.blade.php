<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Ingresos Diarios') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                Desde: <x-input type="date" wire:model.live="desde" />
            </div>
            <div class="flex-1">
                Hasta: <x-input type="date" wire:model.live="hasta" />
            </div>
            <div class="flex-1 text-right">
                <a href="/print/reporte/informe-diario/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/informe-diario/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>
        @php
            $fecha_inicial = new DateTime($desde);
            $fecha_final = new DateTime($hasta);
            
            $fecha_final = $fecha_final ->modify('+1 day');

            $intervalo = DateInterval::createFromDateString('1 day');
            $periodo = new DatePeriod($fecha_inicial , $intervalo, $fecha_final);
        @endphp
        <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">NO.</th>
                        <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                        <th class="px-6 py-2 text-xs text-gray-500">INTERES</th>
                        <th class="px-6 py-2 text-xs text-gray-500">RECARGO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @php
                        $total_capital=0;
                        $total_interes=0;
                        $total_delay=0;
                        $total=0;
                        $i=1;
                    @endphp
                    @foreach($periodo as $dt)
                        @php
                            $capital=0;
                            $interes=0;
                            $delay=0;
                            $total_p=0;
                        @endphp
                        @if(count($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59'])))
                            @foreach ($amortizations->whereBetween('payment_date',[$dt->format("Y-m-d").' 00:00:00',$dt->format("Y-m-d").' 23:59:59']) as $amortization)
                                @php
                                    $capital=$capital+$amortization->capital;
                                    $interes=$interes+$amortization->interest;
                                    $delay=$delay+$amortization->delay;
                                    $total_p=$total_p+$amortization->total_payment;
                                @endphp
                            @endforeach
                        @endif
                        <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $i }}">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $i }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $dt->format("d-m-Y") }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($capital,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($interes,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($delay,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_p,2,'.',',') }}</td>
                        </tr>
                        @php
                            $total_capital=$total_capital+$capital;
                            $total_interes=$total_interes+$interes;
                            $total_delay=$total_delay+$delay;
                            $total=$total+$total_p;
                            $i++;
                        @endphp
                    @endforeach
                    <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                        <td class="px-6 py-4 text-md text-gray-500 text-center"></td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">TOTAL</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_delay,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total,2,'.',',') }}</td>
                    </tr>
                </tbody>
            </table>
    </x-principal>
</div>
