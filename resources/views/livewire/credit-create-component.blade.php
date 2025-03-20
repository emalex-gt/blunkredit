<div>
    {{-- Stop trying to control. --}}
    <button class="inline-block px-1 py-1 bg-gray-800 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" wire:click="$set('open',true)"><small><i class="fa-solid fa-circle-plus mr-2"></i>&nbsp;Nuevo Crédito</small></button>
    
        <x-modal wire:model="open">
            <div>
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Nuevo Crédito</h3>
                                    <div class="mt-2">
                                        <h2>Cliente: {{ $customer->code }} - {{ $customer->lastname }}, {{ $customer->name }}</h2>
                                    </div>
                                    <div class="pt-5">
                                        <h2>Expendiente</h3>
                                        <hr/>
                                    </div>
                                    <div class="border px-4 py-5">
                                        <div class="mt-2">
                                            <x-label value="Línea de Crédito" />
                                            <select wire:model.live="credit_line_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="">-----</option>
                                                @foreach($creditlines as $creditline)
                                                    <option value="{{ $creditline->id }}">{{ $creditline->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="credit_line_id" />
                                        </div>
                                        <div class="mt-2">
                                            <x-label value="Garantía" />
                                            <select wire:model.live="guarantee_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="">-----</option>
                                                @foreach($guarantees as $guarantee)
                                                    <option value="{{ $guarantee->id }}">{{ $guarantee->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="guarantee_id" />
                                        </div>
                                        <div class="mt-2">
                                            <x-label value="Expendiente" />
                                            <textarea wire:model.live="file_number" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                            <x-input-error for="file_number" />
                                        </div>
                                    </div>
                                    <div class="pt-5">
                                        <h2>Crédito</h3>
                                        <hr/>
                                    </div>
                                    <div class="border px-4 py-5">
                                        <div class="mt-2">
                                            <x-label value="Tecnología" />
                                            <select wire:model.live="tecnology_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="">-----</option>
                                                @foreach($tecnologies as $tecnology)
                                                    <option value="{{ $tecnology->id }}">{{ $tecnology->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="tecnology_id" />
                                        </div>
                                        <div class="mt-2">
                                            <x-label value="Política" />
                                            <select wire:model.live="policy_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="">-----</option>
                                                @foreach($policies as $policy)
                                                    <option value="{{ $policy->id }}">{{ $policy->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="policy_id" />
                                        </div>
                                        <div class="mt-2">
                                            <x-label value="Plazo" />
                                            <select wire:model.live="time_limit_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="">-----</option>
                                                @foreach($timelimits as $timelimit)
                                                    <option value="{{ $timelimit->id }}">{{ $timelimit->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="time_limit_id" />
                                        </div>
                                        <div class="mt-2">
                                            <x-label value="Interés" />
                                            <select wire:model.live="interest_id" class="shadow appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="">-----</option>
                                                @foreach($interests as $interest)
                                                    <option value="{{ $interest->id }}">{{ $interest->name }}%</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="interest_id" />
                                        </div>
                                        <div class="mt-2">
                                            <x-label value="Capital" />
                                            <x-input wire:model.live="initial_capital" type="text" placeholder="Ingrese el Monto del Capital" class="w-full" />
                                            <x-input-error for="initial_capital" />
                                        </div>
                                    </div>
                                    <div class="pt-5">
                                        <h2>Tabla de Amortización</h3>
                                        <hr/>
                                    </div>
                                    <div>
                                        <x-danger-button wire:click="enviarInfo" class="mt-4 mb-4">
                                            Ver Tabla
                                        </x-danger-button>
                                        @livewire('amortization-preview-component',[
                                                'customer' => $customer,
                                                'policy_id' => $policy_id
                                                ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 text-right">
                            <x-secondary-button wire:click="$set('open',false)" >
                                Cancelar
                            </x-secondary-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    

</div>
