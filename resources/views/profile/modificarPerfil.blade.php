<x-opciones>
    <div class="flex justify-center items-center bg-cover min-h-screen"
        style="background-image: url('{{ asset('img/perfil_fondo.jpg') }}')">
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
        <div class="p-10">
            <div class="flex bg-white bg-opacity-70 rounded-xl justify-center p-6 gap-6">
                <!-- Contenido principal: Dividido en columnas 2 y 3 -->
                <div class="flex-1  grid grid-cols-2 gap-6">
                    <!-- Columna 2 -->
                    <div class=" p-4 bg-opacity-60 shadow-md flex flex-col space-y-6">
                        <!-- Fila 1: Edita Información de la Cuenta -->
                        <div class="space-y-4">
                            <h2 class="text-xl text-black font-semibold">Edita Información de la Cuenta</h2>
                            <form class="space-y-4" method="POST" action="{{ route('editar-datos') }}">
                                @csrf
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" value="{{ $datos->nombreDP }}"
                                        class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                    @error('nombre')
                                        <span class="font-bold text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="apellido"
                                        class="block text-sm font-medium text-gray-700">Apellido</label>
                                    <input type="text" name="apellido" id="apellido"
                                        value="{{ $datos->apellidoDP }}"
                                        class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                    @error('apellido')
                                        <span class="font-bold text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="fecha-nacimiento" class="block text-sm font-medium text-gray-700">Fecha
                                        de
                                        Nacimiento</label>
                                    <input type="date" name="fechaNacimiento" id="fecha-nacimiento"
                                        value="{{ $datos->fechaNacimiento }}"
                                        class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                </div>
                                <div>
                                    <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                                    <select id="country-select" name="paisNacimiento"
                                        class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm">
                                        <option value="{{ $pais->idPaisNacimiento }}" selected>
                                            {{ $pais->nombrePN }}
                                        </option>
                                        @foreach ($paises as $pais)
                                            <option value="{{ $pais->idPaisNacimiento }}">{{ $pais->nombrePN }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="confirmar-contrasena"
                                        class="block text-sm font-medium text-gray-700">Confirmar
                                        con la Contraseña</label>
                                    <input type="password" name="confirmarContraseña" id="confirmar-contrasena"
                                        class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                    @error('confirmarContraseña')
                                        <span class="font-bold text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="relative" href="#" type="submit">
                                    <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                    <span
                                        class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-blue-400 hover:text-gray-900">Guardar
                                        Cambios</span>
                                </button>

                            </form>
                        </div>
                        <!-- Fila 1: Subir Imagen -->
                        <div class="space-y-4">
                            <h2 class="text-xl text-black font-semibold">Sube una Imagen de Usuario</h2>
                            <form class="space-y-4" method="POST" action="{{ route('cambiar-imagen') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <label for="imagen-usuario" class="block text-sm font-medium text-black">Imagen
                                    (tamaño recomendado para ícono)</label>
                                <div class="relative flex h-10 w-full min-w-[200px] max-w-[26rem]">
                                    <input id="file-upload" type="file" name="imagen" class="peer hidden"
                                        accept="image/*" required onchange="actualizarNombreArchivo()" />
                                    <label for="file-upload"
                                        class="absolute right-1 top-1 z-10 select-none rounded bg-red-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white transition-all hover:shadow-lg hover:bg-red-600 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85]">
                                        Subir Imagen
                                    </label>
                                    <div class="relative flex-1">
                                        <input type="text" id="nombre-archivo" readonly
                                            class="relative peer h-full w-full rounded-[7px] border border-blue-gray-200 bg-transparent px-3 py-2.5 pr-20 font-sans text-sm font-normal text-black outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-red-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                            placeholder="Ningún archivo seleccionado" required />
                                        <label
                                            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-red-500 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-red-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:!border-red-500 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                        </label>
                                    </div>
                                </div>
                                @error('imagen')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                                <div class="display flex justify-around items-center">
                                    <button class="relative" href="#" type="submit">
                                        <span
                                            class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                        <span
                                            class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-blue-400 hover:text-gray-900">Confirmar
                                            Imagen</span>
                                    </button>

                            </form>
                            <form action="{{ route('eliminar-imagen') }}" method="POST">
                                @csrf
                                <button class="relative" type="submit">
                                    <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                    <span
                                        class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-red-400 hover:text-gray-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em"
                                            viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Columna 3 -->
                <div class=" bg-opacity-50 p-4 shadow-md flex flex-col space-y-6">
                    <!-- Fila 2: Edita Contraseña -->
                    <div class="space-y-4">
                        <h2 class="text-xl text-black font-semibold">Editar Contraseña</h2>
                        <form class="space-y-4" method="POST" action="{{ route('editar-contrasenia') }}">
                            @csrf
                            <div>
                                <label for="contrasena-vieja"
                                    class="block text-sm font-medium text-gray-700">Contraseña
                                    Actual</label>
                                <input type="password" name="contraseñaActual" id="contrasena-vieja"
                                    class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                @error('contraseñaActual')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="contrasena-nueva"
                                    class="block text-sm font-medium text-gray-700">Contraseña
                                    Nueva</label>
                                <input type="password" name="nuevaContraseña" id="contrasena-nueva"
                                    class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                @error('nuevaContraseña')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="confirmar-contrasena-nueva"
                                    class="block text-sm font-medium text-gray-700">Confirmar Contraseña
                                    Nueva</label>
                                <input type="password" name="nuevaContraseña_confirmation"
                                    id="confirmar-contrasena-nueva"
                                    class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                @error('nuevaContraseña_confirmation')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="relative" href="#" type="submit">
                                <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                <span
                                    class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-blue-400 hover:text-gray-900">Guardar
                                    Cambios</span>
                            </button>
                        </form>
                    </div>

                    <!-- Fila 2: Cambiar Correo -->
                    <div class="space-y-4">
                        <h2 class="text-xl text-black font-semibold">Cambiar Correo</h2>
                        <form class="space-y-4" method="POST" action="{{ route('editar-correo') }}">
                            @csrf
                            <div>
                                <label for="correo-viejo" class="block text-sm font-medium text-gray-700">Correo
                                    Actual</label>
                                <input type="email" id="correo-viejo" name="correoActual"
                                    value="{{ $email }}"
                                    class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                @error('correoActual')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="correo-nuevo" class="block text-sm font-medium text-gray-700">Correo
                                    Nuevo</label>
                                <input type="email" id="correo-nuevo" name="correoNuevo"
                                    class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                @error('correoNuevo')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="contrasena-cambiar-correo"
                                    class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input type="password" id="contrasena-cambiar-correo" name="password"
                                    class="mt-1 text-gray-700 block w-full border p-1 border-gray-400 rounded-md shadow-sm" />
                                @error('passwordCorreo')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="relative" href="#" type="submit">
                                <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                <span
                                    class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-blue-400 hover:text-gray-900">Guardar
                                    Cambios</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function actualizarNombreArchivo() {
            const fileInput = document.getElementById('file-upload');
            const nombreArchivo = document.getElementById('nombre-archivo');

            // Si hay un archivo seleccionado, se muestra el nombre
            if (fileInput.files.length > 0) {
                nombreArchivo.value = fileInput.files[0].name;
            } else {
                nombreArchivo.value = 'Ningún archivo seleccionado';
            }
        }
    </script>
</x-opciones>
