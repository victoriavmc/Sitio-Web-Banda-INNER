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
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->precio->precio }}</td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $item['nombreComprador'] . ' ' . $item['apellidoComprador'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->usuario->correoElectronicoUser }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->usuario->usuarioUser }}</td>


                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="">
                                <button class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="black"
                                            d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                    </svg>
                                    <span>Descargar Comprobante</span>
                                </button>
                            </a>
                            <a href=""">
                                <button class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="black" fill-rule="evenodd"
                                            d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Ver Comprobante</span>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</x-AppLayout>
