<div>
    {{-- Stop trying to control. --}}
    <x-button wire:click="$set('open',true)">Desembolsar</x-button>
    
    <x-modal wire:model="open"> 
        <div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">GASTOS ADMINISTRATIVOS</h3>
                                <div class="mt-2">
                                    <x-label value="Fondo" />
                                    <select wire:model.live="fund_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">-----</option>
                                        @foreach($funds as $fund)
                                            <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="fund_id" />
                                </div>
                                <div class="mt-2">
                                @if($fund_id>0)
                                        @php
                                            $this_fund=$fund->where('id',$fund_id)->first();
                                            $this_statement=$this_fund->statements()->orderBy('id','desc')->first();
                                        @endphp
                                        @if($this_statement===NULL)
                                            <span style="color:red;padding:5px">No hay disponible en este fondo para este desembolso</span>
                                            @php
                                                $this->disponible=0;
                                            @endphp
                                        @elseif($this_statement->balance < $credit->initial_credit_capital)
                                            <span style="color:red;padding:5px">No hay disponible en este fondo: Q.{{ number_format($this_statement->balance,2,'.',',') }}</span>
                                            @php
                                                $this->disponible=0;
                                            @endphp
                                        @else
                                            <span style="color:green;padding:5px">Disponible en el Fondo: Q.{{ number_format($this_statement->balance,2,'.',',') }}</span>
                                            @php
                                                $this->disponible=1;
                                            @endphp
                                        @endif
                                        <x-input-error for="disponible" />
                                @endif
                                </div>
                                <div class="mt-2">
                                    <x-label value="Desembolso 5.5%" />
                                    <x-input wire:model.live="desembolso" type="text" class="w-full" />
                                    <x-input-error for="desembolso" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Contrato" />
                                    <x-input wire:model.live="contrato" type="text" class="w-full" />
                                    <x-input-error for="contrato" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Traspaso" />
                                    <x-input wire:model.live="traspaso" type="text" class="w-full" />
                                    <x-input-error for="traspaso" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Tipo de Cheque" />
                                    <select wire:model.live="cheque_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">-----</option>
                                        @foreach($cheques as $cheque)
                                            <option value="{{ $cheque->id }}">{{ $cheque->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="cheque_id" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Número de Cheque" />
                                    <x-input wire:model.live="cheque_no" type="text" class="w-full" />
                                    <x-input-error for="cheque_no" />
                                </div>
                                <div class="mt-2">
                                    <x-label value="Número de Contrato" />
                                    <x-input wire:model.live="contract_no" type="text" class="w-full" />
                                    <x-input-error for="contract_no" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                        <x-secondary-button wire:click="$set('open',false)" >
                            Cancelar
                        </x-secondary-button>
                        <x-danger-button wire:click="save">
                            Desembolsar
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    

</div>
