<x-AppLayout>
    @if (session('alertPublicacion'))
        {{-- Componente de alerta para el exitoso o fallido --}}
        <x-alerts :type="session('alertPublicacion')['type']">
            {{ session('alertPublicacion')['message'] }}
        </x-alerts>
    @endif

    <div class="flex justify-center items-center min-h-screen p-10 flex-col">
        <div>
            <div
                class="flex bg-white space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6 px-4 py-8 dark:border-gray-400 shadow-lg rounded-lg">
                <!-- Quien sube la publicacion -->
                <div class="flex justify-center">
                    <div class="w-full flex justify-center sm:justify-start sm:w-auto">
                        <a href="{{ route('perfil-ajeno', $autor['usuario']->idusuarios) }}">
                            <img class="object-cover w-10 h-10 rounded-full"
                                src="{{ $autor['ruta_imagen'] ? asset(Storage::url($autor['ruta_imagen'])) : asset('img/logo_usuario.png') }}"
                                alt="Imagen del usuario">
                        </a>
                    </div>
                </div>
                <!-- Foro-->
                <div class="max-w-7xl px-4" style="margin: 0">
                    <div class=" w-full sm:w-auto flex gap-4 items-center justify-between sm:items-start">
                        <a href="{{ route('perfil-ajeno', $autor['usuario']->idusuarios) }}">
                            <p class="font-display my-1 text-xl font-semibold text-black" itemprop="author">
                                {{ $autor['usuario']->usuarioUser }} | {{ $autor['usuario']->rol->rol }}
                            </p>
                        </a>
                        <div class="flex gap-4">
                            {{-- Contenedor botón + desplegable --}}
                            <div>
                                {{-- Botón para desplegar --}}
                                <div class="w-full flex justify-end">
                                    <button id="toggleButton-{{ $autor['usuario']->usuarioUser }}"
                                        class="focus:outline-none hover:bg-slate-200  rounded-full transition-colors duration-600 ease-in-out">
                                        <svg class="w-8 h-8 text-gray-800" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                d="M6 12h.01m6 0h.01m5.99 0h.01" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Contenedor de todas las acciones --}}
                                <div id="desplegableAcciones-{{ $autor['usuario']->usuarioUser }}"
                                    class="hidden absolute  mt-2 z-100">
                                    <div class="flex flex-col gap-1 rounded-xl bg-gray-100 py-2">
                                        {{-- Modificar --}}
                                        @if (Auth::user()->idusuarios == $autor['usuario']->idusuarios)
                                            <!-- Botón Modificar -->
                                            <a href="{{ route('editarP', $recuperoPublicacion->idcontenidos) }}"
                                                class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                </svg>
                                                <p class="text-base font-semibold">Modificar</p>
                                            </a>
                                        @endif

                                        {{-- Reportar solo visible si no es tu propia publicacion --}}
                                        @if (Auth::user()->idusuarios != $autor['usuario']->idusuarios)
                                            <div class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                                <button class="flex gap-1 items-center">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
                                                    </svg>
                                                </button>
                                                <p class="text-base font-semibold">Reportar</p>
                                            </div>
                                        @endif

                                        <!-- Botón para eliminar publicacion -->
                                        @if (Auth::user()->idusuarios == $autor['usuario']->idusuarios ||
                                                Auth::user()->rol->idrol == 1 ||
                                                Auth::user()->rol->idrol == 2)
                                            <form class=""
                                                action="{{ route('eliminarContenido', $recuperoPublicacion->idcontenidos) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                    <p class="text-base font-semibold">Eliminar</p>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-3xl mx-auto">
                        <!-- Foro cabecera -->
                        <h1 class="text-3xl text-black font-bold mb-4">{{ $recuperoPublicacion->titulo }}
                        </h1>
                        <p class="text-black text-sm mb-4">Publicado el: {{ $recuperoPublicacion->fechaSubida }}
                        </p>

                        <!-- Foro contenido -->
                        <div class="prose text-black text-base mb-4 prose-sm sm:prose lg:prose-lg xl:prose-xl mx-auto">
                            {{ $recuperoPublicacion->descripcion }}
                        </div>
                        <!-- Imagen Principal -->
                        <div class="flex justify-center">
                            @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 0)
                                <img src="{{ asset(Storage::url($listaPublicacionConImg[0])) }}"
                                    class="w-full mb-4 rounded-xl" alt="ImagenForo">
                            @endif
                        </div>

                        {{-- Esto Muchas Imagenes --}}
                        <!-- Mostrar imágenes adicionales si hay más de una -->
                        @if (is_array($listaPublicacionConImg) && count($listaPublicacionConImg) > 1)
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                @foreach (array_slice($listaPublicacionConImg, 1) as $img)
                                    <div>
                                        <img class="object-cover object-center w-full h-40 max-w-full rounded-lg"
                                            src="{{ asset(Storage::url($img)) }}" alt="Galería">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if (auth()->user()->rol->idrol != 4)
                        <div class="flex space-x-1 justify-end">
                            <div class="flex gap-2">
                                {{-- Like --}}
                                <div
                                    class="bg-green-500 hover:bg-green-700 transition-all duration-300 shadow-lg text-white cursor-pointer px-3 text-center justify-center items-center py-1 rounded-xl flex space-x-2 flex-row">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 1024 1024" class="text-xl" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M885.9 533.7c16.8-22.2 26.1-49.4 26.1-77.7 0-44.9-25.1-87.4-65.5-111.1a67.67 67.67 0 0 0-34.3-9.3H572.4l6-122.9c1.4-29.7-9.1-57.9-29.5-79.4A106.62 106.62 0 0 0 471 99.9c-52 0-98 35-111.8 85.1l-85.9 311H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h601.3c9.2 0 18.2-1.8 26.5-5.4 47.6-20.3 78.3-66.8 78.3-118.4 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7-.2-12.6-2-25.1-5.6-37.1zM184 852V568h81v284h-81zm636.4-353l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 22.4-13.2 42.6-33.6 51.8H329V564.8l99.5-360.5a44.1 44.1 0 0 1 42.2-32.3c7.6 0 15.1 2.2 21.1 6.7 9.9 7.4 15.2 18.6 14.6 30.5l-9.6 198.4h314.4C829 418.5 840 436.9 840 456c0 16.5-7.2 32.1-19.6 43z">
                                        </path>
                                    </svg>
                                    <button>
                                        <span>{{ $actividad['megusta'] }}</span>
                                    </button>
                                </div>
                                {{-- Dislike --}}
                                <div
                                    class="bg-red-500 hover:bg-red-700 shadow-lg transition-all duration-300 shadow-red-600 text-white cursor-pointer px-3 py-1 text-center justify-center items-center rounded-xl flex space-x-2 flex-row">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 1024 1024" class="text-xl" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M885.9 490.3c3.6-12 5.4-24.4 5.4-37 0-28.3-9.3-55.5-26.1-77.7 3.6-12 5.4-24.4 5.4-37 0-28.3-9.3-55.5-26.1-77.7 3.6-12 5.4-24.4 5.4-37 0-51.6-30.7-98.1-78.3-118.4a66.1 66.1 0 0 0-26.5-5.4H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h129.3l85.8 310.8C372.9 889 418.9 924 470.9 924c29.7 0 57.4-11.8 77.9-33.4 20.5-21.5 31-49.7 29.5-79.4l-6-122.9h239.9c12.1 0 23.9-3.2 34.3-9.3 40.4-23.5 65.5-66.1 65.5-111 0-28.3-9.3-55.5-26.1-77.7zM184 456V172h81v284h-81zm627.2 160.4H496.8l9.6 198.4c.6 11.9-4.7 23.1-14.6 30.5-6.1 4.5-13.6 6.8-21.1 6.7a44.28 44.28 0 0 1-42.2-32.3L329 459.2V172h415.4a56.85 56.85 0 0 1 33.6 51.8c0 9.7-2.3 18.9-6.9 27.3l-13.9 25.4 21.9 19a56.76 56.76 0 0 1 19.6 43c0 9.7-2.3 18.9-6.9 27.3l-13.9 25.4 21.9 19a56.76 56.76 0 0 1 19.6 43c0 9.7-2.3 18.9-6.9 27.3l-14 25.5 21.9 19a56.76 56.76 0 0 1 19.6 43c0 19.1-11 37.5-28.8 48.4z">
                                        </path>
                                    </svg>
                                    <span>{{ $actividad['nomegusta'] }}</span>
                                </div>
                                {{-- Reportar --}}
                                {{-- <div
                                    class="bg-black shadow-lg shadow-green-600 text-white cursor-pointer px-3 text-center justify-center items-center py-1 rounded-xl flex space-x-2 flex-row">
                                    <form action="{{ route('reportarActividad', $recuperoPublicacion->idcontenidos) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" id="boton-reportar">
                                            Reportar
                                        </button>
                                    </form>
                                </div> --}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- COMENTARIOS --}}
            <h1 class="my-6 font-display text-3xl font-semibold text-black">Comentarios</h1>

            <!-- Formulario para agregar un nuevo comentario -->
            @if (Auth::user()->rol->idrol != 4)
                <div class="card-body mb-2 bg-white rounded-xl shadow-xl p-4 text-black">
                    <form action="{{ route('crearComentario', $recuperoPublicacion->idcontenidos) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group relative">
                            <img src="{{ $imagen['ruta_imagen'] ? asset(Storage::url($imagen['ruta_imagen'])) : asset('img/logo_usuario.png') }}"
                                alt="Usuario" class="w-10 h-10 mr-4 rounded-full">
                            <textarea name="contenido" id="contenido"
                                class="resize-none focus:outline-none border-x-0 border-t-0 border-b border-gray-400 w-full h-[30px] p-0"
                                rows="3" placeholder="Escribe tu comentario..." onfocus="mostrarBotones()"></textarea>
                        </div>

                        <div id="botones" class="hidden">
                            <div class="flex justify-end gap-4">
                                <button type="button" onclick="ocultarBotones()"
                                    class="bg-gray-500 hover:bg-gray-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-gray-700 hover:border-gray-500 rounded w-max">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                    Comentar
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            @endif

            {{-- Mostrar los comentarios existentes --}}
            <div class="card-body relative">
                @if ($comentarios->isEmpty())
                    <p class="text-center mt-6 text-lg font-semibold">No hay comentarios aún.</p>
                    <p class="text-center mt-2">Se el primer comentario!</p>
                @else
                    @foreach ($comentarios as $comentario)
                        <div class="bg-white rounded-xl">
                            <div
                                class="flex my-4 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6 px-4 py-4 dark:border-gray-400 shadow-lg rounded-lg">
                                {{-- Foto de Perfil --}}
                                <div class="flex justify-center mt-2">
                                    <div class="w-full flex justify-center sm:justify-start sm:w-auto">
                                        <img src="{{ $comentario['imagenAutor'] ? asset(Storage::url($comentario['imagenAutor'])) : asset('img/logo_usuario.png') }}"
                                            alt="Usuario" class="w-10 h-10 rounded-full">

                                    </div>
                                </div>

                                {{-- Contenido Principal --}}
                                <div class="w-full px-4 flex flex-col" style="margin: 0">
                                    {{-- Autor --}}
                                    <div class="w-full sm:w-auto flex justify-between items-end">
                                        <div class="flex items-end gap-1">
                                            <a class="flex items-center"
                                                href="{{ route('perfil-ajeno', $comentario['autor']->idusuarios) }}">
                                                <p class="text-xl font-semibold text-black">
                                                    {{ $comentario['autor']->usuarioUser }} </p>
                                            </a>

                                            <p class="text-xs font-bold mb-[3px] text-gray-500">
                                                {{ $comentario['comentario']->fechaComent }}</p>
                                        </div>

                                        {{-- Contenedor botón + desplegable --}}
                                        <div>
                                            {{-- Botón para desplegar --}}
                                            <div class="w-full flex justify-end">
                                                <button
                                                    id="toggleButton-{{ $comentario['comentario']->idcomentarios }}"
                                                    class="focus:outline-none hover:bg-slate-200  rounded-full transition-colors duration-600 ease-in-out">
                                                    <svg class="w-8 h-8 text-gray-800" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-width="2" d="M6 12h.01m6 0h.01m5.99 0h.01" />
                                                    </svg>
                                                </button>
                                            </div>

                                            {{-- Contenedor de todas las acciones --}}
                                            <div id="desplegableAcciones-{{ $comentario['comentario']->idcomentarios }}"
                                                class="hidden absolute right-4 mt-2 z-100">
                                                <div class="flex flex-col gap-1 rounded-xl bg-gray-100 py-2">
                                                    {{-- Modificar --}}
                                                    @if (Auth::user()->idusuarios == $comentario['autor']->idusuarios)
                                                        <!-- Botón Modificar -->
                                                        <button
                                                            id="boton-modificar-{{ $comentario['comentario']->idcomentarios }}"
                                                            type="button"
                                                            class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="none"
                                                                viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                            </svg>
                                                            <p class="text-base font-semibold">Modificar</p>
                                                        </button>
                                                    @endif

                                                    {{-- Reportar solo visible si no es tu propio comentario --}}
                                                    @if (Auth::user()->idusuarios != $comentario['autor']->idusuarios)
                                                        <div
                                                            class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                                            <button class="flex gap-1 items-center">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
                                                                </svg>
                                                            </button>
                                                            <p class="text-base font-semibold">Reportar</p>
                                                        </div>
                                                    @endif

                                                    <!-- Botón para eliminar comentario -->
                                                    @if (Auth::user()->idusuarios == $comentario['autor']->idusuarios ||
                                                            Auth::user()->rol->idrol == 1 ||
                                                            Auth::user()->rol->idrol == 2)
                                                        <form class=""
                                                            action="{{ route('eliminarComentario', $comentario['comentario']->idcomentarios) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                                </svg>
                                                                <p class="text-base font-semibold">Eliminar</p>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Contenido del comentario --}}
                                    <div class="max-w-3xl">
                                        <p class="text-base mb-2 text-black font-medium break-words">
                                            {{ $comentario['comentario']->descripcion }}
                                        </p>

                                        @if (
                                            !empty($comentario['imagenComentario']) &&
                                                is_array($comentario['imagenComentario']) &&
                                                count($comentario['imagenComentario']) > 0)
                                            <div class="flex justify-center mb-2 border border-gray-200 rounded-lg">
                                                <img src="{{ asset(Storage::url($comentario['imagenComentario'][0])) }}"
                                                    class="rounded-lg max-w-xs" alt="Imagen del comentario">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Formulario Modificar -->
                                    <div id="formularioModificar-{{ $comentario['comentario']->idcomentarios }}"
                                        class="hidden">
                                        @if (Auth::user()->idusuarios == $comentario['autor']->idusuarios)
                                            <div class="card-body text-black border border-gray rounded-md p-3 mb-3">
                                                <form
                                                    action="{{ route('modificarComentario', $comentario['comentario']->idcomentarios) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-3">
                                                        <textarea name="contenido"
                                                            class="resize-none focus:outline-none border-x-0 border-t-0 border-b border-gray-400 w-full h-[30px] p-0"
                                                            rows="3" placeholder="Escribe tu comentario...">{{ old('contenido', $comentario['comentario']->descripcion) }}</textarea>
                                                    </div>

                                                    @if (!empty($comentario['imagenComentario']) && is_array($comentario['imagenComentario']))
                                                        <img src="{{ asset(Storage::url($comentario['imagenComentario'][0])) }}"
                                                            class="mt-2 rounded-lg max-w-xs" alt="Imagen actual">
                                                    @endif

                                                    <div class="flex justify-between">
                                                        <input type="file" name="imagen" accept="image/*">
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                                            Modificar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Likes y dislikes --}}
                                    <div class="flex space-x-1 justify-end">
                                        <div class="flex gap-4">
                                            {{-- Like --}}
                                            <div
                                                class="bg-green-500 hover:bg-green-700 transition-all duration-300 shadow-lg shadow-green-600 text-white cursor-pointer px-3 text-center justify-center items-center py-1 rounded-xl flex space-x-2 flex-row">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 1024 1024" class="text-xl" height="1em"
                                                    width="1em" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M885.9 533.7c16.8-22.2 26.1-49.4 26.1-77.7 0-44.9-25.1-87.4-65.5-111.1a67.67 67.67 0 0 0-34.3-9.3H572.4l6-122.9c1.4-29.7-9.1-57.9-29.5-79.4A106.62 106.62 0 0 0 471 99.9c-52 0-98 35-111.8 85.1l-85.9 311H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h601.3c9.2 0 18.2-1.8 26.5-5.4 47.6-20.3 78.3-66.8 78.3-118.4 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7 0-12.6-1.8-25-5.4-37 16.8-22.2 26.1-49.4 26.1-77.7-.2-12.6-2-25.1-5.6-37.1zM184 852V568h81v284h-81zm636.4-353l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 16.5-7.2 32.2-19.6 43l-21.9 19 13.9 25.4a56.2 56.2 0 0 1 6.9 27.3c0 22.4-13.2 42.6-33.6 51.8H329V564.8l99.5-360.5a44.1 44.1 0 0 1 42.2-32.3c7.6 0 15.1 2.2 21.1 6.7 9.9 7.4 15.2 18.6 14.6 30.5l-9.6 198.4h314.4C829 418.5 840 436.9 840 456c0 16.5-7.2 32.1-19.6 43z">
                                                    </path>
                                                </svg>
                                                <button>
                                                    <span>{{ $actividad['megusta'] }}</span>
                                                </button>
                                            </div>
                                            {{-- Dislike --}}
                                            <div
                                                class="bg-red-500 hover:bg-red-700 shadow-lg transition-all duration-300 shadow-red-600 text-white cursor-pointer px-3 py-1 text-center justify-center items-center rounded-xl flex space-x-2 flex-row">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 1024 1024" class="text-xl" height="1em"
                                                    width="1em" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M885.9 490.3c3.6-12 5.4-24.4 5.4-37 0-28.3-9.3-55.5-26.1-77.7 3.6-12 5.4-24.4 5.4-37 0-28.3-9.3-55.5-26.1-77.7 3.6-12 5.4-24.4 5.4-37 0-51.6-30.7-98.1-78.3-118.4a66.1 66.1 0 0 0-26.5-5.4H144c-17.7 0-32 14.3-32 32v364c0 17.7 14.3 32 32 32h129.3l85.8 310.8C372.9 889 418.9 924 470.9 924c29.7 0 57.4-11.8 77.9-33.4 20.5-21.5 31-49.7 29.5-79.4l-6-122.9h239.9c12.1 0 23.9-3.2 34.3-9.3 40.4-23.5 65.5-66.1 65.5-111 0-28.3-9.3-55.5-26.1-77.7zM184 456V172h81v284h-81zm627.2 160.4H496.8l9.6 198.4c.6 11.9-4.7 23.1-14.6 30.5-6.1 4.5-13.6 6.8-21.1 6.7a44.28 44.28 0 0 1-42.2-32.3L329 459.2V172h415.4a56.85 56.85 0 0 1 33.6 51.8c0 9.7-2.3 18.9-6.9 27.3l-13.9 25.4 21.9 19a56.76 56.76 0 0 1 19.6 43c0 9.7-2.3 18.9-6.9 27.3l-13.9 25.4 21.9 19a56.76 56.76 0 0 1 19.6 43c0 9.7-2.3 18.9-6.9 27.3l-14 25.5 21.9 19a56.76 56.76 0 0 1 19.6 43c0 19.1-11 37.5-28.8 48.4z">
                                                    </path>
                                                </svg>
                                                <span>{{ $actividad['nomegusta'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <script>
        function mostrarBotones() {
            document.getElementById('botones').classList.remove('hidden');
            document.addEventListener('click', ocultarBotonesAlClickFuera);
        }

        function ocultarBotones() {
            document.getElementById('botones').classList.add('hidden');
        }

        // Mostrar formulario modificar al hacer click
        document.querySelectorAll('[id^="boton-modificar-"]').forEach(boton => {
            boton.addEventListener('click', function() {
                const comentarioId = this.id.split('-')[2]; // Extraer el ID del comentario
                const formulario = document.getElementById(`formularioModificar-${comentarioId}`);

                // Ocultar todos los formularios menos el correspondiente
                document.querySelectorAll('[id^="formularioModificar-"]').forEach(form => {
                    if (form !== formulario) {
                        form.classList.add('hidden');
                    }
                });

                // Mostrar/ocultar el formulario correspondiente
                formulario.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('[id^="toggleButton-"]').forEach(button => {
            button.addEventListener('click', function(event) {
                const id = this.id.split('-')[1];
                const acciones = document.getElementById(`desplegableAcciones-${id}`);

                // Cierra todos los desplegables antes de abrir uno nuevo
                document.querySelectorAll('[id^="desplegableAcciones-"]').forEach(
                    otherAcciones => {
                        if (otherAcciones !== acciones) {
                            otherAcciones.classList.add('hidden');
                        }
                    });

                acciones.classList.toggle('hidden');
                event
                    .stopPropagation(); // Evita que el clic en el botón se propague al documento
            });
        });

        // Cierra el desplegable al hacer clic en cualquier otro lugar
        document.addEventListener('click', function(event) {
            // Verifica si el clic fue fuera del botón y del desplegable
            document.querySelectorAll('[id^="desplegableAcciones-"]').forEach(acciones => {
                if (!acciones.classList.contains('hidden') && !acciones.contains(event
                        .target) &&
                    !event.target.matches('[id^="toggleButton-"], svg')) {
                    acciones.classList.add('hidden');
                }
            });
        });
    </script>
</x-AppLayout>
