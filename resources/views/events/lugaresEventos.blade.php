<x-AppLayout>
    @if (session('alertBorrar'))
        <x-alerts :type="session('alertBorrar')['type']">
            {{ session('alertBorrar')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertModificar'))
        <x-alerts :type="session('alertModificar')['type']">
            {{ session('alertModificar')['message'] }}
        </x-alerts>
    @endif

    <div class="min-h-screen p-10">
        <div class="mb-10">
            <h1 class="text-center text-4xl">Lugares y ubicaciones cargadas</h1>
        </div>

        <form action="{{ route('lugares-cargados') }}" method="GET"
            class="w-full mx-auto mb-10 max-w-lg bg-white rounded-lg shadow-xl">
            <div
                class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-red-500 focus-within:!ring-2 ring-inset focus-within:!ring-red-500 rounded-md">
                <svg class="mr-2 h-5 w-5 text-black stroke-black" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    class="block w-full appearance-none text-base text-black placeholder:text-black focus:outline-none sm:text-sm sm:leading-6 border-none"
                    placeholder="Buscar lugares y ubicaciones..." name="search" aria-label="Search components"
                    type="text" aria-expanded="false" aria-autocomplete="list" value="{{ request('search') }}"
                    style="caret-color: rgb(107, 114, 128)">
            </div>
        </form>

        <div class="grid grid-cols-2 gap-10 max-w-max mx-auto">
            <nav class="flex min-w-[240px] flex-col gap-1 p-1.5 rounded-xl bg-white shadow-xl max-h-[300px]">
                <h1 class="text-center text-3xl mb-2">Lugares</h1>
                <div class="overflow-y-auto">
                    @foreach ($lugares as $lugar)
                        <div
                            class="text-black flex justify-between gap-5 w-full items-center rounded-md p-2 pl-3 transition-all hover:bg-slate-200 focus:bg-slate-300 active:bg-slate-300">
                            <p>{{ $lugar->nombreLugar . ', ' . $lugar->localidad . ', ' . $lugar->calle . ' ' . $lugar->numero }}
                            </p>
                            <div class="grid grid-cols-2 place-items-center">
                                <!-- Botón para abrir modal de modificar lugar -->
                                <button type="button"
                                    onclick="openLugarModal('{{ $lugar->idlugarLocal }}', '{{ $lugar->nombreLugar }}', '{{ $lugar->localidad }}', '{{ $lugar->calle }}', '{{ $lugar->numero }}')"
                                    class="rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-black hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300">
                                    <svg class="w-5 h-5 text-black" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <form action="{{ route('eliminar-lugar', $lugar->idlugarLocal) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-black hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </nav>
            <nav class="flex min-w-[240px] flex-col gap-1 p-1.5 rounded-xl bg-white shadow-xl max-h-[300px]">
                <h1 class="text-center text-3xl mb-2">Ubicaciones</h1>
                <div class="overflow-y-auto">
                    @foreach ($ubicaciones as $ubicacion)
                        <div
                            class="text-black flex justify-between gap-5 w-full items-center rounded-md p-2 pl-3 transition-all hover:bg-slate-200 focus:bg-slate-300 active:bg-slate-300">
                            <p>{{ $ubicacion->provinciaLugar . ', ' . $ubicacion->paisLugar }}</p>
                            <div class="grid grid-cols-2 place-items-center">
                                <!-- Botón para abrir modal de modificar ubicación -->
                                <button
                                    onclick="openModal('modalUbicacion', { 
                                    idubicacionShow: '{{ $ubicacion->idubicacionShow }}', 
                                    provinciaLugar: '{{ $ubicacion->provinciaLugar }}', 
                                    paisLugar: '{{ $ubicacion->paisLugar }}' 
                                })"
                                    type="button"
                                    class="rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-black hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300">
                                    <svg class="w-5 h-5 text-black" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Botón para eliminar ubicación -->
                                <form action="{{ route('eliminar-ubicacion', $ubicacion->idubicacionShow) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-black hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </nav>
        </div>
    </div>

    <!-- Modal para modificar lugar -->
    <div id="modalLugar" class="hidden">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-2xl font-semibold mb-4">Modificar Lugar</h2>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre del lugar</label>
                        <input type="text" name="nombreLugar" id="lugar" value="{{ old('nombreLugar') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('nombreLugar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Localidad</label>
                        <input type="text" name="localidad" id="localidad" value="{{ old('localidad') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('localidad')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Calle</label>
                        <input type="text" name="calle" id="calle" value="{{ old('calle') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('calle')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Número</label>
                        <input type="text" name="numero" id="numero" value="{{ old('numero') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('numero')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('modalLugar')"
                            class="px-4 py-2 bg-gray-400 text-white rounded-md">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal para modificar ubicación -->
    <div id="modalUbicacion" class="hidden">
        <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg max-w-md w-full">
                <h2 class="text-xl font-semibold mb-4">Modificar Ubicación</h2>
                <form id="formModificarUbicacion" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="provinciaLugar" class="block text-sm font-medium text-gray-700">Provincia</label>
                        <input type="text" id="provinciaLugar" name="provinciaLugar"
                            value="{{ old('provinciaLugar') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('provinciaLugar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="paisLugar" class="block text-sm font-medium text-gray-700">País</label>
                        <input type="text" id="paisLugar" name="paisLugar" value="{{ old('paisLugar') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('paisLugar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="button" onclick="closeModal('modalUbicacion')"
                            class="mr-2 bg-gray-300 text-black px-4 py-2 rounded-md">Cancelar</button>
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function openLugarModal(id, nombre, localidad, calle, numero) {
            // Colocar los valores en los campos del modal
            document.getElementById('lugar').value = nombre;
            document.getElementById('localidad').value = localidad;
            document.getElementById('calle').value = calle;
            document.getElementById('numero').value = numero;

            // Actualizar la acción del formulario con la ID correcta
            document.querySelector('#modalLugar form').action = '{{ route('modificar-lugar', ['id' => '__id__']) }}'
                .replace('__id__', id);

            // Mostrar el modal
            document.getElementById('modalLugar').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openModal(modalId, ubicacion = null) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');

            if (ubicacion) {
                // Rellenar el formulario con los datos de la ubicación
                document.getElementById('provinciaLugar').value = ubicacion.provinciaLugar;
                document.getElementById('paisLugar').value = ubicacion.paisLugar;

                // Actualizar la acción del formulario con la ruta adecuada
                document.getElementById('formModificarUbicacion').action =
                    '{{ route('modificar-ubicacion', ['id' => '__id__']) }}'.replace('__id__', ubicacion.idubicacionShow);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }
    </script>
</x-AppLayout>
