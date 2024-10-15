<x-AppLayout :inicio=true>

    @if (session('alertEliminacion'))
        <x-alerts :type="session('alertEliminacion')['type']">
            {{ session('alertEliminacion')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertLogout'))
        <x-alerts :type="session('alertLogout')['type']">
            {{ session('alertLogout')['message'] }}
        </x-alerts>
    @endif

    <style>
        .imagen {
    box-shadow: 0px 10px 15px -5px rgba(0, 0, 0, 0.4); /* Sombra suave en la parte inferior */
    margin-bottom: 20px; /* Espacio entre las imágenes */
    transition: transform 0.3s ease; /* Para animación opcional */
}

.imagen:hover {
    transform: translateY(-5px); /* Levanta un poco la imagen al pasar el ratón por encima */
}
    </style>

    <div class="flex justify-center bg-black">
        <img class="h-[91vh]" src="{{ asset('img/index_fondo_ng.jpg') }}" alt="">
    </div>

    {{-- SHOWS --}}
    <div class="bg-gray-900 min-h-screen bg-center bg-cover flex flex-col items-center justify-center"
        style="background-image:url({{ asset('img/index_fondo_evento.jpg') }})">
        <h3 class="text-8xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
            eventos
        </h3>

        <div class="swiper">
            <div class="slide-content mb-10">
                <div class="swiper-wrapper">
                    @foreach ($shows as $show)
                        <div class="swiper-slide" style="display:flex; justify-content: center; width:100%;">
                            <div class="event-card mx-2 pl-10 pb-5 text-start text-black bg-center bg-cover"
                                style="background-image:url({{ asset('img/index_fondo_contenido_evento.jpg') }})">
                                <div class="flex flex-col justify-around h-full">
                                    <div class="mt-10">
                                        <div class="flex justify-between">
                                            <p class="event-date font-semibold text-2xl">
                                                {{ \Carbon\Carbon::parse($show->fechashow)->format('d F Y') }}</p>
                                            <p class="event-date font-semibold text-2xl pr-4">
                                                {{ \Carbon\Carbon::parse($show->fechashow)->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <p class="event-title text-center font-bold text-5xl pr-4">
                                            {{ $show->lugarlocal->nombreLugar }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="event-location font-medium text-lg pr-4">
                                            {{ $show->lugarlocal->calle . ' ' . $show->lugarlocal->numero }}
                                        </p>
                                        <p class="event-location font-medium text-lg pr-4">
                                            {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-end justify-center pr-4">
                                        @php
                                            $isPastEvent = \Carbon\Carbon::now()->greaterThanOrEqualTo(
                                                \Carbon\Carbon::parse($show->fechashow),
                                            );
                                        @endphp
                                        @if ($show->estadoShow == 'Inactivo' || $isPastEvent)
                                            <button
                                                class="boton-eventos mb-0 mt-4 text-lg max-w-max cursor-default bg-gray-400"
                                                disabled>Ver mas</button>
                                        @else
                                            <a href="{{ route('eventos') }}">
                                                <button
                                                    class="boton-eventos mb-0 mt-4 font-medium text-lg max-w-max bg-black text-white hover:bg-red-600 hover:text-white">Ver
                                                    mas</button>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex justify-end">
                                        <img class="imagen w-24 pr-1 pb-6" src="{{ asset('img/logo_inner_negro.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>



    {{-- Youtube Spotify --}}
    <div class="relative min-h-screen">
        <img class="absolute inset-0 w-full h-full object-cover blur-sm"
            src="{{ asset('img/index_fondo_spotify_yt.png') }}" alt="Fondo">
        <div class="relative z-10 lg:p-4">
            <div class="lg:grid lg:grid-cols-[40%_60%] lg:gap-2">
                <div class="lg:p-4">
                </div>

                <div class="grid grid-rows-[1fr_1fr_1fr_1fr] lg:gap-y-4 lg:p-4">
                    <div class="row-span-2 p-2 flex flex-col items-center justify-center mx-2">
                        <h3
                            class="text-7xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                            CANCIONES
                        </h3>
                        <iframe style="border-radius:12px"
                            src="https://open.spotify.com/embed/artist/0Y9jAWMZF3ve6nxKdNFiWU?utm_source=generator"
                            width="100%" height="352" frameBorder="0" allowfullscreen=""
                            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                            loading="lazy"></iframe>
                    </div>
                    {{-- <div class="row-span-2 p-2 flex flex-col items-center justify-center mx-2">
                        <h3 class="text-7xl font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                            YOUTUBE OFICIAL
                        </h3>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>


    {{-- INSTAGRAM --}}
    <div class="bg-white flex justify-center items-center">
        {{-- Fondo imagen agregar --}}
        <script src="https://static.elfsight.com/platform/platform.js" async></script>
        <div class="elfsight-app-c24daa8f-eca3-4838-88f3-7ce10b757860" data-elfsight-app-lazy></div>
    </div>

    {{-- NOTICIAS Y FORO --}}
    <div class="min-h-screen bg-cover p-10 flex justify-center font-amsterdam items-center bg-center"
        style="background-image:url({{ asset('img/index_fondo_nosotros.png') }})">
        <div class="bg-white bg-opacity-30 p-4 font-urbanist lg:w-[80%] xl:w-[70%] flex flex-col gap-8">
            <div class="lg:flex gap-8">
                {{-- Columna 1: Noticias --}}
                <div class="flex-1 flex flex-col">
                    <h3 class="text-center text-5xl font-amsterdam mb-7 text-uppercase deepshadow">
                        Noticias</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        {{-- NOTICIAS --}}
                        @foreach ($noticias as $noticia)
                            <div class="bg-white rounded-xl shadow-lg p-4">
                                <div class="relative overflow-hidden rounded-xl mb-2">
                                    <a class="flex justify-center"
                                        href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                        @if (!empty($noticiasImg[$noticia->idcontenidos]) && isset($noticiasImg[$noticia->idcontenidos][0]))
                                            <img src="{{ asset(Storage::url($noticiasImg[$noticia->idcontenidos][0])) }}"
                                                alt="Imagen de {{ $noticia->titulo }}"
                                                class="imagen object-cover w-48 h-48 object-center" />
                                        @else
                                            <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                                class="imagen object-cover w-full h-48 object-center" />
                                        @endif
                                    </a>
                                </div>
                                <div class="">
                                    <p class="text-sm font-semibold text-gray-700">{{ $noticia->fechaSubida }}</p>
                                    <a class="w-full" href="{{ route('noticiaUnica', $noticia->idcontenidos) }}"
                                        class="block text-xl font-semibold text-blue-gray-900 mt-2 hover:text-black">
                                        {{ $noticia->titulo }}
                                    </a>
                                    <p class="text-base text-black mt-4">{{ $noticia->descripcion }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-5">
                        <a class="relative" href="{{ route('noticias') }}">
                            <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                            <span
                                class="relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-yellow-400 hover:text-gray-900">Más
                                Noticias</span>
                        </a>
                    </div>
                </div>

                {{-- Columna 2: Foro --}}
                <div class="flex-1 flex flex-col">
                    <h3 class="text-center text-5xl font-amsterdam mb-7 text-uppercase deepshadow">Foro</h3>

                    <div class="flex flex-col justify-around h-full">
                        <div class="flex justify-center">
                            <img class="imagen w-3/4" src="{{ asset('img/nosotros_foro.png') }}" alt="Foro de la comunidad">
                        </div>
                        <h3 class="font-bold text-center mt-3 text-3xl">¡Para la Comunidad Apasionada!</h3>
                        <p class="text-2xl mt-2 text-center">Únete a las conversaciones en nuestro foro y comparte tus
                            opiniones con los demás.</p>

                        <div class="flex justify-center mt-5">
                            <a class="relative" href="{{ route('foro') }}">
                                <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                <span
                                    class="relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-yellow-400 hover:text-gray-900">Ir
                                    al Foro</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MULTIMEDIA --}}
    <div class="bg-cover min-h-screen flex justify-center items-center anchoPantalla"
        style="background-image: url({{ asset('img/index_fondo_multi.jpg') }}); background-position: left; background-size: cover;">

        {{-- Contenedor del contenido centrado --}}
        <div class="text-center w-max">
            {{-- Título --}}
            <h3 class="text-7xl text-uppercas font-extrabold deepshadow text-white mb-6 hover:animate-pulse">
                MULTIMEDIA
            </h3>

            {{-- Contenedor del grid --}}
            <div class="bg-white text-uppercas bg-opacity-30 p-4 rounded-lg shadow-lg mx-auto w-full max-w-[88rem]">
                <div class="grid grid-cols-8 gap-4">
                    <!-- Primera columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_agus2.jpg') }}" alt="Imagen 1"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_agus.jpg') }}" alt="Imagen2"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 1 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_agus2.jpg') }}" alt="Imagen3"
                            class="imagen h-[25rem] w-full object-cover rounded-lg">
                    </div>
                    <!-- Segunda columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_herni.jpg') }}" alt="Imagen4"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_herni2.jpg') }}" alt="Imagen5"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 2 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_herni.jpg') }}" alt="Imagen6"
                            class="imagen h-[25rem] w-full object-cover rounded-lg">
                    </div>
                    <!-- Tercera columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_tomi.jpg') }}" alt="Imagen7"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_tomi2.jpg') }}" alt="Imagen8"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 3 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_tomi.jpg') }}" alt="Imagen9"
                            class="imagen h-[25rem] w-full object-cover rounded-lg">
                    </div>
                    <!-- Cuarta columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_david.jpg') }}" alt="Imagen10"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_david2.jpg') }}" alt="Imagen11"
                                    class="imagen h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 4 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_david.jpg') }}" alt="Imagen12"
                            class="imagen h-[25rem] w-full object-cover object-center rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-AppLayout>
