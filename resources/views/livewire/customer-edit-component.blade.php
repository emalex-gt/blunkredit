<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <x-secondary-button wire:click="$set('open',true)">
        <i class="fas fa-edit"></i>
    </x-secondary-button>
    
    
    <x-modal wire:model="open">
        <div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Editar Cliente</h3>
                                <div class="mt-2">
                                    <x-label value="Código" />
                                    <x-label value="{{ $customer->code }}" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="DPI" />
                                    <x-input wire:model="customer.dpi" type="text" placeholder="Ingrese el DPI" class="w-full" />
                                    <x-input-error for="customer.dpi" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Nombre" />
                                    <x-input wire:model="customer.name" type="text" placeholder="Ingrese el nombre" class="w-full" />
                                    <x-input-error for="customer.name" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Apellido" />
                                    <x-input wire:model="customer.lastname" type="text" placeholder="Ingrese el apellido" class="w-full" />
                                    <x-input-error for="customer.lastname" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Email" />
                                    <x-input wire:model="customer.email" type="text" placeholder="Ingrese el email" class="w-full" />
                                    <x-input-error for="customer.email" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Dirección" />
                                    <x-input wire:model="customer.address" type="text" placeholder="Ingrese la dirección" class="w-full" />
                                    <x-input-error for="customer.address" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Teléfono" />
                                    <x-input wire:model="customer.phone" type="text" placeholder="Ingrese el teléfono" class="w-full" />
                                    <x-input-error for="customer.phone" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                        <x-secondary-button wire:click="$set('open',false)" >
                            Cancelar
                        </x-secondary-button>
                        <x-danger-button wire:click="save">
                            Actualizar
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    
</div>
