<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Saldos de Clientes') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                <x-input class="w-full" placeholder="&#xF002; Buscar por Nombre, DPI, Código o Email" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
            </div>
            <div class="flex-1 text-right">
                <a href="/print/reporte/creditos/clientes/{{ $search }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/creditos/clientes/{{ $search }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">NOMBRE DEL CLIENTE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA DE ALTA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">SALDO CAPITAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">INTERESES</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($customers))
                    @php
                        $total=0;
                        $total_i=0;
                    @endphp
                    @foreach ($customers as $customer)
                        <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $customer->id }}">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->code }} - {{ $customer->lastname }}, {{ $customer->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('d/m/Y',strtotime($customer->credits()->first()->expended_at)) }}</td>
                            @php
                                $capital=0;
                                $interes=0;
                            @endphp
                            @foreach($customer->credits()->get() as $credit)
                                @php
                                    $capital=$capital+$credit->pending_credit_capital;
                                    $interes=$interes+($credit->initial_interest_balance - $credit->interest_paid);
                                @endphp
                            @endforeach
                            <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($capital,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($interes,2,'.',',') }}</td>
                        </tr>
                        @php
                            $total=$total+$capital;
                            $total_i=$total_i+$interes;
                        @endphp
                    @endforeach
                        <tr class="border-gray-200 border-b-2">
                            <th class="px-6 py-4 text-md text-gray-500 text-right" colspan="2">TOTAL</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($total,2,'.',',') }}</th>
                            <th class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($total_i,2,'.',',') }}</th>
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

        @if(count($customers))
            @if($customers->hasPages())
                <div class="px-6 py-3">
                    {{ $customers->links() }}
                </div>
            @endif
        @endif

    </x-principal>
</div>
