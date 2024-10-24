<x-Opciones>
    <div class="flex items-center min-h-screen justify-center bg-cover todaPantalla"
        style="background-image: url('{{ asset('img/perfil_fondo.webp') }}')">
        @if (session('alertInicioSesion'))
            <x-alerts :type="session('alertInicioSesion')['type']">
                {{ session('alertInicioSesion')['message'] }}
            </x-alerts>
        @endif

        @if (session('alertCambios'))
            <x-alerts :type="session('alertCambios')['type']">
                {{ session('alertCambios')['message'] }}
            </x-alerts>
        @endif

        @if ($errors->any())
            <x-alerts type="Warning">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alerts>
        @endif

        <div class=" max-h-max bg-white bg-opacity-70 p-6 gap-6">
            <div class="full bg-opacity-70 p-6 gap-6">
                <!-- Contenido principal -->
                <div class="w-full p-4 bg-opacity-60 shadow-md">
                    <h2 class="text-xl text-black font-semibold">Modificar Redes Sociales de
                        @if ($rol == 1)
                            la Banda
                        @else
                            {{ ucwords($nombreUsuario) }}
                        @endif
                    </h2>
                    @if ($rol == 1)
                        <form class="space-y-4" method="POST" action="{{ route('procesar-redes') }}">
                            @csrf
                            <!-- Campo oculto para identificar la acción -->
                            <input type="hidden" name="action_type" id="action_type" value="guardar">

                            <!-- Campo oculto para el id de la red social a eliminar -->
                            <input type="hidden" name="id" id="red_social_id" value="">

                            @foreach ($mostrarLink as $redSocial)
                                @if ($redSocial->idredesSociales)
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <label for="{{ $redSocial->nombreRedSocial }}"
                                                class="block text-base font-medium text-gray-700">
                                                {{ $redSocial->nombreRedSocial }}
                                            </label>

                                            <!-- Botón para eliminar red social -->
                                            <button class="flex items-center eliminar-red-social" type="submit"
                                                onclick="document.getElementById('action_type').value = 'eliminar';
                             document.getElementById('red_social_id').value = '{{ $redSocial->idredesSociales }}';">
                                                <span
                                                    class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white text-base font-bold text-black transition duration-100 hover:bg-red-600 hover:text-gray-900">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="5" height="5" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18 17.94 6M18 18 6.06 6" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>

                                        <!-- Modificar red social -->
                                        <input type="text" id="{{ $redSocial->nombreRedSocial }}"
                                            name="linkRedSocial[{{ $redSocial->idredesSociales }}]"
                                            value="{{ $redSocial->linkRedSocial ?? '' }}"
                                            class="my-2 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                        @error('redes.' . $redSocial->idredesSociales)
                                            <span class="font-bold text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            @endforeach

                            <div class="flex gap-2 mt-2">
                                <!-- Botón para modificar -->
                                <button class="relative" type="submit"
                                    onclick="document.getElementById('action_type').value = 'guardar';">
                                    <span
                                        class="absolute
                                    top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                    <span
                                        class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-blue-400 hover:text-gray-900">Modificar
                                        Red</span>
                                </button>
                        </form>
                        <button class="relative mr-2" type="button" onclick="openModal(this)">
                            <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                            <span
                                class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-green-400 hover:text-gray-900">Agregar
                                Red</span>
                        </button>
                </div>
            @elseif ($rol == 2)
                <h2 class="my-2 text-lg text-black font-semibold">Staff: {{ $especialidad }}
                </h2>
                <form class="space-y-4" action="{{ route('guardar-redes-staff') }}" method="POST">
                    @csrf
                    <label for="{{ $redSocialStaff->nombreRedSocial ?? '' }}"
                        class="block text-sm font-medium text-gray-700">Red social:</label>
                    <input type="url" id="{{ $redSocialStaff->nombreRedSocial ?? '' }}" name="redSocialStaff"
                        value="{{ $redSocialStaff->linkRedSocial ?? '' }}"
                        class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                    @error('redSocialStaff')
                        <span class="font-bold text-red-500">{{ $message }}</span>
                    @enderror
                    <div class="flex gap-4">
                        <button class="relative" type="submit">
                            <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                            <span
                                class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-blue-400 hover:text-gray-900">Modificar
                                Red</span>
                        </button>
                </form>
                <form method="POST" action="{{ route('eliminar-red-social-staff') }}">
                    @csrf
                    <button class="relative" type="submit">
                        <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                        <span
                            class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-red-600 hover:text-gray-900">Eliminar
                            Red Social</span>
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    </div>
    </div>

    {{-- Modal --}}
    <div id="modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto">
        <div class="flex h-screen items-center justify-center">
            <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Agregar Red Social</h3>
                </div>
                <!-- Cuerpo del Modal con el formulario -->
                <div class="mt-2 px-7 py-3">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">
                                Nombre de la red social
                            </label>
                        </div>

                        <div class="mb-4">
                            <input id="nombre" type="text" placeholder="Nombre de la Red Social"
                                name="nombreRedSocial"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"></input>
                        </div>

                        <div class="mb-2">
                            <label for="link" class="block text-gray-700 text-sm font-bold mb-2">
                                Link de la red social
                            </label>
                        </div>

                        <div class="mb-4">
                            <input id="link" type="text" placeholder="Link de la red Social"
                                name="linkRedSocial"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"></input>
                        </div>
                        <!-- Botones -->
                        <div class="flex justify-end">
                            <button type="button"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2"
                                onclick="closeModal()">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = "{{ url('/perfil/agregar-red') }}";

        function openModal(button) {

            const form = document.querySelector('#modal form');

            form.action = `${baseUrl}`;

            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</x-Opciones>
