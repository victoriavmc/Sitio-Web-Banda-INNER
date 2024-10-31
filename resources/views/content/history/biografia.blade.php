<x-AppLayout>
    @if (session('alertBiografia'))
        {{-- Componente de alerta para el exitoso o fallido --}}
        <x-alerts :type="session('alertBiografia')['type']">
            {{ session('alertBiografia')['message'] }}
        </x-alerts>
    @endif

    @if ($recuperoBiografia === null)
        <div class="min-h-screen flex justify-center items-center flex-col">
            <h1 class="text-black font-bold text-center text-8xl mb-8">Biografía</h1>
            <p class="text-center mb-8 text-2xl text-gray-500">No esta disponible</p>

            @auth
                @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                    <a href="{{ route('verFormularioBiografia') }}"
                        class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">Crear</a>
                @endif
            @endauth
        </div>
    @else
        @if ($imagenesBiografia)
            @if ($imagenesBiografia->isNotEmpty() && isset($imagenesBiografia[0]))
                <div class="bg-cover bg-center text-center overflow-hidden"
                    style="min-height: 600px; background-image:url('{{ asset(Storage::url($imagenesBiografia[0]->revisionImagenes->imagenes->subidaImg)) }}')"
                    title="Banda">
                </div>
            @else
                <div class="bg-cover bg-center mx-auto"
                    style="min-height: 400px; width: 700px; background-image:url('{{ asset('img/logo_inner_negro.webp') }}');"
                    title="Banda">
                </div>
            @endif
            <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 min-h-screen">
                <div class="max-w-3xl mx-auto">
                    <div class="mt-3 p-5 bg-white flex flex-col justify-between leading-normal rounded-xl shadow-xl">
                        <div class="bg-white top-0">
                            <h1 class="text-black font-bold text-center text-8xl mb-2">{{ $recuperoBiografia->titulo }}
                            </h1>
                            @auth
                                @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                                    <a href="{{ route('editarP', ['id' => $recuperoBiografia->idcontenidos, 'tipo' => 3]) }}"
                                        class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">Modificar</a>
                                @endif
                            @endauth
                            <p class="text-base text-black leading-8 my-5">{{ $recuperoBiografia->descripcion }}</p>
                        </div>

                        {{-- EN CASO DE QUE HAYA IMÁGENES --}}
                        @if ($imagenesBiografia->count() > 1)
                            <div class="p-5 sm:p-8">
                                <div
                                    class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                                    @foreach (array_slice($imagenesBiografia->toArray(), 1) as $imagenContenido)
                                        @if (isset($imagenContenido['revision_imagenes']['imagenes']))
                                            <img id="imagen"
                                                class="cursor-pointer imagen-modal object-cover object-center w-full h-40 max-w-full rounded-lg"
                                                src="{{ asset(Storage::url($imagenContenido['revision_imagenes']['imagenes']['subidaImg'])) }}"
                                                alt="Imagen de la banda">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mx-auto ">
                        <div class="flex flex-col justify-center">
                            <div class="flex flex-col justify-center">
                                <h2 class="text-center font-semibold text-3xl mt-4 text-black">¡Escúchanos!</h2>
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
                </div>
            </div>
        @endif
    @endif
    <!-- Contenedor del modal -->
    <div id="modal" class="hidden imagenG">
        <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>
</x-AppLayout>
