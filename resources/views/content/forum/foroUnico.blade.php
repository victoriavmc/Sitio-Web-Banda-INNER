<x-AppLayout>
    <div class="bg-white flex justify-center items-center h-[86.5vh] flex-col">
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
                    <!-- Imagen/es -->
                    <div class="flex justify-center">
                        @if (!empty($listaPublicacionConImg))
                            @foreach ($listaPublicacionConImg as $rutaImagen)
                                <img src="{{ asset(Storage::url($rutaImagen)) }}" class="max-w-xl mb-8" alt="ImagenForo">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-row space-x-1">

                <div
                    class="bg-green-500 shadow-lg shadow- shadow-green-600 text-white cursor-pointer px-3 text-center justify-center items-center py-1 rounded-xl flex space-x-2 flex-row">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                        class="text-xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M885.9 533.7c16.8-22.2 26.1-49.4 26.1-77.7 0-44.9-25.1-87.4-65.5-111.1a67.67 67.67 0 0 0-34.3-9.3H572.4l6-122.9c1.4-29.7-9.1-57.9-29.5-79.4A106.62 106.62 0 0 0 471 99.9c-52 0-98 35-111.8 85.1l-85.9 311H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h601.3c9.2 0 18.2-1.8 26.5-5.4 47.6-20.3 78.3-66.8 78.3-118.4 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7-.2-12.6-2-25.1-5.6-37.1zM184 852V568h81v284h-81zm636.4-353l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 22.4-13.2 42.6-33.6 51.8H329V564.8l99.5-360.5a44.1 44.1 0 0 1 42.2-32.3c7.6 0 15.1 2.2 21.1 6.7 9.9 7.4 15.2 18.6 14.6 30.5l-9.6 198.4h314.4C829 418.5 840 436.9 840 456c0 16.5-7.2 32.1-19.6 43z">
                        </path>
                    </svg>
                    <span>{{ $actividad['contadorMg'] }}</span>
                </div>
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
                <div>
                    REPORT (ALERTA ESTA SEGURO?)
                </div>
            </div>

            <!-- Quien sube la publicacion -->
            <div
                class="w-full max-w-2xl my-4 flex flex-col items-start space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6 px-4 py-8 border-2 border-dashed border-gray-400 dark:border-gray-400 shadow-lg rounded-lg">
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
            </div>
        </div>
        {{-- COMENTARIOS --}}
        <div class="antialiased mx-auto max-w-screen-sm">
            <h2 class="mb-4 text-lg font-semibold text-black">Comentarios</h2>
            @if ($comentarios->isNotEmpty())
                @foreach ($comentarios as $comentario)
                    <div class="space-y-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10"
                                    src="{{ $comentario['imagenAutor'] ? asset(Storage::url($comentario['imagenAutor'])) : asset('img/logo_usuario.png') }}"
                                    alt="Usuario">
                            </div>
                            <div class="flex-1 border rounded-lg text-black px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                                <strong>{{ $comentario['autor']->usuarioUser }}</strong> <!-- Nombre de autor -->
                                <span class="text-xs text-black">{{ $comentario['comentario']->fechaComent }}</span>
                                <!-- Fecha del comentario -->
                                <p class="text-sm text-black">
                                    {{ $comentario['comentario']->descripcion }} <!-- Descripción del comentario -->
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</x-AppLayout>