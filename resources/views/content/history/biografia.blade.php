<x-AppLayout>
    @foreach ($recuperoBiografia as $biografia)
        <div class="bg-cover bg-center text-center overflow-hidden"
            style="min-height: 600px; background-image:url('{{ asset(Storage::url($biografia->imagenes[0])) }}')"
            title="Banda">
        </div>
        <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 relative">

            <div class="max-w-3xl mx-auto">
                <div
                    class="mt-3 bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
                    <div class="bg-white relative top-0 -mt-32 p-5 sm:p-10">
                        <h1 class="text-black font-bold text-center text-8xl mb-2">{{ $biografia->titulo }}
                        </h1>
                        @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                            <a href="{{ route('editarP', $biografia->idcontenidos) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modificar</a>
                        @endif
                        <p class="text-base text-black leading-8 my-5">{{ $biografia->descripcion }}
                        </p>
                    </div>

                    {{-- EN CASO DE QUE HAYA IMÁGENES --}}
                    @if (count($biografia->imagenes) > 1)
                        @foreach (array_slice($biografia->imagenes, 1) as $imagen)
                            <div class="p-5 sm:p-8">
                                <div
                                    class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                                    <img src="{{ asset(Storage::url($imagen)) }}" alt="Imagen de la banda">
                                </div>
                            </div>
                        @endforeach
                    @endif


                    <div class="mx-auto px-5 mb-10">
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
            </div>
        </div>
    @endforeach
</x-AppLayout>
