<x-AppLayout>
    <div class="min-h-screen bg-gray-100 text-gray-900 flex flex-col lg:flex-row">
        {{-- IZQUIERDA --}}
        <div class="flex-1 bg-indigo-100 flex-col text-center flex items-center justify-center p-4 lg:block">
            {{-- Album (ACHICAR) --}}
            <div class="flex items-center gap-4">
                @if ($listaAlbum['imagen'] != 'imagen_por_defecto.jpg')
                    <img src="{{ asset(Storage::url($listaAlbum['imagen'])) }}"
                        alt="{{ $listaAlbum['titulo'] }}"class="w-32 group-hover:w-36 group-hover:h-36 h-32 object-center object-cover rounded-full transition-all duration-500 delay-500 transform" />
                @else
                    <img src="{{ asset('img/logo_inner_negro.png') }}"
                        alt="{{ $listaAlbum['titulo'] }}"class="w-32 group-hover:w-36 group-hover:h-36 h-32 object-center object-cover rounded-full transition-all duration-500 delay-500 transform" />
                @endif

                <div class="w-fit transition-all transform duration-500 flex flex-wrap">
                    <div class="flex flex-col mr-4">
                        <h1 class="text-gray-600 dark:text-gray-200 font-bold">
                            {{ $datosCancion['tituloCancion'] }}
                        </h1>
                        <p class="text-gray-400">{{ $listaAlbum['titulo'] }}</p>
                    </div>


                    {{-- Para descargar si es superfan --}}
                    @if (Auth::user()->rol->idrol === 1 || Auth::user()->rol->idrol === 2 || Auth::user()->rol->idrol === 3)
                        @if ($datosCancion['archivoDsCancion'] && $datosCancion['contenidoDescargable'] == 'Si')
                            <a href=""
                                class="animate-bounce focus:animate-none hover:animate-none bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                <span class="ml-2">Descargar Música </span>
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="flex space-x-4 mb-4">
                {{-- Botón Español --}}
                @if (!empty($datosCancion['letraEspCancion']))
                    <button
                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max"
                        onclick="showLyrics('es')">
                        Español
                    </button>
                @endif

                {{-- Botón Inglés --}}
                @if (!empty($datosCancion['letraInglesCancion']))
                    <button
                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max"
                        onclick="showLyrics('en')">
                        Inglés
                    </button>
                @endif
            </div>

            {{-- Letra en español (por defecto) --}}
            <div id="letra" class="mt-6 lg:max-w-sm">
                <p class="text-sm text-gray-800">
                    {{ !empty($datosCancion['letraEspCancion']) ? $datosCancion['letraEspCancion'] : 'Todavía no se ha cargado la letra en español.' }}
                </p>
            </div>

            {{-- Letra en inglés (oculta inicialmente) --}}
            <div id="letra-en" class="mt-6 lg:max-w-sm hidden">
                <p class="text-sm text-gray-800">
                    {{ !empty($datosCancion['letraInglesCancion']) ? $datosCancion['letraInglesCancion'] : 'Todavía no se ha cargado la letra en inglés.' }}
                </p>
            </div>
        </div>


        {{-- DERECHA --}}
        <div class="w-full lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="lg:flex lg:gap-4 lg:flex-col lg:pr-4">
                <div
                    class="center w-full mb-4 lg:mb-0 relative inline-block select-none whitespace-nowrap rounded-lg bg-red-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white">
                    Otras Canciones del Album
                </div>
                <ul class="lg:overflow-y-auto lg:max-h-72 custom-scrollbar">
                    @foreach ($listaAlbum['canciones'] as $cancion)
                        <li class="flex flex-col p-2 lg:flex-row lg:border-b lg:border-gray-300">
                            <a href="{{ route('ver-cancion', $cancion['id']) }}"
                                class="flex flex-col gap-3 items-start pt-4 lg:px-8">
                                <p class="mb-2 text-sm font-bold sm:text-base">{{ $cancion['titulo'] }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @if (!$recuperoRedesSociales)
                <div class="mx-auto ">
                    <div class="flex flex-col justify-center">
                        <div class="flex flex-col justify-center">

                            <h2 class="text-center font-semibold text-3xl text-black">¡Escúchanos!</h2>
                            <div class="flex flex-wrap items-center justify-center gap-10 mt-2 md:justify-around">
                                @foreach ($recuperoRedesSociales as $redSocial)
                                    @if ($redSocial->linkRedSocial)
                                        @switch($redSocial->nombreRedSocial)
                                            @case('Deezer')
                                                <div class="text-gray-400">
                                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img class="w-38"
                                                            src="{{ asset('img/biografia/logoOficial_deezer.svg') }}"
                                                            alt="Deezer">
                                                    </a>
                                                </div>
                                            @break

                                            @case('Spotify')
                                                <div class="text-gray-400">
                                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img class=" h-40"
                                                            src="{{ asset('img/biografia/logoOficial_spotify.svg') }}"
                                                            alt="Spotify">
                                                    </a>
                                                </div>
                                            @break

                                            @case('Youtube')
                                                <div class="text-gray-400">
                                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img class=" h-40"
                                                            src="{{ asset('img/biografia/logoOficial_youtube.svg') }}"
                                                            alt="Youtube">
                                                    </a>
                                                </div>
                                            @break

                                            @case('iTunes')
                                                <div class="text-gray-400">
                                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img class=" h-40"
                                                            src="{{ asset('img/biografia/logoOficial_iTunes.svg') }}"
                                                            alt="iTunes">
                                                    </a>
                                                </div>
                                            @break

                                            @case('Amazon Music')
                                                <div class="text-gray-400">
                                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img class=" h-20"
                                                            src="{{ asset('img/biografia/logoOficial_amazon_music.svg') }}"
                                                            alt="Amazon Music">
                                                    </a>
                                                </div>
                                            @break
                                        @endswitch
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {{-- Script para manejar el cambio de letras --}}
    <script>
        function showLyrics(language) {
            if (language === 'es') {
                document.getElementById('letra').classList.remove('hidden');
                document.getElementById('letra-en').classList.add('hidden');
            } else if (language === 'en') {
                document.getElementById('letra').classList.add('hidden');
                document.getElementById('letra-en').classList.remove('hidden');
            }
        }
    </script>
</x-AppLayout>
