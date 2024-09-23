<x-AppLayout>
    <!-- NOTICIA INDIVIDUAL -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[86.5vh] bg-white">
        <div class="max-w-3xl mx-auto">
            <!-- NOTICIA header -->
            <div class="py-8">
                <h1 class="text-3xl font-bold mb-2 text-black">{{ $recuperoPublicacion->titulo }}</h1>
                <p class="text-gray-500 text-sm">Publicado el: <time
                        datetime="2022-04-05">{{ $recuperoPublicacion->fechaSubida }}</time></p>
            </div>

            <!-- Image Principal -->

            @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 0)
                <!-- Mostrar la primera imagen de la lista -->
                <img src="{{ asset(Storage::url($listaPublicacionConImg[0])) }}" alt="Imagen Principal"
                    class="w-full h-auto mb-8">
            @else
                <!-- Mostrar una imagen por defecto si no hay imágenes disponibles -->
                <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto" class="w-full h-auto mb-8">
            @endif

            <!-- NOTICIA Contenido -->
            <div class="prose prose-sm text-black sm:prose lg:prose-lg xl:prose-xl mx-auto">
                <p>{{ $recuperoPublicacion->descripcion }}</p>
            </div>
        </div>

        <!-- Mostrar imágenes adicionales si hay más de una -->
        @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 1)
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                @foreach (array_slice($listaPublicacionConImg, 1) as $imagen)
                    <div>
                        <img class="object-cover object-center w-full h-40 max-w-full rounded-lg"
                            src="{{ asset(Storage::url($imagen)) }}" alt="Galería">
                    </div>
                @endforeach
            </div>
        @endif



        {{-- Apartado Noticias y eventos --}}
        {{-- NOTICIAS --}}
        <div class="sm:col-span-6 lg:col-span-4">
            @foreach ($mostrarAparteNoticias as $noticiaExtra)
                <div class="flex items-start mb-3 pb-3">
                    <a href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}" class="inline-block mr-3">
                        @if (isset($noticiaExtra->imagenes) && !empty($noticiaExtra->imagenes[0]))
                            <img src="{{ asset(Storage::url($noticiaExtra->imagenes[0])) }}"
                                alt="Imagen de {{ $noticiaExtra->titulo }}" class="w-20 h-20 bg-cover bg-center" />
                        @else
                            <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                class="w-20 h-20 bg-cover bg-center" />
                        @endif
                    </a>
                    <div class="text-sm">
                        <p class="text-gray-600 text-xs">{{ $noticiaExtra->fechaSubida }}</p>
                        <a href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}"
                            class="text-gray-900 font-medium hover:text-indigo-600 leading-none">
                            {{ $noticiaExtra->titulo }}
                        </a>
                        <p class="text-base text-black mt-4">{{ $noticiaExtra->descripcion }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- EVENTOS --}}
        <div class="sm:col-span-6 lg:col-span-4">
            @foreach ($mostrarAparteEventos as $eventos)
                <div class="flex items-start mb-3 pb-3">
                    {{-- {{ route('showUnico', $eventos->idshow) }} --}}
                    <a href="" class="inline-block mr-3">
                        @if (isset($eventos['imagenes']) && !empty($eventos['imagenes'][0]))
                            <img src="{{ asset(Storage::url($eventos['imagenes'][0])) }}"
                                alt="Imagen de {{ $eventos['nombreLugar'] }}" class="w-20 h-20 bg-cover bg-center" />
                        @else
                            <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                class="w-20 h-20 bg-cover bg-center" />
                        @endif
                    </a>
                    <div class="text-sm">
                        <p class="text-gray-600 text-xs">{{ $eventos['fechashow'] }}</p>
                        {{-- {{ route('showUnico', $eventos->idshow) }} --}}
                        <a href="" class="text-gray-900 font-medium hover:text-indigo-600 leading-none">
                            {{ $eventos['nombreLugar'] }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</x-AppLayout>
