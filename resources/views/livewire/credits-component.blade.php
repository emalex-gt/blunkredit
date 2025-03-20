<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buscar Créditos') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4">
            <x-input class="w-full" placeholder="&#xF002; Buscar por Cliente o No. de Crédito" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
        </div>

        <table class="w-full" wire:key="table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">DPI</th>
                    <th class="px-6 py-2 text-xs text-gray-500">NOMBRE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TELÉFONO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">EMAIL</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($customers))
                    @foreach ($customers as $customer)
                        <tr wire:key="customer-{{ $customer->id }}">
                            <table class="w-full" wire:key="table-{{ $customer->id }}">
                            <tbody>
                                <tr class="border-b-2 bg-gray-800">
                                    <td class="px-6 py-4 text-md text-white text-center">{{ $customer->code }}</td>
                                    <td class="px-6 py-4 text-md text-white text-center">{{ $customer->dpi }}</td>
                                    <td class="px-6 py-4 text-md text-white text-center">{{ $customer->lastname }}, {{ $customer->name }}</td>
                                    <td class="px-6 py-4 text-md text-white text-center"><a class="text-gray-400" href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></td>
                                    <td class="px-6 py-4 text-md text-white text-center"><a class="text-gray-400" href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                                </tr>
                                <tr class="border-b-2">
                                    <td colspan="5"></td>
                                </tr>
                                <tr class="border-b-2">
                                    <td colspan="5">
                                        <div class="px-4 py-5 text-left" id="show-{{ $customer->id }}">
                                            @can('new-credit')
                                                @livewire('credit-create-component',['customer'=>$customer],key($customer->id))
                                                &nbsp;&nbsp;&nbsp;
                                                @livewire('retroactive-credit-component',['customer'=>$customer],key($customer->id))
                                            @endcan
                                            <h2 class="block py-4 text-center">CRÉDITOS</h3>
                                            @if(count($customer->credits))
                                                <table class="w-full">
                                                    <thead>
                                                        <tr class="border-gray-200 border-b-2">
                                                            <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500">FONDO</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500">TECNOLOGÍA</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500">GARANTÍA</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500">CAPITAL INICIAL</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500">CAPITAL PENDIENTE</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500">ESTADO</th>
                                                            <th class="px-6 py-2 text-xs text-gray-500"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($customer->credits()->orderBy('id','desc')->get() as $credit)
                                                            <tr class="border-gray-200 border-b-2" wire:key="credit-{{ $credit->id }}">
                                                                <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $credit->code }}</td>
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
                                                    </tbody>
                                                </table>
                                            @else
                                                <h4 class="block text-center">No posee créditos</h4>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-gray-200 border-b-2">
                                    <td colspan="5"></td>
                                </tr>
                            </tbody>
                            </table>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
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
    @push('js')
        <script>
            $( ".button-toggle" ).on( "click", function() {
                var refid = $(this).attr('ref-id');
                $( "#show-" + refid ).toggle( "slow" );
            });
        </script>
    @endpush
</div>
