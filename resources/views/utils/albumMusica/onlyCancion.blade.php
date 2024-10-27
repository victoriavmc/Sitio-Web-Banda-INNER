<x-AppLayout>
    <div class="min-h-screen bg-gray-100 text-gray-900 lg:grid lg:grid-cols-[65%_35%] p-5">
        {{-- IZQUIERDA --}}
        <div class="container mx-auto lg:mx-0 gap-6 flex items-center justify-start my-0">
            <!-- Sector principal -->
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <div>
                    @if ($listaAlbum['imagen'] != 'logo_inner.webp')
                        <img src="{{ asset(Storage::url($listaAlbum['imagen'])) }}" alt="{{ $listaAlbum['titulo'] }}"
                            class="m-0 max-w-96 max-h-96" />
                    @else
                        <img src="{{ asset('img/logo_inner_negro.webp') }}" alt="{{ $listaAlbum['titulo'] }}"
                            class="m-0 max-w-96 max-h-96" />
                    @endif
                </div>

                <div class="flex flex-col justify-center w-max gap-10">
                    <div class="flex items-start justify-between gap-2" style="margin: 0">
                        <div class="flex flex-col">
                            <span
                                class="flex flex-col w-max text-3xl lg:text-4xl">{{ $datosCancion['tituloCancion'] }}</span>
                            <span class="flex flex-col text-xl text-gray-600">{{ $listaAlbum['titulo'] }}</span>
                        </div>


                        {{-- Botones --}}
                        <div class="flex gap-4 justify-center" style="margin: 0">
                            {{-- Botón Español --}}
                            @if (!empty($datosCancion['letraEspCancion']))
                                <button
                                    class="mt-2 bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max"
                                    onclick="showLyrics('es')">
                                    Español
                                </button>
                            @endif

                            {{-- Botón Inglés --}}
                            @if (!empty($datosCancion['letraInglesCancion']))
                                <button
                                    class="mt-2 bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max"
                                    onclick="showLyrics('en')">
                                    Inglés
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Reproducir archivoDsCancion --}}
                    <div class="flex items-center gap-5" style="margin: 0">


                        {{-- Para descargar si es superfan --}}
                        @if (Auth::user()->rol->idrol != 4)
                            @if ($datosCancion['archivoDsCancion'] && $datosCancion['contenidoDescargable'] == 'Si')
                                <audio controls>
                                    <source src="{{ asset(Storage::url($datosCancion['archivoDsCancion'])) }}"
                                        type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                {{-- Boton para descargar automaticamente --}}
                                <a href="{{ asset(Storage::url($datosCancion['archivoDsCancion'])) }}" download>
                                    <button
                                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-1 px-2 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                        <svg class="w-5.5 h-5.5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                        </svg>
                                    </button>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <!-- Texto -->
            {{-- Letra en español (por defecto) --}}
            <div id="letra" class="lg:max-w-sm">
                <p class="text-gray-700 text-center">
                    {{ !empty($datosCancion['letraEspCancion']) ? $datosCancion['letraEspCancion'] : 'Todavía no se ha cargado la letra en español.' }}
                </p>
            </div>

            {{-- Letra en inglés (oculta inicialmente) --}}
            <div id="letra-en" class="lg:max-w-sm hidden">
                <p class="text-gray-700 text-center">
                    {{ !empty($datosCancion['letraInglesCancion']) ? $datosCancion['letraInglesCancion'] : 'Todavía no se ha cargado la letra en inglés.' }}
                </p>
            </div>

            {{-- Botones de Spotify y Apple Music --}}
            <div class="flex flex-col md:flex-row w-full items-center justify-center gap-4">
                @foreach ($links as $link)
                    @if ($link->linkRedSocial)
                        @switch($link->nombreRedSocial)
                            @case('Spotify')
                                <a href="{{ $link->linkRedSocial }}">
                                    <button type="button"
                                        class="text-white hover:before:bg-redborder-red-500 relative text-sm px-5 py-2.5 text-center inline-flex items-center  w-[13rem] md:w-[15rem] overflow-hidden bg-black shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-white before:transition-all before:duration-500 hover:text-black hover:before:left-0 hover:before:w-full rounded-lg">
                                        <span class="text-center inline-flex items-center z-10">
                                            <svg width="40px" height="40px" viewBox="0 0 48 48" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>Spotify-color</title>
                                                <desc>Created with Sketch.</desc>
                                                <defs>
                                                </defs>
                                                <g id="Icons" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <g id="Color-" transform="translate(-200.000000, -460.000000)"
                                                        fill="#00DA5A">
                                                        <path
                                                            d="M238.16,481.36 C230.48,476.8 217.64,476.32 210.32,478.6 C209.12,478.96 207.92,478.24 207.56,477.16 C207.2,475.96 207.92,474.76 209,474.4 C217.52,471.88 231.56,472.36 240.44,477.64 C241.52,478.24 241.88,479.68 241.28,480.76 C240.68,481.6 239.24,481.96 238.16,481.36 M237.92,488.08 C237.32,488.92 236.24,489.28 235.4,488.68 C228.92,484.72 219.08,483.52 211.52,485.92 C210.56,486.16 209.48,485.68 209.24,484.72 C209,483.76 209.48,482.68 210.44,482.44 C219.2,479.8 230,481.12 237.44,485.68 C238.16,486.04 238.52,487.24 237.92,488.08 M235.04,494.68 C234.56,495.4 233.72,495.64 233,495.16 C227.36,491.68 220.28,490.96 211.88,492.88 C211.04,493.12 210.32,492.52 210.08,491.8 C209.84,490.96 210.44,490.24 211.16,490 C220.28,487.96 228.2,488.8 234.44,492.64 C235.28,493 235.4,493.96 235.04,494.68 M224,460 C210.8,460 200,470.8 200,484 C200,497.2 210.8,508 224,508 C237.2,508 248,497.2 248,484 C248,470.8 237.32,460 224,460"
                                                            id="Spotify">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <p class="ps-4 text-left">
                                                <span class="text-sm font-light">Escuchala en</span><br><span
                                                    class="text-lg">Spotify</span>
                                            </p>
                                        </span>
                                    </button>
                                </a>
                            @break

                            @case('iTunes')
                                <a href="{{ $link->linkRedSocial }}">
                                    <button
                                        class="text-white hover:before:bg-redborder-red-500 relative text-sm px-5 py-2.5 text-center inline-flex items-center  w-[13rem] md:w-[15rem] overflow-hidden bg-black shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-white before:transition-all before:duration-500 hover:text-black hover:before:left-0 hover:before:w-full rounded-lg">
                                        <span class="text-center inline-flex items-center z-10">
                                            <svg width="40px" height="40px" xmlns="http://www.w3.org/2000/svg"
                                                aria-label="Apple Music" role="img" viewBox="0 0 512 512">
                                                <rect width="512" height="512" rx="15%" fill="url(#g)" />
                                                <linearGradient id="g" x1=".5" y1=".99" x2=".5"
                                                    y2=".02">
                                                    <stop offset="0" stop-color="#FA233B" />
                                                    <stop offset="1" stop-color="#FB5C74" />
                                                </linearGradient>
                                                <path fill="#ffffff"
                                                    d="M199 359V199q0-9 10-11l138-28q11-2 12 10v122q0 15-45 20c-57 9-48 105 30 79 30-11 35-40 35-69V88s0-20-17-15l-170 35s-13 2-13 18v203q0 15-45 20c-57 9-48 105 30 79 30-11 35-40 35-69" />
                                            </svg>
                                            <p class="ps-4 text-left">
                                                <span class="text-sm font-light">Escuchala en</span><br><span
                                                    class="text-lg">Apple
                                                    Music</span>
                                            </p>
                                        </span>
                                    </button>
                                </a>
                            @break
                        @endswitch
                    @endif
                @endforeach
            </div>
        </div>



        {{-- DERECHA --}}
        <div class="container mx-auto lg:mx-0 my-0 flex justify-start">
            <div class=w-full lg:w-[90%]">
                <div
                    class="w-full mb-4 lg:mb-0 select-none rounded-lg bg-red-500 py-2 px-3.5 font-sans text-xs font-bold uppercase leading-none text-white">
                    Otras Canciones del Album
                </div>
                <ul class="lg:overflow-y-auto lg:max-h-72 custom-scrollbar">
                    @foreach ($listaAlbum['canciones'] as $cancion)
                        <li class="flex flex-col p-2 lg:flex-row border-b border-gray-400 lg:border-gray-300">
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
                            <div class="flex flex-wrap items-center justify-center gap-10 md:justify-around">
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
