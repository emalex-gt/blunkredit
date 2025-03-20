<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crédito No. ') }}{{ $credit->code }}
        </h2>
    </x-slot>
    <x-principal>
            <table class="w-full">
                <tr>
                <td class="px-4" style="vertical-align: top;">
                    <div class="justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h2 class="text-base font-semibold leading-6 text-gray-900">Datos del Cliente</h2>
                                        <hr/>
                                        <div class="mt-2">
                                            <b>Código:</b> {{ $credit->customer->code }}<br>
                                            <b>Nombre:</b> {{ $credit->customer->lastname }}, {{ $credit->customer->name }}<br>
                                            <b>DPI:</b> {{ $credit->customer->dpi }}<br>
                                            <b>Dirección:</b> {{ $credit->customer->address }}<br>
                                            <b>Email:</b> <a href="mailto:{{ $credit->customer->email }}">{{ $credit->customer->email }}</a><br>
                                            <b>Teléfono:</b> <a href="tel:{{ $credit->customer->phone }}">{{ $credit->customer->phone }}</a><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-4" style="vertical-align: top;">
                    <div class="justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h2 class="text-base font-semibold leading-6 text-gray-900">Datos del Crédito</h2>
                                        <hr/>
                                        <div class="mt-2">
                                            <b>Estado:</b>
                                            @switch($credit->status)
                                                @case(1)
                                                    <span class="px-1 py-1 rounded" style="background-color:yellow">Registrado</span>
                                                    @break
                                                @case(2)
                                                    <span class="px-1 py-1 rounded text-white" style="background-color:orange">Autorizado</span>
                                                    @break
                                                @case(3)
                                                    <span class="px-1 py-1 rounded text-white" style="background-color:green">Activo</span>
                                                    @break
                                                @case(4)
                                                    <span class="px-1 py-1 rounded text-white" style="background-color:red">Finalizado</span>
                                                    @break
                                            @endswitch
                                            <br>
                                            <b>Tecnología:</b> {{ $credit->tecnology->name }}<br>
                                            <b>Política:</b> {{ $credit->policy->name }}<br>
                                            <b>Plazo:</b> {{ $credit->time_limit->name }} meses<br>
                                            <b>Interés:</b> {{ $credit->interest->name }}%<br>
                                            <b>Capital:</b> Q.{{ number_format($credit->initial_credit_capital,2,'.',',') }}<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-4" style="vertical-align: top;">
                    <div class="justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h2 class="text-base font-semibold leading-6 text-gray-900">Datos del Expediente</h2>
                                        <hr/>
                                        <div class="mt-2">
                                            @if($credit->status>2)
                                                <b>Fondo:</b> {{ $credit->fund->name }}<br>
                                            @endif
                                            <b>Línea de Crédito:</b> {{ $credit->credit_line->name }}<br>
                                            <b>Garantía:</b> {{ $credit->guarantee->name }}<br>
                                            <b>Expediente:</b> {{ $credit->file_number }}<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                @if($credit->status>2)
                    <tr>
                        <td class="px-4" style="vertical-align: top;">
                            <div class="justify-center p-4 text-center sm:items-center sm:p-0 mt-4">
                                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                        <div>
                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                <h2 class="text-base font-semibold leading-6 text-gray-900">Gastos Administrativos</h2>
                                                <hr/>
                                                <div class="mt-2">
                                                    @foreach($credit->administrative_expenses as $administrative_expense)
                                                        <b>
                                                            @switch($administrative_expense->type)
                                                                @case(1)
                                                                    Desembolso
                                                                    @break
                                                                @case(2)
                                                                    Contrato
                                                                    @break
                                                                @case(3)
                                                                    Traspaso
                                                                    @break
                                                            @endswitch
                                                        </b> Q.{{ number_format($administrative_expense->amount,2,'.',',') }}<br>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($credit->status > 2 && $credit->retroactive==0)
                                @can('expend-credit')
                                    <div class="py-4 text-right">
                                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('imprimir-cheque',$credit->id) }}">
                                            Imprimir Cheque
                                        </a>
                                    </div>
                                @endcan
                            @endif
                        </td>
                        <td class="px-4" style="vertical-align: top;">
                            <div class="justify-center p-4 text-center sm:items-center sm:p-0 mt-4">
                                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                        <div>
                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                <h2 class="text-base font-semibold leading-6 text-gray-900">Estado Actual</h2>
                                                <hr/>
                                                <div class="mt-2">
                                                    @if($credit->policy_id==1)
                                                        <b>Cuota:</b> Q.{{ number_format($credit->share,2,'.',',') }}<br>
                                                    @endif
                                                    <b>Capital Pendiente:</b> Q.{{ number_format($credit->pending_credit_capital,2,'.',',') }}<br>
                                                    <hr/>
                                                    <b>Capital Pagado:</b> Q.{{ number_format($credit->amortized_credit_capital,2,'.',',') }}<br>
                                                    <b>Interés Pagado:</b> Q.{{ number_format($credit->interest_paid,2,'.',',') }}<br>
                                                    <b>Mora Pagada:</b> Q.{{ number_format($credit->delay_paid,2,'.',',') }}<br>
                                                    <b>Total Pagado:</b> Q.{{ number_format($credit->total_paid,2,'.',',') }}<br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4" style="vertical-align: top;">
                            <div class="justify-center p-4 text-center sm:items-center sm:p-0 mt-4">
                                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                        <div>
                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                <h2 class="text-base font-semibold leading-6 text-gray-900">Otros Datos</h2>
                                                <hr/>
                                                <div class="mt-2">
                                                    <b>Registrado:</b> {{ $credit->created_by->name }} - {{ date('d/m/Y H:i',strtotime($credit->created_at) )}}<br>
                                                    <b>Autorizado:</b> {{ $credit->authorized_by->name }} - {{ date('d/m/Y H:i',strtotime($credit->authorized_at) )}}<br>
                                                    <b>Desembolsado:</b> {{ $credit->expended_by->name }} - {{ date('d/m/Y H:i',strtotime($credit->expended_at) )}}<br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('report-datos')
                                <div class="py-4 text-right">
                                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('regla-modificada',$credit->id) }}">
                                            Regla Modificada
                                    </a>
                                    <a target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('regla-modificada-word',$credit->id) }}">
                                            <i class="fa-solid fa-file-word"></i>
                                    </a><br><br>
                                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('regla-general',$credit->id) }}">
                                            Regla Original
                                    </a>
                                    <a target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('regla-general-word',$credit->id) }}">
                                            <i class="fa-solid fa-file-word"></i>
                                    </a>
                                </div>
                            @endcan
                        </td>
                    </tr>
                @endif
                </tr>
            </table>
            @if($credit->retroactive==0 || ($credit->retroactive==1 && $credit->status==3))
            <div class="justify-center p-4 text-center sm:items-center sm:p-0 mt-4 px-4">
                <div class="overflow-auto rounded-lg bg-white text-left shadow-xl sm:my-8 sm:w-full">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h2 class="text-base font-semibold leading-6 text-gray-900">Tabla de Amortizaciones</h2>
                                <hr/>
                                <div class="mt-2">
                                    <table class="w-full">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th class="px-6 py-2 text-center border">No.</th>
                                                <th class="px-6 py-2 text-center border">Fecha</th>
                                                <th class="px-6 py-2 text-center border">Cuota Capital</th>
                                                <th class="px-6 py-2 text-center border">Interes</th>
                                                @if($credit->status == 3)
                                                    <th class="px-6 py-2 text-center border">Mora</th>
                                                @endif
                                                <th class="px-6 py-2 text-center border">Total</th>
                                                <th class="px-6 py-2 text-center border">Saldo Capital</th>
                                                @if($credit->status == 3)
                                                    <th class="px-6 py-2 text-center border">Estado</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr>
                                                @if($credit->status == 3)
                                                    <td class="border px-6 py-2" colspan="6"></td>
                                                @else
                                                    <td class="border px-6 py-2" colspan="5"></td>
                                                @endif
                                                <td class="border px-6 py-2 text-right">
                                                    {{ number_format($credit->initial_credit_capital,2,'.',',') }}
                                                </td>
                                                @if($credit->status==3)
                                                <td class="border px-6 py-2 text-right">
                                                        @can('collect-credit')
                                                            @if($credit->amortizacion_schedule()->where('total_payment',0)->count()>0)
                                                                @php
                                                                    $date1 = new DateTime(date('Y-m-d'));
                                                                    $date2 = new DateTime(date('Y-m-d',strtotime($credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->share_date)));
                                                                    $diff = $date1->diff($date2);
                                                                @endphp
                                                                @if(!count($credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->prepayment))
                                                                    @if(($diff->days < 31) or ($credit->amortizacion_schedule()->where('total_payment',0)->orderBy('id','asc')->first()->days_delayed > 0))
                                                                        @livewire('partial-payment-component',['credit'=>$credit],key($credit->id))
                                                                    @endif
                                                                @endif
                                                                @foreach($credit->partial_payments()->where('amortization_schedule_id',0)->get() as $partialpayment)
                                                                    <span class="px-1 py-1 rounded text-white" style="background-color:green"><small>#{{ $partialpayment->id }} - Q.{{ number_format($partialpayment->amount,2,'.',',') }}</small></span>
                                                                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-parcial',$partialpayment->id) }}">
                                                                        <i class="fa-solid fa-print"></i>
                                                                    </a><br>
                                                                @endforeach
                                                            @endif
                                                        @endcan
                                                </td>
                                                @endif
                                            </tr>
                                            @php
                                                $pad=0;
                                            @endphp
                                            @foreach($credit->amortizacion_schedule as $table)
                                                    <tr>
                                                    <td class="border px-6 py-2">
                                                        {{ $table->number }}
                                                    </td>
                                                    <td class="border px-6 py-2">
                                                        {{ date('d/m/Y',strtotime($table->share_date)) }}
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        {{ number_format($table->capital,2,'.',',') }}
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        {{ number_format($table->interest,2,'.',',') }}
                                                    </td>
                                                    @if($credit->status == 3)
                                                        <td class="border px-6 py-2 text-right">
                                                            {{ number_format($table->delay,2,'.',',') }}
                                                        </td>
                                                    @endif
                                                    <td class="border px-6 py-2 text-right">
                                                        @if($table->total_payment==0)
                                                            {{ number_format(($table->total + $table->delay),2,'.',',') }}
                                                        @else
                                                            {{ number_format($table->total_payment,2,'.',',') }}
                                                        @endif
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        {{ number_format($table->capital_balance,2,'.',',') }}
                                                    </td>
                                                    @if($credit->status == 3)
                                                        <td class="border px-6 py-2 text-right">
                                                            @if($table->status < 3 && $pad==0 && !count($table->prepayment))
                                                                @if($table->days_delayed > 0)
                                                                    <span class="px-1 py-1 rounded text-white" style="background-color:red">En Mora</span>
                                                                @endif
                                                                @can('collect-credit')
                                                                    @php
                                                                        $date1 = new DateTime(date('Y-m-d'));
                                                                        $date2 = new DateTime(date('Y-m-d',strtotime($table->share_date)));
                                                                        $diff = $date1->diff($date2);
                                                                    @endphp
                                                                    @if($diff->days > 30)
                                                                        @if($table->days_delayed == 0)
                                                                            @livewire('prepayment-component',['amortizationschedule'=>$table],key($table->id))
                                                                        @else
                                                                            @livewire('amortization-component',['amortizationschedule'=>$table],key($table->id))
                                                                        @endif
                                                                    @else
                                                                        @livewire('amortization-component',['amortizationschedule'=>$table],key($table->id))
                                                                    
                                                                    @endif
                                                                    @php
                                                                        $pad=1;
                                                                    @endphp
                                                                @endcan
                                                            @elseif(count($table->prepayment))
                                                                <span class="px-1 py-1 rounded text-white" style="background-color:green">Pago Adelantado</span>
                                                                &nbsp;
                                                                <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-adelanto',$table->prepayment->first()->id) }}">
                                                                    <i class="fa-solid fa-print"></i>
                                                                </a>
                                                            @elseif($table->total_payment>0)
                                                                <span class="px-1 py-1 rounded text-white" style="background-color:green">Pagado</span>
                                                                @if($table->days_delayed > 0)
                                                                    <span class="px-1 py-1 rounded text-white" style="background-color:red">Con Mora</span>
                                                                @endif
                                                                &nbsp;
                                                                @if($table->status==4)
                                                                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-recibo',$table->id) }}">
                                                                        <i class="fa-solid fa-print"></i>
                                                                    </a>
                                                                @elseif($table->status==3)
                                                                    <br><br>
                                                                    @foreach($table->partialpayments as $partial)
                                                                        <span class="px-1 py-1 rounded text-white" style="background-color:green">RPP #{{ $partial->id }}</span>
                                                                        <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-recibo-partial',$partial->id) }}">
                                                                            <i class="fa-solid fa-print"></i>
                                                                        </a>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                            @if($table->status==2)
                                                                <br><br>
                                                                @foreach($table->partialpayments as $partial)
                                                                    <span class="px-1 py-1 rounded text-white" style="background-color:green">RPP #{{ $partial->id }}</span>
                                                                    <a target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4" href="{{ route('print-recibo-partial',$partial->id) }}">
                                                                        <i class="fa-solid fa-print"></i>
                                                                    </a>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 mt-3 text-right sm:ml-4 sm:mt-0 sm:text-right">
                @if($credit->status == 1)
                    @can('authorize-credit')
                        <x-button wire:click="authoriz">
                            Autorizar
                        </x-button>
                    @endcan
                @endif
                @if($credit->status == 2)
                    @can('expend-credit')
                        @livewire('credit-expend-component',['credit'=>$credit],key($credit->id))
                    @endcan
                @endif
            </div>
            @else
            <form method="post" action="{{ route('save-retroactive') }}">
            @csrf
            <div class="justify-center p-4 text-center sm:items-center sm:p-0 mt-4 px-4">
                <div class="overflow-auto rounded-lg bg-white text-left shadow-xl sm:my-8 sm:w-full">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left" style="overflow:auto">
                                <h2 class="text-base font-semibold leading-6 text-gray-900">Tabla de Amortizaciones</h2>
                                <hr/>
                                <div class="mt-2">
                                    <table class="w-full">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th class="px-6 py-2 text-center border">No.</th>
                                                <th class="px-6 py-2 text-center border">Fecha</th>
                                                <th class="px-6 py-2 text-center border">No. Recibo</th>
                                                <th class="px-6 py-2 text-center border">Cuota Capital</th>
                                                <th class="px-6 py-2 text-center border">Interes</th>
                                                <th class="px-6 py-2 text-center border">Días de Mora</th>
                                                <th class="px-6 py-2 text-center border">Mora</th>
                                                <th class="px-6 py-2 text-center border">Total Pago</th>
                                                <th class="px-6 py-2 text-center border">Saldo Capital</th>
                                                <th class="px-6 py-2 text-center border">Fecha Pago</th>
                                                <th class="px-6 py-2 text-center border">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach($credit->amortizacion_schedule as $table)
                                                <tr>
                                                    <td class="border px-6 py-2">
                                                        {{ $table->number }}
                                                    </td>
                                                    <td class="border px-6 py-2">
                                                        <input name="share_date[{{ $table->id }}]" value="{{ date('Y-m-d',strtotime($table->share_date)) }}" type="date" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        <input name="receipt_number[{{ $table->id }}]" style="width:75px" value="" type="text" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        <input name="capital[{{ $table->id }}]" style="width:125px" value="{{ number_format($table->capital,2,'.','') }}" type="text" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        <input name="interest[{{ $table->id }}]"  value="{{ number_format($table->interest,2,'.','') }}" type="text" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        <input name="days_delayed[{{ $table->id }}]" style="width:75px" value="0" type="text" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        <input name="delay[{{ $table->id }}]" style="width:125px" value="{{ number_format($table->delay,2,'.','') }}" type="text" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        <input name="total_payment[{{ $table->id }}]" style="width:125px" value="{{ number_format($table->total,2,'.','') }}" type="text" />
                                                    </td>
                                                    <td class="border px-6 py-2 text-right">
                                                        {{ number_format($table->capital_balance,2,'.',',') }}
                                                    </td>
                                                    <td class="border px-6 py-2">
                                                        <input name="payment_date[{{ $table->id }}]" value="{{ date('Y-m-d',strtotime($table->share_date)) }}" type="date" />
                                                    </td>
                                                    <td class="border px-6 py-2">
                                                        <select name="status[{{ $table->id }}]" >
                                                            <option value="0">No Pagada</option>
                                                            <option value="1">Pagada</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 mt-3 text-right sm:ml-4 sm:mt-0 sm:text-right">
                <input type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" value="Guardar" />
            </div>
            </form>
            @endif
    </x-principal>
</div>
