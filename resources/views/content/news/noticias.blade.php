<x-AppLayout>
    <div class="min-h-screen bg-cover bg-center w-full p-10"
        style="background-image: url('{{ asset('img/noticias_fondo.png') }}')">
        <div class="flex flex-col gap-4 p-8">
            @auth
                @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                    <a href="{{ route('verFormularioNoticia') }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-max">Crear Noticia</a>
                @endif
            @endauth

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
                </div>
            </div>

            <ul class="grid grid-cols-1 lg:grid-cols-3 gap-y-10 gap-x-6 items-start">
                @foreach ($recuperoNoticias as $noticia)
                    <div class='bg-white opacity-95 rounded-lg p-4 flex'>
                        <div class="flex flex-col sm:flex-row xl:flex-col items-start">
                            <div class="order-1 xl:ml-0 flex flex-col">
                                <div class="flex justify-center">
                                    <!-- Enlace en la imagen -->
                                    <a href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                        @if ($noticia->imagenes && count($noticia->imagenes) > 0)
                                            <img src="{{ asset(Storage::url($noticia->imagenes[0])) }}"
                                                alt="ImagenPrincipal"
                                                class="mb-6 shadow-md rounded-lg bg-slate-50 w-full h-full max-h-96">
                                        @else
                                            <img src="{{ asset('img/logo_inner_negro.png') }}" alt="ImagenPrincipal"
                                                class="mb-6 shadow-md rounded-lg bg-slate-50">
                                        @endif
                                    </a>
                                </div>
                                <div>
                                    <p class="text-black text-sm mb-4">Publicado el:
                                        {{ $noticia->fechaSubida }}</p>

                                    <!-- Enlace en el título -->
                                    <a href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                        <h1 class="mb-1 text-slate-900 font-semibold">
                                            <span
                                                class="mb-1 block text-lg leading-6 text-red-500">{{ $noticia->titulo }}</span>
                                        </h1>
                                    </a>
                                    <div class="mt-3 prose prose-slate prose-sm text-base text-slate-600">
                                        <p>{{ $noticia->descripcion }}</p>
                                    </div>
                                    <!-- Botón "Leer Más" -->
                                    <a class="group inline-flex items-center h-9 rounded-full text-sm font-semibold whitespace-nowrap px-3 focus:outline-none focus:ring-2 bg-red-500 text-white hover:bg-red-700 hover:text-white focus:ring-slate-700 mt-6"
                                        href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                        Leer Más
                                        <svg class="overflow-visible ml-3 text-slate-300 group-hover:text-slate-400"
                                            width="3" height="6" viewBox="0 0 3 6" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M0 0L3 3L0 6"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
</x-AppLayout>
