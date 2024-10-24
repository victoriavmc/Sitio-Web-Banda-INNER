<x-AppLayout>
    <div class="min-h-screen m-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Orden
                        de Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° de
                        Factura</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de
                        Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado de
                        Pago
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metodo de
                        Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comprador
                        Nombre y
                        Apellido</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo
                        del
                        Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($comprobantes as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['idordenpago'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['factura'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['diaPago'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['estadoPago'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['metodoPago'] }}</td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{$item['precio']}}</td> --}}
                        <td class="px-6 py-4 whitespace-nowrap">precio</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $item['nombreComprador'] . ' ' . $item['apellidoComprador'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">correo</td>
                        <td class="px-6 py-4 whitespace-nowrap">usuario</td>
                        <td class="px-6 py-4 whitespace-nowrap"> Descargar Comprobante / Ver comprobante</td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</x-AppLayout>
