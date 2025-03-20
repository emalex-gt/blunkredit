<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <button wire:click="$set('open',true)" class="inline-block px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"><i class="fa-solid fa-circle-plus mr-2"></i>&nbsp;Nuevo</button>
    
    
    <x-modal wire:model="open">
        <div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Crear Usuario</h3>
                                <div class="mt-2">
                                    <x-label value="DPI" />
                                    <x-input wire:model="dpi" type="text" placeholder="Ingrese el DPI" class="w-full" />
                                    <x-input-error for="dpi" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Nombre" />
                                    <x-input wire:model="name" type="text" placeholder="Ingrese el nombre" class="w-full" />
                                    <x-input-error for="name" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Email" />
                                    <x-input wire:model="email" type="text" placeholder="Ingrese el email" class="w-full" />
                                    <x-input-error for="email" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Rol" />
                                    <select wire:model="role" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">-----</option>
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
                                    <x-label value="Teléfono" />
                                    <x-input wire:model="phone" type="text" placeholder="Ingrese el teléfono" class="w-full" />
                                    <x-input-error for="phone" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Dirección" />
                                    <x-input wire:model="address" type="text" placeholder="Ingrese la dirección" class="w-full" />
                                    <x-input-error for="address" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                        <x-secondary-button wire:click="$set('open',false)" >
                            Cancelar
                        </x-secondary-button>
                        <x-danger-button wire:click="save">
                            Crear
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    
</div>
