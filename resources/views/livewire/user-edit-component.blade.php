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
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Editar Usuario</h3>
                                <div class="mt-2">
                                    <x-label value="Código" />
                                    <x-label value="{{ $user->code }}" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="DPI" />
                                    <x-input wire:model="user.dpi" type="text" placeholder="Ingrese el DPI" class="w-full" />
                                    <x-input-error for="user.dpi" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Nombre" />
                                    <x-input wire:model="user.name" type="text" placeholder="Ingrese el nombre" class="w-full" />
                                    <x-input-error for="user.name" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Email" />
                                    <x-input wire:model="user.email" type="text" placeholder="Ingrese el email" class="w-full" />
                                    <x-input-error for="user.email" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Rol" />
                                    <select wire:model="role" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="role" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Cambiar Contraseña" />
                                    <x-input wire:model="password" type="password" placeholder="Ingrese la contraseña nueva" class="w-full" autocomplete="new-password" />
                                    <x-input-error for="password" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Dirección" />
                                    <x-input wire:model="user.address" type="text" placeholder="Ingrese la dirección" class="w-full" />
                                    <x-input-error for="user.address" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Teléfono" />
                                    <x-input wire:model="user.phone" type="text" placeholder="Ingrese el teléfono" class="w-full" />
                                    <x-input-error for="user.phone" />
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
