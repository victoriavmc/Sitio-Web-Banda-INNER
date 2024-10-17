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
                                            <a href="{{ route('editarP', ['id' => $recuperoPublicacion->idcontenidos, 'tipo' => 3]) }}"
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
                                            <form
                                                action="{{ route('reportarActividad', $recuperoPublicacion->Actividad_idActividad) }}"
                                                method="POST">
                                                @csrf
                                                <button class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300"
                                                    type="submit">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
                                                    </svg>
                                                    <p class="text-base font-semibold">Reportar</p>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Botón para eliminar publicacion -->
                                        @if (Auth::user()->idusuarios == $autor['usuario']->idusuarios ||
                                                Auth::user()->rol->idrol == 1 ||
                                                Auth::user()->rol->idrol == 2)
                                            <form class="btnEliminarContenido"
                                                action="{{ route('eliminarContenido', $recuperoPublicacion->idcontenidos) }}"
                                                method="POST">
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
                                    class="cursor-pointer imagenG imagen-modal w-full mb-4 rounded-xl" alt="ImagenForo">
                            @endif
                        </div>

                        {{-- Esto Muchas Imagenes --}}
                        <!-- Mostrar imágenes adicionales si hay más de una -->
                        @if (is_array($listaPublicacionConImg) && count($listaPublicacionConImg) > 1)
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                @foreach (array_slice($listaPublicacionConImg, 1) as $img)
                                    <div>
                                        <img class="cursor-pointer imagenG imagen-modal object-cover object-center w-full h-40 max-w-full rounded-lg"
                                            src="{{ asset(Storage::url($img)) }}" alt="Galería">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if (auth()->user()->rol->idrol != 4)
                        <div class="flex space-x-1 justify-end">
                            <div class="flex gap-2">
                                {{-- Botón de Like --}}
                                <form
                                    action="{{ route('puntuacion', ['tipo' => 'Like', 'id' => $recuperoPublicacion->Actividad_idActividad]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-xl flex space-x-2 shadow-lg text-white bg-green-500 hover:bg-green-700 transition-all duration-300">
                                        @if (isset($interaccionUsuario) && $interaccionUsuario->megusta)
                                            <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                                            </svg>
                                        @endif

                                        <span>{{ $actividad['megusta'] }}</span>
                                    </button>
                                </form>

                                {{-- Botón de Dislike --}}
                                <form
                                    action="{{ route('puntuacion', ['tipo' => 'Dislike', 'id' => $recuperoPublicacion->Actividad_idActividad]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-xl flex space-x-2 shadow-lg text-white transition-all bg-red-500 hover:bg-red-700 duration-300">

                                        @if (isset($interaccionUsuario) && $interaccionUsuario->nomegusta)
                                            <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.97 14.316H5.004c-.322 0-.64-.08-.925-.232a2.022 2.022 0 0 1-.717-.645 2.108 2.108 0 0 1-.242-1.883l2.36-7.201C5.769 3.54 5.96 3 7.365 3c2.072 0 4.276.678 6.156 1.256.473.145.925.284 1.35.404h.114v9.862a25.485 25.485 0 0 0-4.238 5.514c-.197.376-.516.67-.901.83a1.74 1.74 0 0 1-1.21.048 1.79 1.79 0 0 1-.96-.757 1.867 1.867 0 0 1-.269-1.211l1.562-4.63ZM19.822 14H17V6a2 2 0 1 1 4 0v6.823c0 .65-.527 1.177-1.177 1.177Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M17 13c-.889.086-1.416.543-2.156 1.057a22.322 22.322 0 0 0-3.958 5.084 1.6 1.6 0 0 1-.582.628 1.549 1.549 0 0 1-1.466.087 1.587 1.587 0 0 1-.537-.406 1.666 1.666 0 0 1-.384-1.279l1.389-4.114M17 13h3V6.5A1.5 1.5 0 0 0 18.5 5v0A1.5 1.5 0 0 0 17 6.5V13Zm-6.5 1H5.585c-.286 0-.372-.014-.626-.15a1.797 1.797 0 0 1-.637-.572 1.873 1.873 0 0 1-.215-1.673l2.098-6.4C6.462 4.48 6.632 4 7.88 4c2.302 0 4.79.943 6.67 1.475" />
                                            </svg>
                                        @endif

                                        <span>{{ $actividad['nomegusta'] }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- COMENTARIOS --}}
            <h1 class="my-6 font-display text-3xl font-semibold text-black">Comentarios</h1>

            <!-- Formulario para agregar un nuevo comentario -->
            @if (Auth::user()->rol->idrol != 4)
                <div class="card-body flex mb-2 bg-white rounded-xl shadow-xl p-4 text-black">
                    <img src="{{ $imagen['ruta_imagen'] ? asset(Storage::url($imagen['ruta_imagen'])) : asset('img/logo_usuario.png') }}"
                        alt="Usuario" class="w-10 h-10 rounded-full">
                    <form action="{{ route('crearComentario', $recuperoPublicacion->idcontenidos) }}" method="POST"
                        enctype="multipart/form-data" class="w-full px-4">
                        @csrf
                        <div class="form-group relative mb-2">
                            <textarea name="contenido" id="contenido"
                                class="resize-none focus:outline-none border-x-0 border-t-0 border-b border-gray-400 w-full h-[30px] p-0"
                                rows="3" placeholder="Escribe tu comentario..." onfocus="mostrarBotones()"></textarea>
                        </div>

                        <div id="botones" class="hidden">
                            <div class="flex justify-between">
                                <input class="text-black" type="file" name="imagen" accept="image/*">
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
                                                        <form
                                                            action="{{ route('reportarActividad', $comentario['comentario']->Actividad_idActividad) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button
                                                                class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300"
                                                                type="submit">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
                                                                </svg>
                                                                <p class="text-base font-semibold">Reportar</p>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Botón para eliminar comentario -->
                                                    @if (Auth::user()->idusuarios == $comentario['autor']->idusuarios ||
                                                            Auth::user()->rol->idrol == 1 ||
                                                            Auth::user()->rol->idrol == 2)
                                                        <form class="btnEliminarComentario"
                                                            action="{{ route('eliminarComentario', $comentario['comentario']->idcomentarios) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
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
                                            <div
                                                class="flex justify-center mb-2 border border-gray-200 bg-gray-100 rounded-lg">
                                                <img src="{{ asset(Storage::url($comentario['imagenComentario'][0])) }}"
                                                    class="cursor-pointer imagen-modal rounded-lg h-56 max-w-xl"
                                                    alt="Imagen del comentario">
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
                                                        <div
                                                            class="mb-2 border border-gray-200 bg-gray-100 rounded-lg relative">
                                                            <div
                                                                class="visualizacion-imagen max-w-max mx-auto relative">
                                                                <!-- Botón para eliminar la imagen -->
                                                                <div class="">
                                                                    <button type="button"
                                                                        class="top-2 right-2 absolute bg-red-500 text-white rounded-full hover:bg-red-700 z-20"
                                                                        onclick="eliminarImagenComentario({{ $comentario['comentario']->idcomentarios }})">
                                                                        <svg class="w-5 h-5 text-white"
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            fill="none" viewBox="0 0 24 24">
                                                                            <path stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M6 18 17.94 6M18 18 6.06 6" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <img src="{{ asset(Storage::url($comentario['imagenComentario'][0])) }}"
                                                                    class="cursor-pointer imagen-modal rounded-lg h-56 max-w-xl"
                                                                    alt="Imagen del comentario">

                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Campo oculto para controlar la eliminación de imagen -->
                                                    <input type="hidden" name="imagen_eliminada"
                                                        id="imagenEliminada-{{ $comentario['comentario']->idcomentarios }}"
                                                        value="0">

                                                    <div class="flex justify-between mt-2">
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

                                    {{-- Mostrar los comentarios hijos --}}

                                    {{-- Likes y dislikes --}}
                                    <div class="flex space-x-1 justify-end">
                                        <div class="flex gap-4">
                                            {{-- Like --}}
                                            <form
                                                action="{{ route('puntuacion', ['tipo' => 'Like', 'id' => $comentario['comentario']->Actividad_idActividad]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-500 hover:bg-green-700 transition-all duration-300 shadow-lg text-white cursor-pointer px-3 py-1 rounded-xl flex space-x-2">
                                                    @if (isset($comentario['interaccionUsuario']) && $comentario['interaccionUsuario']->megusta)
                                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                                                        </svg>
                                                    @endif
                                                    <span>{{ $comentario['interaccionComentario']['megusta'] }}</span>
                                                </button>
                                            </form>

                                            {{-- Dislike --}}
                                            <form
                                                action="{{ route('puntuacion', ['tipo' => 'Dislike', 'id' => $comentario['comentario']->Actividad_idActividad]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-700 transition-all duration-300 shadow-lg text-white cursor-pointer px-3 py-1 rounded-xl flex space-x-2">
                                                    @if (isset($comentario['interaccionUsuario']) && $comentario['interaccionUsuario']->nomegusta)
                                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M8.97 14.316H5.004c-.322 0-.64-.08-.925-.232a2.022 2.022 0 0 1-.717-.645 2.108 2.108 0 0 1-.242-1.883l2.36-7.201C5.769 3.54 5.96 3 7.365 3c2.072 0 4.276.678 6.156 1.256.473.145.925.284 1.35.404h.114v9.862a25.485 25.485 0 0 0-4.238 5.514c-.197.376-.516.67-.901.83a1.74 1.74 0 0 1-1.21.048 1.79 1.79 0 0 1-.96-.757 1.867 1.867 0 0 1-.269-1.211l1.562-4.63ZM19.822 14H17V6a2 2 0 1 1 4 0v6.823c0 .65-.527 1.177-1.177 1.177Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M17 13c-.889.086-1.416.543-2.156 1.057a22.322 22.322 0 0 0-3.958 5.084 1.6 1.6 0 0 1-.582.628 1.549 1.549 0 0 1-1.466.087 1.587 1.587 0 0 1-.537-.406 1.666 1.666 0 0 1-.384-1.279l1.389-4.114M17 13h3V6.5A1.5 1.5 0 0 0 18.5 5v0A1.5 1.5 0 0 0 17 6.5V13Zm-6.5 1H5.585c-.286 0-.372-.014-.626-.15a1.797 1.797 0 0 1-.637-.572 1.873 1.873 0 0 1-.215-1.673l2.098-6.4C6.462 4.48 6.632 4 7.88 4c2.302 0 4.79.943 6.67 1.475" />
                                                        </svg>
                                                    @endif
                                                    <span>{{ $comentario['interaccionComentario']['nomegusta'] }}</span>
                                                </button>
                                            </form>
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

    <!-- Contenedor del modal -->
    <div id="modal" class="hidden">
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>

    <script>
        function eliminarImagenComentario(idComentario) {
            const campoImagenEliminada = document.getElementById(`imagenEliminada-${idComentario}`);
            campoImagenEliminada.value = 1;

            // Ocultar la imagen inmediatamente
            const contenedorImagen = document.querySelector(`#formularioModificar-${idComentario} .visualizacion-imagen`);
            if (contenedorImagen) {
                contenedorImagen.style.display = 'none';
            } else {
                console.log("No se pudo encontrar el contenedor de la imagen.");
            }
        }

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
