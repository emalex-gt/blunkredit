<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arqueo de Caja '.date("d/m/Y",strtotime($date))) }}
        </h2>
    </x-slot>
    <x-principal>

        <div class="px-6 py-4 flex">
            <div class="flex-1">
                Fecha: <x-input type="date" wire:model.live="date" />
            </div>
            <div class="flex-1 text-right">
                <a href="/print/reporte/arqueo/{{ $date }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a href="/export/reporte/arqueo/{{ $date }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 px-4">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
            </div>
        </div>
        @if($arqueo!=NULL)
        <center>
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">FECHA: {{ date("d/m/Y",strtotime($date)) }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">BILLETES</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">200.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b200,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b200*200),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">100.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b100,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b100*100),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">50.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b50,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b50*50),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">20.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b20,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b20*20),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">10.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b10,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b10*10),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">5.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b200,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b200*200),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">1.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->b1,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->b1*1),2,'.',',') }}</td>
                </tr>
            </tbody>
            <thead class="bg-gray-200">
                @php
                    $total_billetes=($arqueo->b200*200)+($arqueo->b100*100)+($arqueo->b50*50)+($arqueo->b20*20)+($arqueo->b10*10)+($arqueo->b5*5)+$arqueo->b1;
                @endphp
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-right" colspan="2">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($total_billetes,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </center>
        <br><br>
        <center>
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">MONEDAS</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">1.00</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m1,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m1*1),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.50</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m05,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m05*0.5),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.25</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m025,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m025*0.25),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.10</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m01,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m01*0.1),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.05</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m005,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m005*0.05),2,'.',',') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">0.01</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->m001,0,'.',',') }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($arqueo->m001*0.01),2,'.',',') }}</td>
                </tr>
            </tbody>
            <thead class="bg-gray-200">
                @php
                    $total_billetes=($arqueo->b200*200)+($arqueo->b100*100)+($arqueo->b50*50)+($arqueo->b20*20)+($arqueo->b10*10)+($arqueo->b5*5)+$arqueo->b1;
                @endphp
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-right" colspan="2">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->total_efectivo-$total_billetes,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </center>
        <br><br>
        <center>
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">DOCUMENTOS</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">No</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">No Cheque</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">Monto</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @php
                    $i=1;
                @endphp
                @if(count($cheques)>0)
                    @foreach($cheques as $cheque)
                        <tr>
                            <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ $i }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ $cheque->number }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format(($cheque->amount),2,'.',',') }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @else
                    <tr>
                        <td class="px-6 py-2 text-xs text-gray-500 text-center" colspan="3">No existen documentos</td>
                    </tr>
                @endif
            </tbody>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-right" colspan="2">TOTAL</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->total_cheque,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </center>
        <br><br>
        <center>
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">TOTAL ARQUEADO</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->total_arqueado,2,'.',',') }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">INFORME DIARIO</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->informe_diario,2,'.',',') }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">DIFERENCIA</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ number_format($arqueo->diferencia,2,'.',',') }}</th>
                </tr>
            </thead>
        </table>
        </center>
        <br><br>
        <center>
        <table>
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-center">{{ $arqueo->info }}</th>
                </tr>
            </thead>
        </table>
        </center>
        @endif
    </x-principal>
</div>
