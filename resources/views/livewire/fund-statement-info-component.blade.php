<div>
    {{-- Stop trying to control. --}}
    <a wire:click="$set('open',true)" class="cursor-pointer">
        <i class="fa-solid fa-circle-info"></i>
    </a>

    
        <x-modal wire:model="open">
            <div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Detalles</h3>
                                    <div class="mt-2">
                                        <b>Fecha: </b> {{ date('Y-m-d H:i', strtotime($statement->date)) }}
                                    </div>
                                    <div class="mt-2">
                                        <b>Monto: </b> Q.{{ number_format(($statement->credit + $statement->debit),2,'.',',') }}
                                    </div>
                                    @if($statement->type < 7)
                                        @if($statement->type==2)
                                            <div class="mt-2 bg-gray-200 p-2">
                                                <b>Aporte de</b>
                                            </div>
                                            <div class="border-gray-200 border-2 p-2">
                                                <div class="mt-2">
                                                    @if($fundstatementinvestor->investor->type==1)
                                                        <b>Dueño: </b> 
                                                    @else
                                                        <b>Inversor: </b> 
                                                    @endif
                                                    {{ $fundstatementinvestor->investor->dpi }} - {{ $fundstatementinvestor->investor->name }}, {{ $fundstatementinvestor->investor->lastname }}
                                                </div>
                                                <div class="mt-2">
                                                    <b>Recibo: </b> {{ $fundstatementdetail->receipt_number }}
                                                </div>
                                            </div>
                                        @elseif($statement->type==3)
                                            <div class="mt-2 bg-gray-200 p-2">
                                                <b>Aporte General</b>
                                            </div>
                                            <div class="border-gray-200 border-2 p-2">
                                                <div class="mt-2">
                                                    <b>Recibo: </b> {{ $fundstatementdetail->receipt_number }}
                                                </div>
                                            </div>
                                        @elseif($statement->type==4)
                                            <div class="mt-2 bg-gray-200 p-2">
                                                <b>Desembolso a</b>
                                            </div>
                                            <div class="border-gray-200 border-2 p-2">
                                                <div class="mt-2">
                                                    <b>Crédito: </b> {{ $credit->code }}
                                                </div>
                                                <div class="mt-2">
                                                    <b>Cliente: </b> {{ $credit->customer->lastname }}, {{ $credit->customer->name }}
                                                </div>
                                            </div>
                                        @elseif($statement->type==5)
                                            <div class="mt-2 bg-gray-200 p-2">
                                                <b>Abono de</b>
                                            </div>
                                            <div class="border-gray-200 border-2 p-2">
                                                <div class="mt-2">
                                                    <b>Crédito: </b> {{ $payment->credit->code }}
                                                </div>
                                                <div class="mt-2">
                                                    <b>Cliente: </b> {{ $payment->credit->customer->lastname }}, {{ $payment->credit->customer->name }}
                                                </div>
                                                <div class="mt-2">
                                                    <b>Recibo: </b> {{ $fundstatementdetail->receipt_number }}
                                                </div>
                                            </div>
                                        @elseif($statement->type==6)
                                            <div class="mt-2">
                                                <b>Recibo: </b> {{ $fundstatementdetail->receipt_number }}
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <b>Observación: </b> {{ $fundstatementdetail->info }}
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <b>Usuario Registra: </b> {{ $statement->created_by->name }}
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
