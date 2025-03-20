<div>
    {{-- Stop trying to control. --}}
    <button wire:click="$set('open',true)" class="inline-block px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"><i class="fa-solid fa-circle-plus mr-2"></i>&nbsp;Nuevo</button>
    
        <x-modal wire:model="open">
            <div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Nuevo Gasto</h3>
                                    <div class="mt-2">
                                        <x-label value="Cantidad" />
                                        <x-input wire:model.live="amount" type="text" placeholder="Ingrese la cantidad" class="w-full" />
                                        <x-input-error for="amount" />
                                    </div>
                                    <div class="mt-2">
                                        <x-label value="Tipo" />
                                        <select wire:model.defer="expense_type" class="w-full" >
                                            <option value="">----</option>
                                            @foreach($expenses_types as $expense_type)
                                                <option value="{{ $expense_type->id }}">{{ $expense_type->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="expense_type" />
                                    </div>
                                    <div class="mt-2">
                                        <x-label value="Fondo de Origen de los Fondos" />
                                        <select wire:model.live="fund_id" class="w-full" >
                                            <option value="">----</option>
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
                                                @elseif($this_statement->balance < $amount)
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
                                        <x-label value="Observación" />
                                        <x-input wire:model.defer="info" type="text" placeholder="Ingrese la observación" class="w-full" />
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
