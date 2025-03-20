<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Arqueo') }}
        </h2>
    </x-slot>
    <x-principal>
        <div class="mt-2 px-6 py-6">
            <x-label value="Fecha" />
            <x-input wire:model.live="date" type="date" class="w-1/2" />
            <x-input-error for="date" />
        </div>
        <div class="flex">
            <div class="px-6 py-6 w-1/2">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Billetes</h3>
                <div class="mt-2 flex">
                    <x-label value="200.00" style="width:75px" />
                    <x-input wire:model.live="b200" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b200*200,2,'.',',') }}" /><br>
                    <x-input-error for="b200" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="100.00" style="width:75px" />
                    <x-input wire:model.live="b100" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b100*100,2,'.',',') }}" /><br>
                    <x-input-error for="b100" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="50.00" style="width:75px" />
                    <x-input wire:model.live="b50" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b50*50,2,'.',',') }}" /><br>
                    <x-input-error for="b50" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="20.00" style="width:75px" />
                    <x-input wire:model.live="b20" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b20*20,2,'.',',') }}" /><br>
                    <x-input-error for="b20" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="10.00" style="width:75px" />
                    <x-input wire:model.live="b10" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b10*10,2,'.',',') }}" /><br>
                    <x-input-error for="b10" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="5.00" style="width:75px" />
                    <x-input wire:model.live="b5" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b5*5,2,'.',',') }}" /><br>
                    <x-input-error for="b5" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="1.00" style="width:75px" />
                    <x-input wire:model.live="b1" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($b1*1,2,'.',',') }}" /><br>
                    <x-input-error for="b1" />
                </div>
                <div class="mt-2 text-right px-6">
                    <b>TOTAL: Q.{{ number_format((($b200*200)+($b100*100)+($b50*50)+($b20*20)+($b10*10)+($b5*5)+$b1),2,'.',',') }}</b>
                </div>
            </div>
            <div class="px-6 py-6 w-1/2">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Monedas</h3>
                <div class="mt-2 flex">
                    <x-label value="1.00" style="width:75px" />
                    <x-input wire:model.live="m1" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($m1*1,2,'.',',') }}" /><br>
                    <x-input-error for="m1" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="0.50" style="width:75px" />
                    <x-input wire:model.live="m05" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($m05*0.5,2,'.',',') }}" /><br>
                    <x-input-error for="m05" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="0.25" style="width:75px" />
                    <x-input wire:model.live="m025" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($m025*0.25,2,'.',',') }}" /><br>
                    <x-input-error for="m025" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="0.10" style="width:75px" />
                    <x-input wire:model.live="m01" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($m01*0.1,2,'.',',') }}" /><br>
                    <x-input-error for="m01" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="0.05" style="width:75px" />
                    <x-input wire:model.live="m005" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($m005*0.05,2,'.',',') }}" /><br>
                    <x-input-error for="m005" />
                </div>
                <div class="mt-2 flex">
                    <x-label value="0.01" style="width:75px" />
                    <x-input wire:model.live="m001" type="text" class="w-1/2 mx-6" />
                    <x-label value="Q. {{ number_format($m001*0.01,2,'.',',') }}" /><br>
                    <x-input-error for="m001" />
                </div>
                <div class="mt-2 text-right px-6">
                    <br><br><b>TOTAL: Q.{{ number_format((($m1)+($m05*0.5)+($m025*0.25)+($m01*0.1)+($m005*0.05)+($m001*0.01)),2,'.',',') }}</b>
                </div>
            </div>
        </div>
        <div class="mt-2 text-right px-6">
            <b>TOTAL EFECTIVO: Q.{{ number_format((($b200*200)+($b100*100)+($b50*50)+($b20*20)+($b10*10)+($b5*5)+$b1+($m1)+($m05*0.5)+($m025*0.25)+($m01*0.1)+($m005*0.05)+($m001*0.01)),2,'.',',') }}</b>
        </div>
        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Cheques</h3>
        <div>
            <div class="w-full flex">
                <div class="w-1/2">
                    <x-input wire:model="number.0" type="text" class="w-full" placeholder="No. Cheque"  />
                    <x-input-error for="number.0" />
                </div>
                <div class="w-1/2">
                    <x-input wire:model.live="amount.0" type="text" class="w-full" placeholder="Monto"  />
                    <x-input-error for="amount.0" />
                </div>
                <div class="mx-2">
                    <x-secondary-button wire:click="add({{$i}})" class="mt-2">
                        <i class="fa-solid fa-plus"></i>
                    </x-secondary-button>
                </div>
            </div>
            @foreach($inputs as $key => $value)
                <div class="w-full flex">
                    <div class="w-1/2">
                        <x-input wire:model="number.{{ $value }}" type="text" class="w-full" placeholder="No. Cheque"  />
                        <x-input-error for="number.{{ $value }}" />
                    </div>
                    <div class="w-1/2">
                        <x-input wire:model.live="amount.{{ $value }}" type="text" class="w-full" placeholder="Monto"  />
                        <x-input-error for="amount.{{ $value }}" />
                    </div>
                    <div class="mx-2">
                        <x-danger-button wire:click="remove({{$key}})" class="mt-2">
                            <i class="fa-solid fa-minus"></i>
                        </x-danger-button>
                    </div>
                </div>
            @endforeach
        </div>
        @php
            $total_cheque=0;
        @endphp
        @if(!empty($amount))
            @foreach ($amount as $key => $value)
                @php
                    $total_cheque=$total_cheque+$this->amount[$key];
                @endphp
            @endforeach
        @endif
        <div class="mt-2 text-right px-6">
            <b>TOTAL CHEQUE: Q.{{ number_format($total_cheque,2,'.',',') }}</b>
        </div>
        <div class="mt-2 text-right px-6">
            <b>TOTAL ARQUEADO: Q.{{ number_format(($total_cheque+($b200*200)+($b100*100)+($b50*50)+($b20*20)+($b10*10)+($b5*5)+$b1+($m1)+($m05*0.5)+($m025*0.25)+($m01*0.1)+($m005*0.05)+($m001*0.01)),2,'.',',') }}</b>
        </div>
        @php
            $amortizations = $this->amortizationschedule::where('total_payment','>',0)
                ->whereBetween('payment_date',[$this->date.' 00:00:00',$this->date.' 23:59:59'])
                ->orderBy('id','desc')
                ->get();
            $informe=0;
        @endphp
        @foreach ($amortizations as $amortization)
            @php
                $informe=$informe+$amortization->total_payment;
            @endphp
        @endforeach
        <div class="mt-2 text-right px-6">
            <b>INFORME DIARIO: Q.{{ number_format($informe,2,'.',',') }}</b>
        </div>
        <div class="mt-2 text-right px-6">
            <b>DIFERENCIA: Q.{{ number_format(($total_cheque+($b200*200)+($b100*100)+($b50*50)+($b20*20)+($b10*10)+($b5*5)+$b1+($m1)+($m05*0.5)+($m025*0.25)+($m01*0.1)+($m005*0.05)+($m001*0.01)-$informe),2,'.',',') }}</b>
        </div>
        <div class="w-full">
            <x-label value="Observación" />
            <x-input wire:model="info" type="text" class="w-full" />
            <x-input-error for="info" />
        </div>
        <div class="mt-6 text-right">
            <x-button wire:click="save()" >
                Guardar
            </x-button>
        </div>
    </x-principal>
</div>
