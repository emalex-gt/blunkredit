<div>
    {{-- Stop trying to control. --}}
    <button wire:click="$set('open',true)" class="inline-block px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"><i class="fa-solid fa-circle-plus mr-2"></i>&nbsp;Nuevo</button>

    
        <x-modal wire:model="open">
            <div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Crear Nuevo Fondo</h3>
                                    <div class="mt-2">
                                        <x-label value="Nombre" />
                                        <x-input wire:model.defer="name" type="text" placeholder="Ingrese el nombre" class="w-full" />
                                        <x-input-error for="name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                            <x-secondary-button wire:click="$set('open',false)" >
                                Cancelar
                            </x-secondary-button>
                            <x-danger-button wire:click="save">
                                Guardar
                            </x-danger-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    

</div>
