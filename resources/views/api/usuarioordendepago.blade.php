<x-Opciones>
    <div class="min-h-screen px-5">
        <h1 class="text-center text-4xl mt-10 mb-5 font-medium">Lista de Comprobantes</h1>

        <div class="w-full flex justify-end">
            <a href="{{ route('descargar.excel') }}">
                <button type="button"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                        <path fill="#20744a" fill-rule="evenodd"
                            d="M28.781 4.405h-10.13V2.018L2 4.588v22.527l16.651 2.868v-3.538h10.13A1.16 1.16 0 0 0 30 25.349V5.5a1.16 1.16 0 0 0-1.219-1.095m.16 21.126H18.617l-.017-1.889h2.487v-2.2h-2.506l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2h10.411Z" />
                        <path fill="#20744a"
                            d="M22.487 7.439h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323z" />
                        <path fill="#fff" fill-rule="evenodd"
                            d="m6.347 10.673l2.146-.123l1.349 3.709l1.594-3.862l2.146-.123l-2.606 5.266l2.606 5.279l-2.269-.153l-1.532-4.024l-1.533 3.871l-2.085-.184l2.422-4.663z" />
                    </svg>
                    <p class="ml-2">Descargar Excel</p>
                </button>
            </a>
        </div>

        <!-- Contenedor para desplazamiento horizontal -->
        <div class="container mx-auto overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Orden de Pago
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            N° de Factura
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha de Pago
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado de Pago
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Método de Pago
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo de Venta
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Comprador Nombre y Apellido
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Correo del Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->precio->tipoServicio }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $item['nombreComprador'] . ' ' . $item['apellidoComprador'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $item->usuario->datosPersonales->nombreDP . ' ' . $item->usuario->datosPersonales->apellidoDP }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->usuario->correoElectronicoUser }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('mercadopago.comprobante', $item['idordenpago']) }}" target="_blank">
                                    <button class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path fill="black"
                                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                        </svg>
                                        <span>Descargar Comprobante</span>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Enlaces de paginación -->
            <div class="mt-4">
                {{ $comprobantes->links() }}
            </div>
        </div>
    </div>
</x-Opciones>
