<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plazos') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                @livewire('time-limit-create-component')
            </div>
            <div class="flex-1">
                <x-input class="w-full" placeholder="&#xF002; Buscar" type="text" wire:model.live="search" style="font-family:Arial, FontAwesome" />
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500">PLAZO</th>
                    <th class="px-6 py-2 text-xs text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if(count($timelimits))
                    @foreach ($timelimits as $timelimit)
                        <tr class="border-gray-200 border-b-2">
                            <td class="px-6 py-4 text-md text-gray-500">{{ $timelimit->name }} MESES</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-right">
                                <div class="inline-block">
                                    @livewire('time-limit-edit-component',['timelimit'=>$timelimit],key($timelimit->id))
                                </div>
                                <div class="inline-block">
                                    <x-danger-button wire:click="$dispatch('deleteTimelimit', {{ $timelimit->id }})">
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

        @if(count($timelimits))
            @if($timelimits->hasPages())
                <div class="px-6 py-3">
                    {{ $timelimits->links() }}
                </div>
            @endif
        @endif

    </x-principal>

    @push('js')
        <script>
            Livewire.on('deleteTimelimit', timelimitId => {
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

                        Livewire.dispatchTo('time-limit-component','delete', { timelimitId: timelimitId})

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
