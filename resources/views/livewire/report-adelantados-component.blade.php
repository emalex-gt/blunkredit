<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Ingresos por Aplicar') }}
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
            <div class="flex-1">
                Asesor
                <select wire:model.live="asesor">
                    <option value="0">-TODOS-</option>
                    @foreach($asesores as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <x-input class="w-full" placeholder="&#xF002; Buscar por Cliente" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
            </div>
            <div class="flex-1 text-right">
                <a href="/print/reporte/adelantados/{{ $asesor }}/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/adelantados/{{ $asesor }}/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">NOMBRE DEL CLIENTE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FONDO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">INTERES</th>
                    <th class="px-6 py-2 text-xs text-gray-500">MORA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">ASESOR</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($prepayments))
                    @php
                        $total_capital=0;
                        $total_interes=0;
                        $total_delay=0;
                        $total=0;
                    @endphp
                    @foreach ($prepayments as $prepayment)
                        <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $prepayment->id }}">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($prepayment->date)) }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $prepayment->amortization_schedule->credit->customer->code }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $prepayment->amortization_schedule->credit->customer->lastname }}, {{ $prepayment->amortization_schedule->credit->customer->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $prepayment->amortization_schedule->credit->fund->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($prepayment->amortization_schedule->capital,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($prepayment->amortization_schedule->interest,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($prepayment->amortization_schedule->delay,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($prepayment->amortization_schedule->total,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $prepayment->payment_by->name }}</td>
                        </tr>
                        @php
                            $total_capital=$total_capital+$prepayment->amortization_schedule->capital;
                            $total_interes=$total_interes+$prepayment->amortization_schedule->interest;
                            $total_delay=$total_delay+$prepayment->amortization_schedule->delay;
                            $total=$total+$prepayment->amortization_schedule->total;
                        @endphp
                    @endforeach
                        <tr class="border-gray-200 border-b-2">
                            <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="4">TOTAL</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_capital,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_interes,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total_delay,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">{{ number_format($total,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center"></th>
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

        @if(count($prepayments))
            @if($prepayments->hasPages())
                <div class="px-6 py-3">
                    {{ $prepayments->links() }}
                </div>
            @endif
        @endif

    </x-principal>
</div>
