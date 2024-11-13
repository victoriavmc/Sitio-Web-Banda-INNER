<x-AppLayout>
    <div class="bg-white p-10 min-h-screen bg-cover">
        <div class="text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna 1 -->
                <div
                    class="bg-gray-600 hover:bg-gray-700 transition-all duration-300  text-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-bold">
                        <a class="hover:animate-pulse" href="#album-imagenes">Imágenes Exclusivas</a>
                    </h2>
                </div>
                <!-- Columna 2 -->
                <div
                    class="bg-gray-600 hover:bg-gray-700 transition-all duration-300 text-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-bold">
                        <a class="hover:animate-pulse" href="#album-videos-exclusivos">Videos Exclusivos</a>
                    </h2>
                </div>
                <!-- Columna 3 -->
                <div
                    class="bg-gray-600 hover:bg-gray-700 transition-all duration-300 text-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-bold">
                        <a class="hover:animate-pulse" href="#album-videos-oficiales">Videos Oficiales</a>
                    </h2>
                </div>
            </div>
        </div>

        {{-- Album de Imagenes --}}
        <section id="album-imagenes">
            <div class="mx-auto w-full max-w-7xl px-5 pt-10 md:px-10">
                <a href="#" class="relative flex justify-center items-end">
                    <h2 class="text-center text-3xl font-bold md:text-5xl">Álbum de Imágenes Exclusivas</h2>
                </a>
                @auth
                    @if (Auth::user()->rol->idrol === 1 || Auth::user()->rol->idrol === 2)
                        <!-- Formulario para crear un álbum Imagenes -->
                        <form method="get" action="{{ route('crear-album') }}" class="flex justify-center mt-5">
                            @csrf
                            <input type="hidden" name="accion" value=1>
                            <input type="hidden" name="tipoAlbum" value=3>
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                Crear Álbum
                            </button>
                        </form>
                    @endif
                @endauth
                @if (!$listaAlbumI)
                    <p class=" flex justify-center text-2xl text-center text-black mt-8">No hay álbumes de imagenes
                        todavia</p>
                @else
                    <div class="mx-auto grid justify-items-stretch mt-5 gap-4 md:grid-cols-2 lg:gap-10">
                        @foreach ($listaAlbumI as $album)
                            {{-- Redirecciono a cada album interno --}}
                            <div>
                                <a
                                    href="{{ route('mostrar.de.uno', ['idAlbumEspecifico' => $album['idAlbumEspecifico'], 'tipo' => 2]) }}">
                                    <div class="relative flex h-[300px] items-end">
                                        <div class="relative w-full h-full flex gap-2 justify-end pr-2 z-30">
                                            @auth
                                                @if (Auth::user()->rol->idrol === 1 || Auth::user()->rol->idrol === 2)
                                                    {{-- Modificar album especifico --}}
                                                    <form action="{{ route('crear-album') }}" method="GET">
                                                        @csrf
                                                        <input type="hidden" name="accion" value=2>

                                                        <input type="hidden" name="tipoAlbum" value=3>

                                                        <input type="hidden" name="idAlbumEspecifico"
                                                            value="{{ $album['idAlbumEspecifico'] }}">

                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-400 text-white text-xs font-bold p-1 border-b-4 border-blue-700 hover:border-blue-500 rounded w-max">
                                                            <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    {{-- Boton de borrar --}}
                                                    <form action="{{ route('eliminarAlbumEspecifico') }}"
                                                        id="btnEliminarAlbum" method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="accion" value=3>
                                                        <input type="hidden" name="tipoAlbum" value=3>
                                                        <input type="hidden" name="idAlbumEspecifico"
                                                            value="{{ $album['idAlbumEspecifico'] }}">
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                                            <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                        <!-- Muestra solo la primera imagen -->
                                        <img src="{{ asset(Storage::url($album['medios'][0])) }}"
                                            alt="{{ $album['titulo'] }}"
                                            class="absolute inline-block h-full w-full rounded-lg object-cover" />
                                        <div
                                            class="absolute bottom-5 left-5 flex flex-col justify-center rounded-lg bg-white px-6 py-2">
                                            <p class="text-sm font-medium sm:text-xl">{{ $album['titulo'] }}</p>
                                            <p class="text-sm sm:text-base">{{ $album['fecha'] }}</p>
                                            <p class="text-sm text-red-500 sm:text-sm">Contenido:
                                                {{ $album['cantidadAlbum'] }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- Album de Videos Exclusivos --}}
        <section id="album-videos-exclusivos">
            <div class="mx-auto w-full max-w-7xl px-5 pt-10 md:px-10">
                <a href="#" class="relative flex justify-center items-end">
                    <h2 class="text-center text-3xl font-bold md:text-5xl">Álbum de Videos Exclusivos</h2>
                </a>
                @auth
                    @if (Auth::user()->rol->idrol === 1 || Auth::user()->rol->idrol === 2)
                        <!-- Formulario para crear un álbum musical -->
                        <form method="get" action="{{ route('crear-album') }}" class="flex justify-center mt-5">
                            @csrf
                            <input type="hidden" name="accion" value=1>
                            <input type="hidden" name="tipoAlbum" value=2>
                            <button type="submit"
                                class="mb-4 bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                Crear Álbum
                            </button>
                        </form>
                    @endif
                @endauth
                @if (!$listaAlbumV)
                    <p class=" flex justify-center text-2xl text-center text-black mt-8">No hay álbumes de videos
                        todavia</p>
                @else
                    <div
                        class="mx-auto grid justify-items-stretch gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  lg:gap-10">
                        @foreach ($listaAlbumV as $album)
                            <div class="relative flex w-full items-start justify-center">
                                <div class="relative">
                                    <div class="absolute flex gap-2 w-full h-full justify-end pr-2 pt-2">
                                        @auth
                                            @if (Auth::user()->rol->idrol === 1 || Auth::user()->rol->idrol === 2)
                                                {{-- Modificar album especifico --}}
                                                <form action="{{ route('crear-album') }}" class="z-30" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="accion" value=2>
                                                    <input type="hidden" name="tipoAlbum" value=2>
                                                    <input type="hidden" name="idAlbumEspecifico"
                                                        value="{{ $album['idAlbumEspecifico'] }}">
                                                    <button type="submit"
                                                        class="bg-blue-500 hover:bg-blue-400 text-white text-xs font-bold p-1 border-b-4 border-blue-700 hover:border-blue-500 rounded w-max">
                                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                {{-- Boton de borrar --}}
                                                <form action="{{ route('eliminarAlbumEspecifico') }}" class="z-30"
                                                    id="btnEliminarAlbum" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="accion" value=3>
                                                    <input type="hidden" name="tipoAlbum" value=2>
                                                    <input type="hidden" name="idAlbumEspecifico"
                                                        value="{{ $album['idAlbumEspecifico'] }}">
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                    <a
                                        href="{{ route('mostrar.de.uno', ['idAlbumEspecifico' => $album['idAlbumEspecifico'], 'tipo' => 1]) }}">
                                        @if (!empty($album['medios']))
                                            <video class="flex justify-center max-h-96 w-full rounded-lg object-cover"
                                                muted>
                                                <source src="{{ asset(Storage::url($album['medios'][0])) }}"
                                                    type="video/mp4">
                                                Tu navegador no soporta el elemento de video.
                                            </video>
                                        @endif

                                        <div
                                            class="absolute bottom-5 left-5 flex flex-col justify-center rounded-lg bg-white py-2 px-6">
                                            <p class="text-sm font-medium sm:text-xl">{{ $album['titulo'] }}</p>
                                            <p class="text-sm sm:text-base">{{ $album['fecha'] }}</p>
                                            <p class="text-sm text-red-500 sm:text-sm">Contenido:
                                                {{ $album['cantidadAlbum'] }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        {{-- Album Videos Oficiales --}}
        <section id="album-videos-oficiales">
            <div class="mt-10 md:px-10">
                <div class="flex flex-col gap-5">
                    <h2 class="text-center text-3xl font-bold md:text-5xl">Videos Oficiales</h2>
                    {{-- Botón para actualizar videos --}}
                    @auth
                        @if (auth()->user()->rol->idrol == 1 || auth()->user()->rol->idrol == 2)
                            <div class="text-center mb-5">
                                <form action="{{ route('actualizarYt') }}" method="POST">
                                    @csrf <!-- Asegúrate de incluir el token CSRF -->
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                        Actualizar Videos
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                @if (!$listaYt)
                    <p class=" flex justify-center text-2xl text-center text-black mt-8">No hay videos de
                        youtube</p>
                @else
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                        @foreach ($listaYt as $index => $video)
                            <div class="video-container mb-4 w-full">
                                <!-- Ancho adaptativo -->
                                <iframe src="{{ $video['linkYt'] ?? '#' }}" width="100%" height="200"
                                    frameborder="0" allowfullscreen></iframe>
                                <h1 class="text-lg font-bold mt-2">{{ $video['titulo'] }}</h1>
                                <p class="text-sm text-gray-600">{{ $video['fecha'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-AppLayout>
