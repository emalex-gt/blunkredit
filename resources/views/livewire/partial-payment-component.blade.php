<div>
    {{-- Stop trying to control. --}}
    @if($this->credit->status > 3)
        <x-button wire:click="$set('open',true)">Pago Parcial</x-button>
    @endif
    
    <x-modal wire:model="open"> 
        <div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">PAGO PARCIAL</h3>
                                <div class="mt-2">
                                    <x-label value="No. de Recibo" />
                                    <x-input wire:model="receipt_number" type="text" class="w-full" />
                                    <x-input-error for="receipt_number" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Total" />
                                    @php
                                        $cuota=0;
                                    @endphp
                                    @foreach($this->credit->partial_payments()->where('amortization_schedule_id',0)->get() as $partialpayment)
                                        @php
                                            $cuota=$cuota+$partialpayment->amount;
                                        @endphp
                                    @endforeach
                                    @if($cuota==0)
                                        <span style="color:red">Recuerda que el pago parcial debe ser menor a la cuota: Q.{{ number_format(($credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->total + $credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->delay),2,'.',',') }}<br><br>Si el pago actual es mayor a este monto por favor utilice la opción de Pagar y el sobrante lo puede abonar como pago parcial</span>
                                    @else
                                        <span style="color:red">Recuerda que el pago parcial debe ser menor a Q.{{ number_format(($credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->total + $credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->delay - $cuota),2,'.',',') }} (incluye la cuota de Q.{{ number_format(($credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->total + $credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->delay),2,'.',',') }} con una resta por pagos parciales de Q.{{ number_format($cuota,2,'.',',') }})<br><br>Si el pago actual es mayor a este monto por favor utilice la opción de Pagar y el sobrante lo puede abonar como pago parcial</span>
                                    @endif
                                    <x-input wire:model="amount" type="text" class="w-full" />
                                    <x-input-error for="amount" />
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
