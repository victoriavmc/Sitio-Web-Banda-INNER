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

    <div class="w-full h-full bg-black bg-opacity-50"></div>

    <div class="flex justify-center">
        <img class="" src="{{ asset('img/index_fondo_ng.jpg') }}" alt="">
    </div>

    {{-- SHOWS --}}
    <div class="text-black bg-black h-screen bg-cover bg-center"
        style="background-image:url({{ asset('img/index_fondo_evento.jpg') }})">
        <div class="flex flex-col h-screen justify-center">
            <h3 class="text-7xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                EVENTOS</h3>
            <div class="flex w-full justify-center py-10 pr-10 m-0">
                <section class="center slider" style="">
                    @foreach ($shows as $show)
                        <div class=" px-4 py-6"
                            style="display: flex; flex-direction:column; background-image:url({{ asset('img/index_fondo_contenido_evento.jpg') }}); background-position:center;">
                            <div>
                                <p class="font-semibold mb-2">{{ $show->fechashow }}</p>
                            </div>
                            <div>
                                <p class="font-bold text-2xl mb-2">{{ $show->lugarlocal->nombreLugar }}</p>
                            </div>
                            <div>
                                <p class="mb-2">{{ $show->lugarlocal->calle . ' ' . $show->lugarlocal->numero }}</p>
                            </div>
                            <div>
                                <p class="mb-2">
                                    {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}
                                </p>
                            </div>
                            <a href="">Adquirir Entrada</a>
                        </div>
                    @endforeach
                </section>
            </div>
        </div>

    </div>


    {{-- Youtube Spotify --}}
    <div class="relative">
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
                    <div class="row-span-2 p-2 flex flex-col items-center justify-center mx-2">
                        <h3 class="text-7xl font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                            YOUTUBE OFICIAL
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- INSTAGRAM --}}
    <div class="bg-white flex justify-center items-center">
        {{-- Fondo imagen agregar --}}
        <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
        <div class="elfsight-app-c25daa8f-eca3-4838-88f3-7ce10b757860" data-elfsight-app-lazy></div>
    </div>

    {{-- NOTICIAS Y FORO --}}
    <div class="h-screen bg-cover flex justify-center font-amsterdam  items-center bg-center"
        style="background-image:url({{ asset('img/index_fondo_nosotros.png') }})">
        <div class="bg-white bg-opacity-30 p-4 font-urbanist lg:w-[80%] lg:gap-8 xl:w-[55%] flex lg:flex-col gap-2">
            <div class="lg:flex gap-16 lg:gap-8">
                <div class="flex-1 flex justify-center flex-col">
                    <h3 class="sobreNosotros text-center text-5xl font-amsterdam mb-7 text-uppercase mt-5 deepshadow">
                        noticias proximamente...</h3>
                    {{-- <div class="flex-1 flex flex-col justify-between">
                        <div class="flex items-center mb-3 w-full">
                            <img class="w-44" src="{{ asset('img/nosotros_a1tomi.jpg') }}"
                                alt="Logo de la banda de Tomás Casalone">
                            <div class="ml-4 w-full text-center">
                                <h3 class="font-bold text-3xl">Tomás Casalone</h3>
                                <p class="text-gray-500">
                                    <span class="font-bold text-2xl text-red-600 role">Guitarra y Voz.</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-center items-center w-full">
                            <img class="w-44" src="{{ asset('img/nosotros_a2david.png') }}"
                                alt="Logo de la banda de David Copa">
                            <div class="ml-4 w-full text-center">
                                <h3 class="font-bold text-3xl">David Copa</h3>
                                <p class="text-gray-500">
                                    <span class="font-bold text-2xl text-red-600 role">Guitarra.</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 w-full">
                            <img class="w-44" src="{{ asset('img/nosotros_a3herni.jpg') }}"
                                alt="Logo de la banda de Hernán Ramírez">
                            <div class="ml-4 w-full text-center">
                                <h3 class="font-bold text-3xl">Hernán Ramírez</h3>
                                <p class="text-gray-500">
                                    <span class="font-bold text-2xl text-red-600 role">Batería.</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 w-full">
                            <img class="w-44" src="{{ asset('img/nosotros_a4agus.jpg') }}"
                                alt="Logo de la banda de Agustin Casalone">
                            <div class="ml-4 w-full text-center">
                                <h3 class="font-bold text-3xl">Agustin Casalone</h3>
                                <p class="text-gray-500">
                                    <span class="font-bold text-2xl text-red-600 role">Bajo.</span>
                                </p>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="flex-1 flex flex-col">
                    <h3 class="text-center font-amsterdam mb-7 mt-5 text-5xl text-uppercas deepshadow">FORO</h3>
                    <div class="flex-1 flex flex-col justify-around">
                        <div class="flex justify-center h-[50%] items-center">
                            <img class="w-3/4" src="{{ asset('img/nosotros_foro.png') }}" alt="">
                        </div>
                        <h3 class="font-bold text-center mt-3 text-3xl">Para la Comunidad Apasionada!</h3>
                        <p class=" text-2xl mt-2">¿Eres un apasionado de nuestra comunidad?
                            Únete a las conversaciones en nuestro foro y comparte tus opiniones con los demas.
                        </p>
                        <div class="flex justify-end mt-5">
                            <a class="relative" href="{{ route('foro') }}">
                                <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                                <span
                                    class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-yellow-400 hover:text-gray-900">Foro</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MULTIMEDIA --}}
    <div class="bg-cover flex justify-center items-center anchoPantalla"
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
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_agus.jpg') }}" alt="Imagen2"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 1 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_agus2.jpg') }}" alt="Imagen3"
                            class="h-[25rem] w-full object-cover rounded-lg">
                    </div>
                    <!-- Segunda columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_herni.jpg') }}" alt="Imagen4"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_herni2.jpg') }}" alt="Imagen5"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 2 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_herni.jpg') }}" alt="Imagen6"
                            class="h-[25rem] w-full object-cover rounded-lg">
                    </div>
                    <!-- Tercera columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_tomi.jpg') }}" alt="Imagen7"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_tomi2.jpg') }}" alt="Imagen8"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 3 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_tomi.jpg') }}" alt="Imagen9"
                            class="h-[25rem] w-full object-cover rounded-lg">
                    </div>
                    <!-- Cuarta columna dividida en dos filas -->
                    <div class="col-span-1">
                        <div class="grid grid-rows-2 gap-4 h-full">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_david.jpg') }}" alt="Imagen10"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('img/multimedia/horizontal_david2.jpg') }}" alt="Imagen11"
                                    class="h-48 w-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    <!-- Columnas normales 4 -->
                    <div class="col-span-1 flex items-center justify-center">
                        <img src="{{ asset('img/multimedia/vertical_david.jpg') }}" alt="Imagen12"
                            class="h-[25rem] w-full object-cover object-center rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-AppLayout>
