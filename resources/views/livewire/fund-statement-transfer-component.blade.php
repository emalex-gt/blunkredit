<div>
    {{-- Stop trying to control. --}}
    <button wire:click="$set('open',true)" class="inline-block px-4 py-3 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition"><i class="fa-solid fa-circle-minus mr-2"></i>&nbsp;Transferir</button>

    
        <x-modal wire:model="open">
            <div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Transferencia entre Fondos</h3>
                                    <div class="mt-2">
                                        <x-label value="Destino de los Fondos" />
                                        <select wire:model="fund_transfer" class="w-full">
                                                <option value="">----</option>
                                            @foreach($funds as $fund)
                                                <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="fund_transfer" />
                                    </div>
                                    <div class="mt-2">
                                        <x-label value="Monto" />
                                        <x-input wire:model="amount" type="text" placeholder="Ingrese la Cantidad Q." class="w-full" />
                                        <x-input-error for="amount" />
                                    </div>
                                    <div class="mt-2">
                                        <x-label value="Observacion" />
                                        <x-input wire:model="info" type="text" placeholder="Observación" class="w-full" />
                                        <x-input-error for="info" />
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
