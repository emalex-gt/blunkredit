<div>
    {{-- Stop trying to control. --}}
    <x-secondary-button wire:click="$set('open',true)">
        <i class="fa-solid fa-circle-info"></i>
    </x-secondary-button>

        <x-modal wire:model="open">
            <div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Detalles</h3>
                                    <div class="mt-2">
                                        <b>Fecha: </b> {{ date('Y-m-d H:i', strtotime($expense->date)) }}
                                    </div>
                                    <div class="mt-2">
                                        <b>Tipo: </b> {{ $expense->expense_type->name }}
                                    </div>
                                    <div class="mt-2">
                                        <b>Monto: </b> Q.{{ number_format(($expense->amount),2,'.',',') }}
                                    </div>
                                    <div class="mt-2">
                                        <b>Fondo de Origen: </b> {{ $expense->fund->name }}
                                    </div>
                                    <div class="mt-2">
                                        <b>Observación: </b> {{ $expense->info }}
                                    </div>
                                    <div class="mt-2">
                                        <b>Usuario Registra: </b> {{ $expense->creator->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                            <x-secondary-button wire:click="$set('open',false)" >
                                Cerrar
                            </x-secondary-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    

</div>
