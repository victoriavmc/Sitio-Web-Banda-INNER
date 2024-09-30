<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">
    <link rel="icon" href="{{ asset('img/logo_perropepsi.ico') }}" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
    <title>INNER</title>
</head>

@php $inicio = $inicio ?? false; @endphp


<body class="bg-black  text-gray-300">
    <header class=" bg-black bg-opacity-60 text-center w-full border-b border-gray-600 z-10">
        <nav class="flex items-center justify-center text-gray-300 relative">
            <!-- Menú izquierdo -->
            <ul class="hidden font-amsterdam lg:flex text-xl gap-4 xl:gap-6 z-10">
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('inicio') }}">Inicio</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('discografia') }}">Musica</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('eventos') }}">Eventos</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('biografia') }}">Historia</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('artistas') }}">Artistas</a>
                </li>
            </ul>

            <!-- Logo centrado -->
            <a class="z-10 mx-4 xl:mx-8" href="{{ route('inicio') }}">
                <img class="xl:w-52 w-40" src="{{ asset('img/logo_inner.png') }}" alt="">
            </a>

            <!-- Menú derecho -->
            <ul class="font-amsterdam hidden lg:flex text-xl gap-4 xl:gap-6 z-10">
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('albumGaleria') }}">Galeria</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('noticias') }}">Noticias</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('foro') }}">Foro</a>
                </li>
                <li class="transition-all duration-500 ease-in-out text-red-600 hover:text-red-600 hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('superFan') }}">Acceso Exclusivo</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('staff') }}">Staff</a>
                </li>
            </ul>

            <!-- Ícono usuario a la derecha -->
            <div class="absolute flex items-center right-1 mr-6 z-30">
                @if ($isAuthenticated)
                    <button id="perfil-toggle">
                        <img type="button" class="w-10 h-10 rounded-full cursor-pointer bg-white border-white"
                            src="{{ asset($imagenPerfil) }}" alt="User dropdown">
                    </button>
                @else
                    <a href="{{ route('login') }}">
                        <img type="button" class="w-10 h-10 rounded-full border bg-white border-white cursor-pointer"
                            src="{{ asset('img/logo_usuario.png') }}" alt="Login">
                    </a>
                @endif
            </div>

            <!-- Dropdown menu -->
            @if ($isAuthenticated)
                <div id="dropdown-perfil"
                    class="hidden absolute right-0 text-left top-12 mt-7 mr-9 w-40 divide-y rounded-lg shadow bg-black opacity-80 divide-gray-600 z-40">
                    <div class="px-4 py-3 text-sm font-bold text-white">
                        <div><span class="text-white">{{ $nombreUsuario }}</span></div>
                    </div>
                    <ul class="py-2 text-sm text-gray-200" aria-labelledby="avatarButton">
                        <li>
                            <a href="{{ route('perfil') }}"
                                class="block px-4 py-2 hover:bg-gray-600 hover:text-white">Perfil</a>
                        </li>
                        <li>
                            <a href="{{ route('modificar-perfil') }}"
                                class="block px-4 py-2 hover:bg-gray-600 hover:text-white">Ajustes</a>
                        </li>
                        <li>
                            <a href="{{ route('underConstruction') }}"
                                class="block px-4 py-2 hover:bg-gray-600 hover:text-white">Notificaciones</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-600 text-gray-200 hover:text-white">Cerrar
                            Sesion</a>
                    </div>
                </div>
            @endif

            <!-- Botón desplegable para pantallas menores a 1280px -->
            <div class="lg:hidden flex items-center absolute ml-5 sm:ml-20 left-4 z-30">
                <button id="menu-toggle" class=" text-gray-400 hover:text-white focus:outline-none z-30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:w-8 sm:h-8" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Menú desplegable (oculto por defecto) -->
        <div id="dropdown-menu" class="hidden font-amsterdam text-left border-t border-gray-600 text-gray-300 z-40">
            <ul class="flex flex-col ml-10 mt-4 mb-4 gap-4 text-xl">
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('inicio') }}">Inicio</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('discografia') }}">Musica</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('eventos') }}">Eventos</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('biografia') }}">Historia</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('artistas') }}">Artistas</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('albumGaleria') }}">Galeria</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('noticias') }}">Noticias</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('foro') }}">Foro</a>
                </li>
                <li class="transition-all duration-500 ease-in-out text-red-600 hover:text-red-600 hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('superFan') }}">Acceso Exclusivo</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('staff') }}">Staff</a>
                </li>
            </ul>
        </div>
    </header>

    {{ $slot }}

    {{-- Pie de pagina --}}
    <footer
        class="footer z-10 w-full border-t shadow flex items-center justify-between p-2 sm:px-10 bg-black border-gray-600 font-amsterdam">
        <div>
            <span class="text-sm sm:text-center text-white">
                © @php echo date('Y') @endphp Santi y VictoriaVMC. Todos los derechos reservados.
            </span>
            <span class="ml-4 text-sm sm:text-center text-white">
                <a href="{{ route('terminos-de-servicio') }}" class="hover:underline">Terminos de Servicio.</a>
            </span>
        </div>
        <div>
            <ul class="flex items-center">
                @foreach ($links as $link)
                    @if ($link->linkRedSocial)
                        @switch($link->nombreRedSocial)
                            @case('Deezer')
                                <li class="text-gray-400">
                                    <a href="{{ $link->linkRedSocial }}" target="_blank"
                                        class="flex items-center me-4 md:me-6">
                                        <img class="w-6 mr-1" src="{{ asset('img/footer/logo_deezer.png') }}"
                                            alt="Deezer">
                                    </a>
                                </li>
                            @break

                            @case('Spotify')
                                <li class="text-gray-400">
                                    <a href="{{ $link->linkRedSocial }}" target="_blank"
                                        class="flex items-center me-4 md:me-6">
                                        <img class="w-5 mr-1" src="{{ asset('img/footer/logo_spotify.png') }}"
                                            alt="Spotify">
                                    </a>
                                </li>
                            @break

                            @case('Youtube')
                                <li class="text-gray-400">
                                    <a href="{{ $link->linkRedSocial }}" target="_blank"
                                        class="flex items-center me-4 md:me-6">
                                        <img class="w-6 mr-1" src="{{ asset('img/footer/logo_youtube.png') }}"
                                            alt="YouTube">
                                    </a>
                                </li>
                            @break

                            @case('iTunes')
                                <li class="text-gray-400">
                                    <a href="{{ $link->linkRedSocial }}" target="_blank"
                                        class="flex items-center me-4 md:me-6">
                                        <img class="w-6 mr-1" src="{{ asset('img/footer/logo_apple.png') }}" alt="iTunes">
                                    </a>
                                </li>
                            @break

                            @case('Amazon Music')
                                <li class="text-gray-400">
                                    <a href="{{ $link->linkRedSocial }}" target="_blank"
                                        class="flex items-center me-4 md:me-6">
                                        <img class="w-6 mr-1" src="{{ asset('img/footer/logo_amazon_music.png') }}"
                                            alt="Amazon Music">
                                    </a>
                                </li>
                            @break

                            @case('Instagram')
                                <li class="text-gray-400">
                                    <a href="{{ $link->linkRedSocial }}" target="_blank"
                                        class="flex items-center me-4 md:me-6">
                                        <img class="w-5 mr-1" src="{{ asset('img/footer/logo_instagram.png') }}"
                                            alt="Instagram">
                                    </a>
                                </li>
                            @break
                        @endswitch
                    @endif
                @endforeach
            </ul>
        </div>

    </footer>



</body>

@if ($login ?? false)
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Mostrar/ocultar el menú al hacer clic en el botón
    menuToggle.addEventListener('click', function(event) {
        dropdownMenu.classList.toggle('hidden');
        event.stopPropagation(); // Prevenir que el clic se propague al documento
    });

    // Cerrar el menú si se hace clic fuera de él
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = dropdownMenu.contains(event.target) || menuToggle.contains(event
            .target);

        if (!isClickInsideMenu) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>

</html>
