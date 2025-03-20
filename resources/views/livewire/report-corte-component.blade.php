<div>
    {{-- Stop trying to control. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reporte de Corte de Caja') }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                Desde: <x-input type="date" wire:model.live="desde" />
            </div>
            <div class="flex-1">
                Hasta: <x-input type="date" wire:model.live="hasta" />
            </div>
            <div class="flex-1">
                Fondo: <select wire:model.live="fondo">
                            <option value="">--Todos--</option>
                            @foreach($funds as $fund)
                                <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                            @endforeach
                        </select>
            </div>
            <div class="flex-1 text-right">
                <a href="/print/reporte/corte-caja/{{ $desde }}/{{ $hasta }}/{{ $fondo }}" target="_blank" class="inline-flex items-center justify-center px-4 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white strtoupper tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/corte-caja/{{ $desde }}/{{ $hasta }}/{{ $fondo }}" target="_blank" class="inline-flex items-center justify-center px-4 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white strtoupper tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>
        @php
            $i=0;
            $ii=1;
            $date='';
            $fon='';
            $total_fecha=0;
            $total_fecha_fondo=0;
            $total=0;
        @endphp
        @foreach($statements as $statement)
            @php
                $detail=$fund_statement_detail->where('fund_statement_id',$statement->id)->first();
            @endphp
            @if($i==0)
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">FECHA: {{ date('d/m/Y',strtotime($statement->date)) }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">{{ strtoupper($statement->fund->name) }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500">NO.</th>
                        <th class="px-6 py-1 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-1 text-xs text-gray-500">DESCRIPCION</th>
                        <th class="px-6 py-1 text-xs text-gray-500">CANTIDAD</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            @endif
            @if($date!='' && $date!=date('Y-m-d',strtotime($statement->date)))
                </tbody>
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500 text-right">TOTAL</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha_fondo,2,'.',',') }}</th>
                    </tr>
                    @php
                        $total_fecha_fondo=0;
                    @endphp
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500 text-right">TOTAL {{ date('d/m/Y',strtotime($date)) }}</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha,2,'.',',') }}</th>
                    </tr>
                    @php
                        $total_fecha=0;
                        $new_date=1;
                    @endphp
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4"></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">FECHA: {{ date('d/m/Y',strtotime($statement->date)) }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            @else
                @php
                    $new_date=0;
                @endphp
            @endif
            @if($new_date==1 || ($fon!='' && $fon!=$statement->fund->id))
                </tbody>
                <thead class="bg-gray-200">
                    @if($new_date==0)
                        <tr>
                            <th class="px-6 py-1 text-xs text-gray-500"></th>
                            <th class="px-6 py-1 text-xs text-gray-500"></th>
                            <th class="px-6 py-1 text-xs text-gray-500 text-right">TOTAL</th>
                            <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha_fondo,2,'.',',') }}</th>
                        </tr>
                        @php
                            $total_fecha_fondo=0;
                        @endphp
                    @endif
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500 text-center" colspan="4">{{ strtoupper($statement->fund->name) }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500">NO.</th>
                        <th class="px-6 py-1 text-xs text-gray-500">FECHA</th>
                        <th class="px-6 py-1 text-xs text-gray-500">DESCRIPCION</th>
                        <th class="px-6 py-1 text-xs text-gray-500">CANTIDAD</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            @endif
                    <tr class="border-gray-200 border-b-2" wire:key="statement-{{ $statement->id }}">
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ $ii }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ $statement->date }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ $detail->info }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center">{{ number_format($statement->credit,2,'.',',') }}</td>
                    </tr>
            @php
                $ii++;
                $total_fecha=$total_fecha+$statement->credit;
                $total_fecha_fondo=$total_fecha_fondo+$statement->credit;
                $total=$total+$statement->credit;
                $date=date('Y-m-d',strtotime($statement->date));
                $fon=$statement->fund->id;
                $i++;
            @endphp
        @endforeach
                </tbody>
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500 text-right">TOTAL {{ date('d/m/Y',strtotime($date)) }}</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total_fecha,2,'.',',') }}</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500"></th>
                        <th class="px-6 py-1 text-xs text-gray-500 text-right">TOTAL</th>
                        <th class="px-6 py-1 text-xs text-gray-500">{{ number_format($total,2,'.',',') }}</th>
                    </tr>
                </thead>
            </table>
    </x-principal>
</div>
