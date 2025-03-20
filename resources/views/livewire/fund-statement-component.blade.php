<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estado de Cuenta') }} - {{ $fund->name }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            @if(count($statements))
                <div class="flex-1">
                    @livewire('fund-statement-credit-component',['fund'=>$fund],key($fund->id))
                </div>
                <div class="flex-1">
                    @livewire('fund-statement-debit-component',['fund'=>$fund],key($fund->id))
                </div>
                <div class="flex-1">
                    @livewire('fund-statement-transfer-component',['fund'=>$fund],key($fund->id))
                </div>
                @if($statements->first()->type==1 || $statements->first()->type==2 || $statements->first()->type==3 || $statements->first()->type==6)
                    <div class="flex-1">
                        <x-danger-button wire:click="$dispatch('deleteStatement', {{ $statements->first()->id }})">
                            <i class="fa-solid fa-trash"></i> Eliminar Último Registro
                        </x-danger-button>
                    </div>
                @endif
                <div class="flex-1 text-right"> 
                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-statement',['id'  => $fund->id]) }}">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('export-statement',['id' => $fund->id]) }}">
                        <i class="fa-solid fa-file-excel"></i>
                    </a>
                </div>
            @else
                <div class="flex-1">
                    @livewire('fund-statement-open-component',['fund'=>$fund],key($fund->id))
                </div>
            @endif
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CRÉDITO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">DÉBITO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">SALDO</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($statements))
                    @foreach ($statements as $statement)
                        <tr class="border-gray-200 border-b-2">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ date('Y-m-d H:i',strtotime($statement->date)) }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">
                                @switch($statement->type)
                                    @case(1)
                                        Apertura de Fondo
                                        @break
                                    @case(2)
                                        Suma de Capital de Inversor/Dueño
                                        @break
                                    @case(3)
                                        Suma de Capital de Fondo
                                        @break
                                    @case(4)
                                        Desembolso de Crédito
                                        @break
                                    @case(5)
                                        Abono de Crédito
                                        @break
                                    @case(6)
                                        Retiro de Capital de Fondo
                                        @break
                                    @default
                                        Otros
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">{{ number_format($statement->credit,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">{{ number_format($statement->debit,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">{{ number_format($statement->balance,2,'.',',') }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">
                                @livewire('fund-statement-info-component',['statement'=>$statement],key($statement->id))
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
                            No existen registros
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if(count($statements))
            @if($statements->hasPages())
                <div class="px-6 py-3">
                    {{ $statements->links() }}
                </div>
            @endif
        @endif

    </x-principal>

    @push('js')
        <script>
            Livewire.on('deleteStatement', statementId => {
                Swal.fire({
                    title: "Esta seguro que desea eliminar el último registro?",
                    text: "Si ocurre un error por esta acción deberá comunicarse a soporte!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatchTo('fund-statement-component','delete', { statementId: statementId})

                        Swal.fire({
                            title: "Eliminado!",
                            text: "Su registro ha sido eliminado.",
                            icon: "success"
                        });
                    }
                });
            })
        </script>
    @endpush
</div>
