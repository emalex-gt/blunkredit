<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Proyección de Pagos') }}
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
                <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-reporte-proyeccion',['desde'=>$desde,'hasta'=>$hasta]) }}">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('export-reporte-proyeccion',['desde'=>$desde,'hasta'=>$hasta]) }}">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">Crédito</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Nombre Completo</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Dirección</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Fondo</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Teléfono</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Capital</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Interés</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Mora</th>
                    <th class="px-6 py-2 text-xs text-gray-500">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @php
                    $total_capital=0;
                    $total_interes=0;
                    $total_delay=0;
                    $total=0;

                    $total_day_capital=0;
                    $total_day_interes=0;
                    $total_day_delay=0;
                    $total_day=0;

                    $dia='';
                    $asesor='';
                @endphp
                @foreach ($amortizations as $amortization)
                    @if($asesor!=$amortization->created_user)
                        <tr>
                            <th colspan="9" class="px-6 py-4 text-md text-gray-500" style="text-align:left">{{ $amortization->user }}</th>
                        </tr>
                        @php
                            $asesor=$amortization->created_user;
                        @endphp
                    @endif
                    @if($dia!='' && $dia!=date('Y-m-d',strtotime($amortization->share_date)))
                        <tr class="border-gray-200 border-b-2">
                            <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="5">Total del día {{ date('d/m/Y',strtotime($dia)) }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_capital,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_interes,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_delay,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day,2,'.',',') }}</th>
                        </tr>
                        @php
                            $total_day_capital=0;
                            $total_day_interes=0;
                            $total_day_delay=0;
                            $total_day=0;
                        @endphp
                    @endif
                    <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $amortization->id }}">
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->code }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->lastname }}, {{ $amortization->name }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->address }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->fund }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $amortization->phone }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->capital,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->interest,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($amortization->delay,2,'.',',') }}</td>
                        <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format(($amortization->total+$amortization->delay),2,'.',',') }}</td>
                    </tr>
                    @php
                        $dia=date('Y-m-d',strtotime($amortization->share_date));
                        $total_capital=$total_capital+$amortization->capital;
                        $total_interes=$total_interes+$amortization->interest;
                        $total_delay=$total_delay+$amortization->delay;
                        $total=$total+($amortization->total+$amortization->delay);

                        $total_day_capital=$total_day_capital+$amortization->capital;
                        $total_day_interes=$total_day_interes+$amortization->interest;
                        $total_day_delay=$total_day_delay+$amortization->delay;
                        $total_day=$total_day+($amortization->total+$amortization->delay);
                    @endphp
                @endforeach
                    <tr class="border-gray-200 border-b-2">
                        <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="5">Total del día {{ date('d/m/Y',strtotime($dia)) }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_capital,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_interes,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day_delay,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_day,2,'.',',') }}</th>
                    </tr>
                    <tr class="border-gray-200 border-b-2">
                        <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="5">Total por periodo</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_delay,2,'.',',') }}</th>
                        <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total,2,'.',',') }}</th>
                    </tr>
            </tbody>
        </table>

    </x-principal>
</div>

