<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Clientes</title>
        <style>
        body{
            font-size:12px;
        }
        h1{
            text-align: center;
            text-transform: uppercase;
            font-size:16px;
        }
        .borde{
            border:1px solid #000;
            padding:20px;
        }
        table{
            width:100%;
            border-spacing: 5px;
            border-collapse: collapse;
        }
        th{
            text-align:center;
            border-bottom:1px solid #000;
        }
        td{
            text-align:center;
        }
    </style>
    </head>
    <body>
        <center><img src="{{asset('build/assets/img/logo.png')}}" height="50px"/></center>
        <h1>INVERIA PRESTAMOS</h1><br><br>
        <h1>REPORTE DE CLIENTES</h1>
        <h4 style="text-align:center">Fecha y Hora de Impresión: {{ date('d/m/Y H:i') }}</h4>
        <div>
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-2 text-xs text-gray-500">CODIGO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">DPI</th>
                        <th class="px-6 py-2 text-xs text-gray-500">NOMBRE</th>
                        <th class="px-6 py-2 text-xs text-gray-500">TELÉFONO</th>
                        <th class="px-6 py-2 text-xs text-gray-500">EMAIL</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(count($customers))
                        @php
                            $total=0;
                        @endphp
                        @foreach ($customers as $customer)
                            <tr class="border-gray-200 border-b-2">
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->code }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->dpi }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center">{{ $customer->lastname }}, {{ $customer->name }}</td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center"><a class="text-gray-900" href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></td>
                            <td class="px-6 py-4 text-md text-gray-500 text-center"><a class="text-gray-900" href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-sm text-gray-500 text-center text-lg">
                                No existen registros
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>
