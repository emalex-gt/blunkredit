<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gastos') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                @livewire('expense-create-component')
            </div>
            <div class="flex-1">
                Desde: <x-input class="w-full" type="date" wire:model.live="desde" style="font-family:Arial, FontAwesome" />
            </div>
            <div class="flex-1">
                Hasta: <x-input class="w-full" type="date" wire:model.live="hasta" style="font-family:Arial, FontAwesome" />
            </div>
            <div class="flex-1 text-right">
                <a href="/print/reporte/gastos/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/gastos/{{ $desde }}/{{ $hasta }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">FECHA</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">FONDO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">CANTIDAD</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($expenses))
                    @foreach ($expenses as $expense)
                        <tr class="border-gray-200 border-b-2">
                            <td class="px-6 py-4 text-md text-gray-500">{{ $expense->date }}</td>
                            <td class="px-6 py-4 text-md text-gray-500">{{ $expense->expense_type->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500">{{ $expense->fund->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500">{{ $expense->amount }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">
                                <div class="inline-block">
                                    @livewire('expense-show-component',['expense'=>$expense],key($expense->id))
                                </div>
                                <div class="inline-block">
                                    <x-danger-button wire:click="$dispatch('deleteExpense', {{ $expense->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </x-danger-button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
                            No existen registros en estas fechas, por favor elija otras
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if(count($expenses))
            @if($expenses->hasPages())
                <div class="px-6 py-3">
                    {{ $expenses->links() }}
                </div>
            @endif
        @endif

    </x-principal>

    @push('js')
        <script>
            Livewire.on('deleteExpense', expenseId => {
                Swal.fire({
                    title: "Esta seguro que desea anular el gasto?",
                    text: "Si ocurre un error por esta acción deberá comunicarse a soporte!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, anular!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatchTo('expense-component','delete', { expenseId: expenseId})

                        Swal.fire({
                            title: "Anulado!",
                            text: "Su gasto ha sido anulado.",
                            icon: "success"
                        });
                    }
                });
            })
        </script>
    @endpush
</div>
