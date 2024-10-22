<x-AppLayout>
    <div class="bg-white p-10 min-h-screen bg-cover">
        <div class="text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna 1 -->
                <div class="bg-gray-600 p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-bold">
                        <a class="hover:animate-pulse" href="#album-imagenes">Imágenes Exclusivas</a>
                    </h2>
                </div>
                <!-- Columna 2 -->
                <div class="bg-gray-600 p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-bold">
                        <a class="hover:animate-pulse" href="#album-videos-exclusivos">Videos Exclusivos</a>
                    </h2>
                </div>
                <!-- Columna 3 -->
                <div class="bg-gray-600 p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-bold">
                        <a class="hover:animate-pulse" href="#album-videos-oficiales">Videos Oficiales</a>
                    </h2>
                </div>
            </div>
        </div>

        {{-- Album de Imagenes --}}
        <section id="album-imagenes">
            <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
                <a href="#" class="relative flex h-[300px] items-end">
                    <h2 class="text-center text-3xl font-bold md:text-5xl">Álbum de Imágenes Exclusivas</h2>
                </a>
                @auth
                    @if (Auth::user()->rol->idrol === 1)
                        <!-- Formulario para crear un álbum Imagenes -->
                        <form method="get" action="{{ route('crear-album') }}">
                            @csrf
                            <input type="hidden" name="accion" value=1>
                            <input type="hidden" name="tipoAlbum" value=3>
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                Crear Álbum
                            </button>
                        </form>
                    @endif
                @endauth
                @if (!$listaAlbumI)
                    <p class=" flex justify-center text-2xl text-center text-black mt-8">No hay álbumes de imagenes
                        todavia</p>
                @else
                    <div class="mx-auto grid justify-items-stretch gap-4 md:grid-cols-2 lg:gap-10">
                        @foreach ($listaAlbumI as $album)
                            <div class="relative flex h-[300px] items-end">
                                <!-- Muestra solo la primera imagen -->
                                <img src="{{ asset(Storage::url($album['medios'][0])) }}" alt="{{ $album['titulo'] }}"
                                    class="inline-block h-full w-full rounded-lg object-cover" />
                                <div
                                    class="absolute bottom-5 left-5 flex flex-col justify-center rounded-lg bg-white px-8 py-4">
                                    <p class="text-sm font-medium sm:text-xl">{{ $album['titulo'] }}</p>
                                    <p class="text-sm sm:text-base">{{ $album['fecha'] }}</p>
                                    <p class="text-sm text-red-500 sm:text-sm">Contenido:
                                        {{ $album['cantidadAlbum'] }}</p>
                                </div>
                                {{-- Boton de borrar --}}
                                <form action="{{ route('eliminarAlbumEspecifico') }}" id="btnEliminarAlbum"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="accion" value=3>
                                    <input type="hidden" name="tipoAlbum" value=3>
                                    <input type="hidden" name="idAlbumEspecifico"
                                        value="{{ $album['idAlbumEspecifico'] }}">
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
        </section>

        {{-- Album de Videos Exclusivos --}}
        <section id="album-videos-exclusivos">
            <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
                <a href="#" class="relative flex h-[300px] items-end">
                    <h2 class="text-center text-3xl font-bold md:text-5xl">Álbum de Videos Exclusivos</h2>
                </a>
                @auth
                    @if (Auth::user()->rol->idrol === 1)
                        <!-- Formulario para crear un álbum musical -->
                        <form method="get" action="{{ route('crear-album') }}">
                            @csrf
                            <input type="hidden" name="accion" value=1>
                            <input type="hidden" name="tipoAlbum" value=2>
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                Crear Álbum
                            </button>
                        </form>
                    @endif
                @endauth
                @if (!$listaAlbumV)
                    <p class=" flex justify-center text-2xl text-center text-black mt-8">No hay álbumes de videos
                        todavia</p>
                @else
                    <div class="mx-auto grid justify-items-stretch gap-4 md:grid-cols-2 lg:gap-10">

                        @foreach ($listaAlbumV as $album)
                            <div class="relative flex h-[300px] items-end">
                                @if (!empty($album['medios']))
                                    <video class="inline-block h-full w-full rounded-lg object-cover" muted>
                                        <source src="{{ asset(Storage::url($album['medios'][0])) }}" type="video/mp4">
                                        Tu navegador no soporta el elemento de video.
                                    </video>
                                @endif
                                <div
                                    class="absolute bottom-5 left-5 flex flex-col justify-center rounded-lg bg-white px-8 py-4">
                                    <p class="text-sm font-medium sm:text-xl">{{ $album['titulo'] }}</p>
                                    <p class="text-sm sm:text-base">{{ $album['fecha'] }}</p>
                                    <p class="text-sm text-red-500 sm:text-sm">Contenido:
                                        {{ $album['cantidadAlbum'] }}</p>
                                </div>

                                {{-- Boton de borrar --}}
                                <form action="{{ route('eliminarAlbumEspecifico') }}" id="btnEliminarAlbum"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="accion" value=3>
                                    <input type="hidden" name="tipoAlbum" value=2>
                                    <input type="hidden" name="idAlbumEspecifico"
                                        value="{{ $album['idAlbumEspecifico'] }}">
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

        {{-- Album Videos Oficiales --}}
        <section id="album-videos-oficiales">
            <div class="mt-10">
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
                    <div class="flex flex-wrap justify-between gap-5">
                        @foreach ($listaYt as $index => $video)
                            <div class="video-container mb-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/5">
                                <!-- Ancho adaptativo -->
                                <iframe src="{{ $video['linkYt'] ?? '#' }}" width="100%" height="200"
                                    frameborder="0" allowfullscreen></iframe>
                                <h1 class="text-lg font-bold mt-2">{{ $video['titulo'] }}</h1>
                                <!-- Título destacado -->
                                <p class="text-sm text-gray-600">{{ $video['fecha'] }}</p>
                                <!-- Fecha en un tono gris -->
                            </div>

                            @if (($index + 1) % 5 == 0 && $index != count($listaYt) - 1)
                                <!-- Cierra la fila después de 5 videos -->
                                <div class="flex flex-wrap justify-between gap-5">
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    </div>
</x-AppLayout>
