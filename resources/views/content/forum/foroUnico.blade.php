<x-AppLayout>
    @if (Auth::check() && Auth::user()->rol)
        <div class="bg-white flex justify-center items-center min-h-[86.5vh] flex-col">
            {{-- Botón para modificar: solo el autor puede modificar --}}
            @if (Auth::user()->idusuarios == $autor['usuario']->idusuarios)
                <a href="{{ route('editarP', $recuperoPublicacion->idcontenidos) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modificar</a>
            @endif

            {{-- Botón para eliminar: el autor o los usuarios con rol 1 o 2 pueden eliminar --}}
            @if (Auth::user()->idusuarios == $autor['usuario']->idusuarios ||
                    Auth::user()->rol->idrol == 1 ||
                    Auth::user()->rol->idrol == 2)
                <form action="{{ route('eliminarContenido', $recuperoPublicacion->idcontenidos) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                </form>
            @endif
            <div>
                <!-- Foro-->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mx-auto">
                        <!-- Foro cabecera -->
                        <div>
                            <h1 class="text-3xl text-black font-bold mt-6 mb-4">{{ $recuperoPublicacion->titulo }}</h1>
                            <p class="text-black text-sm mb-4">Publicado el: {{ $recuperoPublicacion->fechaSubida }}</p>
                        </div>

                        <!-- Foro contenido -->
                        <div class="prose text-black text-base prose-sm sm:prose lg:prose-lg xl:prose-xl mx-auto">
                            {{ $recuperoPublicacion->descripcion }}
                        </div>
                        <!-- Imagen Principal -->
                        <div class="flex justify-center">
                            @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 0)
                                <img src="{{ asset(Storage::url($listaPublicacionConImg[0])) }}" class="max-w-xl mb-8"
                                    alt="ImagenForo">
                            @endif
                        </div>

                        {{-- Esto Muchas Imagenes --}}
                        <!-- Mostrar imágenes adicionales si hay más de una -->
                        @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 1)
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                @foreach (array_slice($listaPublicacionConImg, 1) as $imagen)
                                    <div>
                                        <img class="object-cover object-center w-full h-40 max-w-full rounded-lg"
                                            src="{{ asset(Storage::url($imagen)) }}" alt="Galería">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-row space-x-1">
                    <form action="">
                        {{-- Like --}}
                        <div
                            class="bg-green-500 shadow-lg shadow- shadow-green-600 text-white cursor-pointer px-3 text-center justify-center items-center py-1 rounded-xl flex space-x-2 flex-row">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                                class="text-xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M885.9 533.7c16.8-22.2 26.1-49.4 26.1-77.7 0-44.9-25.1-87.4-65.5-111.1a67.67 67.67 0 0 0-34.3-9.3H572.4l6-122.9c1.4-29.7-9.1-57.9-29.5-79.4A106.62 106.62 0 0 0 471 99.9c-52 0-98 35-111.8 85.1l-85.9 311H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h601.3c9.2 0 18.2-1.8 26.5-5.4 47.6-20.3 78.3-66.8 78.3-118.4 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7-.2-12.6-2-25.1-5.6-37.1zM184 852V568h81v284h-81zm636.4-353l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 22.4-13.2 42.6-33.6 51.8H329V564.8l99.5-360.5a44.1 44.1 0 0 1 42.2-32.3c7.6 0 15.1 2.2 21.1 6.7 9.9 7.4 15.2 18.6 14.6 30.5l-9.6 198.4h314.4C829 418.5 840 436.9 840 456c0 16.5-7.2 32.1-19.6 43z">
                                </path>
                            </svg><button>
                                <span>{{ $actividad['contadorMg'] }}</span>
                            </button>
                        </div>
                        {{-- Dislike --}}
                        <div
                            class="bg-red-500 shadow-lg shadow- shadow-red-600 text-white cursor-pointer px-3 py-1 text-center justify-center items-center rounded-xl flex space-x-2 flex-row">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                                class="text-xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M885.9 490.3c3.6-12 5.4-24.4 5.4-37 0-28.3-9.3-55.5-26.1-77.7 3.6-12 5.4-24.4 5.4-37 0-28.3-9.3-55.5-26.1-77.7 3.6-12 5.4-24.4 5.4-37 0-51.6-30.7-98.1-78.3-118.4a66.1 66.1 0 0 0-26.5-5.4H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h129.3l85.8 310.8C372.9 889 418.9 924 470.9 924c29.7 0 57.4-11.8 77.9-33.4 20.5-21.5 31-49.7 29.5-79.4l-6-122.9h239.9c12.1 0 23.9-3.2 34.3-9.3 40.4-23.5 65.5-66.1 65.5-111 0-28.3-9.3-55.5-26.1-77.7zM184 456V172h81v284h-81zm627.2 160.4H496.8l9.6 198.4c.6 11.9-4.7 23.1-14.6 30.5-6.1 4.5-13.6 6.8-21.1 6.7a44.28 44.28 0 0 1-42.2-32.3L329 459.2V172h415.4a56.85 56.85 0 0 1 33.6 51.8c0 9.7-2.3 18.9-6.9 27.3l-13.9 25.4 21.9 19a56.76 56.76 0 0 1 19.6 43c0 9.7-2.3 18.9-6.9 27.3l-13.9 25.4 21.9 19a56.76 56.76 0 0 1 19.6 43c0 9.7-2.3 18.9-6.9 27.3l-14 25.5 21.9 19a56.76 56.76 0 0 1 19.6 43c0 19.1-11 37.5-28.8 48.4z">
                                </path>
                            </svg>
                            <span>{{ $actividad['contadorNM'] }}</span>
                        </div>
                    </form>
                    {{-- Reportes --}}
                    <div class="container mt-5 text-black">
                        {{-- Reportes --}}
                        <form action="{{ route('reportarActividad', $recuperoPublicacion->idcontenidos) }}"
                            method="POST">
                            @csrf
                            <button type="submit" id="boton-reportar"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
                                Reportar Actividad
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quien sube la publicacion -->
                <div
                    class="w-full max-w-2xl my-4 flex flex-col items-start space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6 px-4 py-8 border-2 border-dashed border-gray-400 dark:border-gray-400 shadow-lg rounded-lg">
                    <a href="{{ route('perfil-ajeno', $autor['usuario']->idusuarios) }}">
                        <span
                            class="text-xs font-medium top-0 left-0 rounded-br-lg rounded-tl-lg px-2 py-1 bg-primary-100 dark:bg-gray-900 dark:text-black border-gray-400 dark:border-gray-400 border-b-2 border-r-2 border-dashed">
                            Usuario
                        </span>
                        <div class="w-full flex justify-center sm:justify-start sm:w-auto">
                            <img class="object-cover w-20 h-20 mt-3 mr-3 rounded-full"
                                src="{{ $autor['ruta_imagen'] ? asset(Storage::url($autor['ruta_imagen'])) : asset('img/logo_usuario.png') }}"
                                alt="Imagen del usuario">
                        </div>
                        <div class="w-full sm:w-auto flex flex-col items-center sm:items-start">
                            <p class="font-display mb-2 text-2xl font-semibold text-black" itemprop="author">
                                {{ $autor['usuario']->usuarioUser }}
                            </p>
                            <div class="mb-4 md:text-lg ">
                                <p class="text-black">{{ $autor['usuario']->rol->rol }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- COMENTARIOS --}}
            <h1 class="mb-4 text-black">Comentarios</h1>

            <!-- Formulario para agregar un nuevo comentario -->
            <div class="card-body text-black">
                <form action="{{ route('crearComentario', $recuperoPublicacion->idcontenidos) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="contenido">Contenido del Comentario:</label>
                        <textarea name="contenido" id="contenido" class="form-control" rows="3" placeholder="Escribe tu comentario..."></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="imagen">Subir Imagen (opcional):</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*" class="form-control">
                    </div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Agregar Comentario
                    </button>
                </form>
            </div>

            {{-- Mostrar los comentarios existentes --}}
            <div class="card-body">
                @if ($comentarios->isEmpty())
                    <p>No hay comentarios aún.</p>
                @else
                    @foreach ($comentarios as $comentario)
                        <div class="space-y-4 mb-4">
                            <div class="flex">
                                <a href="{{ route('perfil-ajeno', $comentario['autor']->idusuarios) }}">
                                    <div class="flex-shrink-0 mr-3">
                                        <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10"
                                            src="{{ $comentario['imagenAutor'] ? asset(Storage::url($comentario['imagenAutor'])) : asset('img/logo_usuario.png') }}"
                                            alt="Usuario">
                                    </div>
                                </a>
                                <div
                                    class="flex-1 border rounded-lg text-black px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                                    <strong>{{ $comentario['autor']->usuarioUser }}</strong>
                                    <span
                                        class="text-xs text-black">{{ $comentario['comentario']->fechaComent }}</span>
                                    <p class="text-sm text-black">{{ $comentario['comentario']->descripcion }}</p>

                                    <!-- Mostrar la imagen del comentario si existe -->
                                    @if (
                                        !empty($comentario['imagenComentario']) &&
                                            is_array($comentario['imagenComentario']) &&
                                            count($comentario['imagenComentario']) > 0)
                                        <img src="{{ asset(Storage::url($comentario['imagenComentario'][0])) }}"
                                            class="mt-2 rounded-lg max-w-xs" alt="Imagen del comentario">
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- MODIFICAR COMENTARIO SOLO MOSTRAR SI TOCA EL BOTON --}}
                        @if (Auth::user()->idusuarios == $comentario['autor']->idusuarios)
                            <div class="card-body text-black">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form
                                    action="{{ route('modificarComentario', $comentario['comentario']->idcomentarios) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label for="contenido">Comentario:</label>
                                        <textarea name="contenido" id="contenido" class="form-control" rows="3"
                                            placeholder="Escribe tu comentario...">{{ old('contenido', $comentario['comentario']->descripcion) }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="imagen">Subir Imagen (opcional):</label>
                                        <input type="file" name="imagen" id="imagen" accept="image/*"
                                            class="form-control">
                                    </div>

                                    <!-- Mostrar la imagen actual -->
                                    @if (!empty($comentario['imagenComentario']) && is_array($comentario['imagenComentario']))
                                        <p>Imagen actual:</p>
                                        <img src="{{ asset(Storage::url($comentario['imagenComentario'][0])) }}"
                                            class="mt-2 rounded-lg max-w-xs" alt="Imagen actual">
                                    @endif
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                        Modificar Comentario
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                            <!-- Botón para eliminar comentario -->
                            <form action="{{ route('eliminarComentario', $comentario['comentario']->idcomentarios) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                                    Eliminar Comentario
                                </button>
                            </form>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    @else
        <script>
            window.location.href = "{{ route('superFan') }}";
        </script>
    @endif
</x-AppLayout>
