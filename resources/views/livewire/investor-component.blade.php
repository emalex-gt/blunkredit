<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inversores/Dueños') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                @livewire('investor-create-component')
            </div>
            <div class="flex-1">
                <x-input class="w-1/2" placeholder="&#xF002; Buscar por Nombre, DPI o Email" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
                <b>Tipo: </b> 
                <select wire:model.live="type"> 
                    <option value="0">---Todos---</option>
                    <option value="1">Dueño</option>
                    <option value="2">Inversor</option>
                </select>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">TIPO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">DPI</th>
                    <th class="px-6 py-2 text-xs text-gray-500">NOMBRE</th>
                    <th class="px-6 py-2 text-xs text-gray-500">TELÉFONO</th>
                    <th class="px-6 py-2 text-xs text-gray-500">EMAIL</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($investors))
                    @foreach ($investors as $investor)
                        <tr class="border-gray-200 border-b-2" wire:key="customer-{{ $investor->id }}">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">
                                @if($investor->type==1)
                                    Dueño
                                @elseif($investor->type==2)
                                    Inversor
                                @endif
                            </td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $investor->dpi }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $investor->lastname }}, {{ $investor->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center"><a class="text-gray-900" href="tel:{{ $investor->phone }}">{{ $investor->phone }}</a></td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center"><a class="text-gray-900" href="mailto:{{ $investor->email }}">{{ $investor->email }}</a></td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">
                                <div class="inline-block">
                                    @livewire('investor-edit-component',['investor'=>$investor],key($investor->id))
                                </div>
                                <div class="inline-block">
                                    <x-danger-button wire:click="$dispatch('deleteInvestor', {{ $investor->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </x-danger-button>
                                </div>
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

        @if(count($investors))
            @if($investors->hasPages())
                <div class="px-6 py-3">
                    {{ $investors->links() }}
                </div>
            @endif
        @endif

    </x-principal>

    @push('js')
        <script>
            Livewire.on('deleteInvestor', investorId => {
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

                        Livewire.dispatchTo('investor-component','delete', { investorId: investorId})

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
