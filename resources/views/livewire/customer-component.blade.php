<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                @livewire('customer-create-component')
            </div>
            <div class="flex-1">
                <x-input class="w-full" placeholder="&#xF002; Buscar por Nombre, DPI, Código o Email" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
            </div>
            <a href="/print/reporte/clientes/{{ $search }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/clientes/{{ $search }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">DPI</th>
                    <th class="px-6 py-2 text-xs text-gray-500">NOMBRE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TELÉFONO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">EMAIL</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($customers))
                    @foreach ($customers as $customer)
                        <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $customer->id }}">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->code }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->dpi }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->lastname }}, {{ $customer->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center"><a class="text-gray-900" href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center"><a class="text-gray-900" href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">
                                <div class="inline-block">
                                    @livewire('customer-edit-component',['customer'=>$customer],key($customer->id))
                                </div>
                                <div class="inline-block">
                                    <x-danger-button wire:click="$dispatch('deleteCustomer', {{ $customer->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </x-danger-button>
                                </div>
                            </td>
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
            Livewire.on('deleteCustomer', customerId => {
                Swal.fire({
                    title: "Esta seguro que desea deshabilitar el registro?",
                    text: "Si ocurre un error por esta acción deberá comunicarse a soporte!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, deshabilitarlo!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatchTo('customer-component','delete', { customerId: customerId})

                        Swal.fire({
                            title: "Deshabilitado!",
                            text: "Su registro ha sido deshabilitado.",
                            icon: "success"
                        });
                    }
                });
            })
        </script>
    @endpush
</div>
