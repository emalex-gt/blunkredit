<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Colocación') }}
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
            <div class="flex-1 text-right">
                <a href="/print/reporte/colocacion/{{ $asesor }}/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/colocacion/{{ $asesor }}/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">CODIGO DEL CRÉDITO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">NOMBRE DEL CLIENTE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CAPITAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA DESEMBOLSO</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($credits))
                    @php
                        $total=0;
                    @endphp
                    @foreach ($credits as $credit)
                        <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $credit->id }}">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->code }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->customer->code }} - {{ $credit->customer->lastname }}, {{ $credit->customer->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">NUEVO</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($credit->expended_at)) }}</td>
                        </tr>
                        @php
                            $total=$total+$credit->initial_credit_capital;
                        @endphp
                    @endforeach
                        <tr class="border-gray-200 border-b-2">
                            <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="3">TOTAL</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($total,2,'.',',') }}</th>
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

        @if(count($credits))
            @if($credits->hasPages())
                <div class="px-6 py-3">
                    {{ $credits->links() }}
                </div>
            @endif
        @endif

    </x-principal>
</div>
