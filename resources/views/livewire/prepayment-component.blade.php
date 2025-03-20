<div>
    {{-- Stop trying to control. --}}
    <x-button wire:click="$set('open',true)">Pagar Adelantado</x-button>
    
    <x-modal wire:model="open"> 
        <div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">PAGO ADELANTADO</h3>
                                <div class="mt-2">
                                    <x-label value="No. de Recibo" />
                                    <x-input wire:model="receipt_number" type="text" class="w-full" />
                                    <x-input-error for="receipt_number" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Capital" />
                                    <x-input type="text" class="w-full" value="Q.{{ number_format($amortizationschedule->capital,2,'.',',') }}" readonly/>
                                </div>
                                <div class="mt-2">
                                    <x-label value="Interés" />
                                    <x-input type="text" class="w-full" value="Q.{{ number_format($amortizationschedule->interest,2,'.',',') }}" readonly/>
                                </div>
                                <div class="mt-2">
                                    <x-label value="Total" />
                                    <x-input type="text" class="w-full" value="Q.{{ number_format(($amortizationschedule->capital+$amortizationschedule->interest+$amortizationschedule->delay),2,'.',',') }}" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                        <x-secondary-button wire:click="$set('open',false)" >
                            Cancelar
                        </x-secondary-button>
                        <x-danger-button wire:click="save">
                            Registrar Pago
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    

</div>
