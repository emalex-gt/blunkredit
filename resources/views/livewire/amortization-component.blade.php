<div>
    {{-- Stop trying to control. --}}
    <x-button wire:click="$set('open',true)">Pagar</x-button>
    
    <x-modal wire:model="open"> 
        <div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">PAGO</h3>
                                @if($amortizationschedule->days_delayed == 0)
                                    <div class="mt-2">
                                        <x-label value="Fecha" />
                                        <x-input id="payment_date" wire:model.live="payment_date" type="date" class="w-full" />
                                        <x-input-error for="payment_date" />
                                        @if($payment_date=='')
                                            <span style="color:red">Elija una fecha para calcular el total del pago</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <x-label value="Fecha" />
                                        <x-input id="payment_date" wire:model.live="payment_date" type="date" class="w-full" readonly/>
                                        <x-input-error for="payment_date" />
                                        @if($payment_date=='')
                                            <span style="color:red">Elija una fecha para calcular el total del pago</span>
                                        @endif
                                    </div>
                                @endif
                                <div class="mt-2">
                                    <x-label value="No. de Recibo" />
                                    <x-input wire:model="amortizationschedule.receipt_number" type="text" class="w-full" />
                                    <x-input-error for="amortizationschedule.receipt_number" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Capital" />
                                    <x-input type="text" class="w-full" value="Q.{{ number_format($amortizationschedule->capital,2,'.',',') }}" readonly/>
                                </div>
                                <div class="mt-2">
                                    @if($payment_date!='')
                                        @php
                                            $ultimo_pago=$amortizationschedule->credit->amortizacion_schedule()->orderBy('number','desc')->first()->id;
                                            if((($amortizationschedule->days_delayed > 0) && ($ultimo_pago<>$amortizationschedule->id)) or ($amortizationschedule->credit->policy_id>2)){
                                                $amortizationschedule->interest=$amortizationschedule->interest;
                                            } else {
                                                $interes_diario=($amortizationschedule->interest / 30);
                                                $fecha_pago=$amortizationschedule->credit->amortizacion_schedule()->where('status','>',2)->orderBy('id','desc')->first()->payment_date;
                                                $fecha_tabla=$amortizationschedule->credit->amortizacion_schedule()->where('status','>',2)->orderBy('id','desc')->first()->share_date;
                                                if(strtotime($fecha_tabla) <= strtotime($fecha_pago)){
                                                    $date1 = new DateTime(date('Y-m-d',strtotime($payment_date)));
                                                    $date2 = new DateTime(date('Y-m-d',strtotime($fecha_tabla)));
                                                } else {
                                                    $date1 = new DateTime(date('Y-m-d',strtotime($payment_date)));
                                                    $date2 = new DateTime(date('Y-m-d',strtotime($fecha_pago)));
                                                }
                                                $diff = $date1->diff($date2);
                                                $amortizationschedule->interest=($interes_diario * $diff->days);
                                            }
                                        @endphp
                                        @if((($amortizationschedule->days_delayed > 0) && ($ultimo_pago<>$amortizationschedule->id)) or ($amortizationschedule->credit->policy_id>2))
                                            <x-label value="Interés" />
                                        @else
                                            <x-label value="Interés ({{ $diff->days }} días)" />
                                        @endif
                                        <x-input id="interest" type="text" class="w-full" value="Q.{{ number_format($amortizationschedule->interest,2,'.',',') }}" readonly/>
                                    @endif
                                </div>
                                @if($amortizationschedule->days_delayed > 0)
                                    <div class="mt-2 px-4 py-4" style="background-color: red">
                                            <x-label class="text-white" value="Mora ({{ $amortizationschedule->days_delayed}} días de retraso)" />
                                            <x-input type="text" class="w-full" value="Q.{{ number_format(($amortizationschedule->delay),2,'.',',') }}" readonly/>
                                    </div>
                                @endif
                                @php
                                    $cuenta=0;
                                @endphp
                                @if(count($amortizationschedule->credit->partial_payments()->where('amortization_schedule_id',0)->get()) > 0)
                                    @foreach($amortizationschedule->credit->partial_payments()->where('amortization_schedule_id',0)->get() as $partialpayment)
                                        @php
                                            $cuenta=$cuenta+$partialpayment->amount;
                                        @endphp
                                    @endforeach
                                    <div class="mt-2 px-4 py-4" style="background-color: green">
                                            <x-label class="text-white" value="Pagos Parciales" />
                                            <x-input type="text" class="w-full" value="Q.{{ number_format($cuenta,2,'.',',') }}" readonly/>
                                    </div>
                                @endif
                                @php
                                    $partial_cuenta=0;
                                @endphp
                                @if($amortizationschedule->status == 2)
                                    @foreach($amortizationschedule->partialpayments()->get() as $partial)
                                        @php
                                            $partial_cuenta=$partial_cuenta+$partial->total_payment;
                                        @endphp
                                    @endforeach
                                    <div class="mt-2 px-4 py-4" style="background-color: green">
                                            <x-label class="text-white" value="Pagos Parciales" />
                                            <x-input type="text" class="w-full" value="Q.{{ number_format($partial_cuenta,2,'.',',') }}" readonly/>
                                    </div>
                                @endif
                                @if($payment_date!='')
                                    <div class="mt-2">
                                        <b>Total: </b> Q.{{ number_format(($amortizationschedule->capital+$amortizationschedule->interest+$amortizationschedule->delay-$cuenta-$partial_cuenta),2,'.',',') }}
                                    </div>
                                    <div class="mt-2">
                                        <x-label value="Su Pago" />
                                        <x-input id="total_payment" type="text" wire:model.live="total_payment" class="w-full" />
                                        <x-input-error for="total_payment" />
                                    </div>
                                    <div class="mt-2">
                                        @php
                                            $diferencia=(($amortizationschedule->capital+$amortizationschedule->interest+$amortizationschedule->delay-$cuenta-$partial_cuenta)-$total_payment);
                                        @endphp
                                        @if(number_format($diferencia,2,'.',',') < 0)
                                            <span style="color:red">No puede superar el monto del pago!</span>
                                        @else
                                            <span style="color:red"><b>Diferencia: </b> Q.{{ number_format($diferencia,2,'.',',') }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                        <x-secondary-button wire:click="$set('open',false)" >
                            Cancelar
                        </x-secondary-button>
                        @if($payment_date!='')
                        <x-danger-button id="register">
                            Registrar Pago
                        </x-danger-button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    @push('js')
        <script>
            $( "#register" ).on( "click", function() {
                var total = $( "#total_payment" ).val();
                var diference = {{ ($amortizationschedule->capital+$amortizationschedule->interest+$amortizationschedule->delay-$cuenta-$partial_cuenta) }} - total;
                if(Number(diference).toFixed(2) > 0){
                    if({{ $cuenta }} > 0){
                        Swal.fire({
                            icon: "error",
                            title: "¡¡!!...",
                            text: "Tiene un pago parcial y no puede hacer otro de esta forma",
                        });
                    } else if({{ strtotime($amortizationschedule->share_date) }} > {{ strtotime(date('Y-m-d H:i:s')) }} ){
                        Swal.fire({
                            icon: "error",
                            title: "¡¡!!...",
                            text: "No puede hacer un pago parcial si su pago no ha vencido.",
                        });
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "El pago no esta completo, faltan Q."+Number(diference).toFixed(2)+". Está seguro de querer registrarlo?",
                            showDenyButton: false,
                            showCancelButton: true,
                            confirmButtonText: "Guardar",
                            denyButtonText: ""
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Livewire.dispatch('save');
                            }
                        });
                    }
                } else if (Number(diference).toFixed(2) < 0){
                    Swal.fire({
                        icon: "error",
                        title: "¡¡!!...",
                        text: "Su pago supera el monto total del pago, debe abonar la diferencia para el siguiente pago",
                    });
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Está seguro de querer registrarlo?",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "Guardar",
                        denyButtonText: ""
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('save');
                        }
                    });
                }
            });
        </script>
    @endpush
</div>
