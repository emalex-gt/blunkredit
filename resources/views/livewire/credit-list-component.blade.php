<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Créditos') }}
        </h2>
    </x-slot>
    <x-principal>
        <div class="px-12 py-12 text-right">
            Estado:
            <select wire:model.live="status">
                <option value="0">Todos</option>
                <option value="1">Registrado</option>
                <option value="2">Autorizado</option>
                <option value="3">Activo</option>
                <option value="4">Finalizado</option>
            </select>
            <x-input placeholder="&#xF002; Buscar por Cliente" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
            Desde: <x-input type="date" wire:model.live="desde" />
            Hasta: <x-input type="date" wire:model.live="hasta" />&nbsp;
            <a href="/print/reporte/creditos/{{ $desde }}/{{ $hasta }}/{{ $status }}/{{ $search }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                <i class="fa-solid fa-file-pdf"></i>
            </a>&nbsp;
            <a href="/export/reporte/creditos/{{ $desde }}/{{ $hasta }}/{{ $status }}/{{ $search }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                <i class="fa-solid fa-file-excel"></i>
            </a>
        </div>
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr class="border-gray-200 border-b-2">
                    <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CLIENTE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FONDO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TECNOLOGÍA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">GARANTÍA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CAPITAL INICIAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CAPITAL PENDIENTE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">ESTADO</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($credits))                
                    @foreach($credits as $credit)
                        <tr class="border-gray-200 border-b-2">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->code }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->customer->name }}, {{ $credit->customer->lastname }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->fund->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->tecnology->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->guarantee->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($credit->initial_credit_capital,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">Q.{{ number_format($credit->pending_credit_capital,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">
                                @switch($credit->status)
                                    @case(1)
                                        <span class="px-1 py-1 rounded" style="background-color:yellow">Registrado</span>
                                        @break
                                    @case(2)
                                        <span class="px-1 py-1 rounded text-white" style="background-color:orange">Autorizado</span>
                                        @break
                                    @case(3)
                                        <span class="px-1 py-1 rounded text-white" style="background-color:green">Activo</span>
                                        @break
                                    @case(4)
                                        <span class="px-1 py-1 rounded text-white" style="background-color:red">Finalizado</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">
                                <a href="{{ route('credito',$credit->id) }}" class="inline-block px-1 py-1 bg-gray-800 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    <small><i class="fa-solid fa-eye"></i></small>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
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
    @push('js')
        <script>
            $( ".button-toggle" ).on( "click", function() {
                var refid = $(this).attr('ref-id');
                $( "#show-" + refid ).toggle( "slow" );
            });
        </script>
    @endpush
</div>
