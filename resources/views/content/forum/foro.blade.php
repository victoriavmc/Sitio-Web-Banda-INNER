<x-AppLayout>
    <div class="bg-cover min-h-screen bg-center w-full p-10"
        style="background-image: url('{{ asset('img/foro_fondo.jpg') }}')">
        <div class="grid gap-5 justify-center">
            <!-- Buscador -->
            <div class="flex items-center justify-around">
                <div class="w-full max-w-lg bg-white bg-opacity-70 rounded-lg shadow-xl">
                    <form action="{{ route('eventos') }}" method="GET"
                        class="w-full max-w-lg bg-white rounded-lg shadow-xl">
                        <div
                            class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-red-500 focus-within:!ring-2 ring-inset focus-within:!ring-red-500 rounded-md">
                            <svg class="mr-2 h-5 w-5 text-black stroke-black" fill="none" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                class="block w-full appearance-none text-base text-black placeholder:text-black focus:outline-none sm:text-sm sm:leading-6 border-none"
                                placeholder="Buscar publicacion..." name="search" aria-label="Search components"
                                type="text" aria-expanded="false" aria-autocomplete="list"
                                value="{{ request('search') }}" style="caret-color: rgb(107, 114, 128)">
                        </div>
                    </form>

                    {{-- ORDENAR CONTENIDOS  --}}
                    <div class="">
                        <!-- Botón para abrir el menú desplegable -->
                        <button id="sortButton" class="bg-red-500 text-white px-4 py-2 rounded-md focus:outline-none">
                            Ordenar
                        </button>
                        <!-- Menú desplegable -->
                        <div id="dropdownMenu"
                            class="hidden flex flex-col rounded-lg bg-white shadow-sm border border-slate-200 mt-2">
                            <nav class="flex min-w-[240px] flex-col gap-1 p-1.5">
                                <a href="{{ url()->current() }}?orden=1"
                                    class="text-slate-800 flex w-full items-center rounded-md p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100">
                                    Más Nuevo al más Antiguo
                                </a>
                                <a href="{{ url()->current() }}?orden=2"
                                    class="text-slate-800 flex w-full items-center rounded-md p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100">
                                    Más Antiguo al más Nuevo
                                </a>
                                <a href="{{ url()->current() }}?orden=3"
                                    class="text-slate-800 flex w-full items-center rounded-md p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100">
                                    Mayor número de Interacciones
                                </a>
                            </nav>
                        </div>
                    </div>
                    @auth
                        @if (auth()->user()->rol->idrol == 4)
                            <a class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded"
                                href="{{ route('superFan') }}">Crear Publicación</a>
                        @else
                            <a class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded"
                                href="{{ route('verFormularioForo') }}">Crear Publicación</a>
                        @endif
                    @endauth

                </div>
                <div class="flex flex-col gap-8">
                    @foreach ($recuperoPublicaciones as $publicacion)
                        <article>
                            <div class="max-w-4xl px-10 py-5 bg-white rounded-lg shadow-xl">
                                <div class="flex justify-end items-center">
                                    <span
                                        class="text-base text-gray-900 font-normal">{{ $publicacion->fechaSubida }}</span>
                                </div>
                                <div class="">
                                    <a class="text-2xl text-gray-900 font-bold hover:text-gray-600"
                                        href="{{ route('foroUnico', $publicacion->idcontenidos) }}">{{ $publicacion->titulo }}</a>
                                    <p class="mt-2 text-base text-gray-800">{{ $publicacion->descripcion }}</p>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <a class="text-red-500 text-sm font-bold"
                                        href="{{ route('foroUnico', $publicacion->idcontenidos) }}">Leer Mas</a>
                                    <div class="flex items-center">
                                        {{-- VEO LA CANTIDAD DE COMENTARIOS QUE TIENE --}}
                                        <div class=" px-3 py-1 rounded-lg flex space-x-2 flex-row">
                                            <div
                                                class=" text-black cursor-pointer text-center text-md justify-center items-center flex">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 24 24" height="1em" width="1em"
                                                    xmlns="http://www.w3.org/2000/svg" class="text-md">
                                                    <path
                                                        d="M20 2H4c-1.103 0-2 .897-2 2v18l5.333-4H20c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 14H6.667L4 18V4h16v12z">
                                                    </path>
                                                    <circle cx="15" cy="10" r="2"></circle>
                                                    <circle cx="9" cy="10" r="2"></circle>
                                                </svg>
                                                <span
                                                    class="text-md text-black mx-1">{{ $contadorComentarios[$publicacion->idcontenidos]['cuenta'] ?? 0 }}</span>
                                            </div>
                                        </div>
                                        <!-- Recupera la visualización de estrellas para la publicación actual -->
                                        @php
                                            $estrellasVisuales = $recuperoLikes[$publicacion->idcontenidos];
                                        @endphp
                                        <!-- Renderización de estrellas llenas -->
                                        @for ($i = 0; $i < $estrellasVisuales['estrellasLlenas']; $i++)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endfor

                                        <!-- Renderización de media estrella (si aplica) -->
                                        @if ($estrellasVisuales['estrellasMedias'])
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endif

                                        <!-- Renderización de estrellas vacías -->
                                        @for ($i = 0; $i < $estrellasVisuales['estrellasVacias']; $i++)
                                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endfor
                                        <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ $estrellasVisuales['like'] }}</p>
                                        <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">de</p>
                                        <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ $estrellasVisuales['like'] + $estrellasVisuales['dislike'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
        <script>
            // Mostrar/ocultar el menú desplegable
            const sortButton = document.getElementById('sortButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            sortButton.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });
        </script>
</x-AppLayout>
