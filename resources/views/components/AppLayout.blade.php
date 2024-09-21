<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if ($login ?? false)
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" href="{{ asset('img/logo_perropepsi.ico') }}" />
    <title>INNER</title>
</head>

@php $inicio = $inicio ?? false; @endphp


<body class="bg-black  text-gray-300">
    <header class=" bg-black bg-opacity-60 text-center w-full border-b border-gray-600 z-10">
        <nav class="flex items-center justify-center text-gray-300 relative">
            <!-- Menú izquierdo -->
            <ul class="hidden font-amsterdam xl:flex text-xl gap-6 z-10">
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('inicio') }}">Inicio</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Musica</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Eventos</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Historia</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Artistas</a>
                </li>
            </ul>

            <!-- Logo centrado -->
            <a class="z-10 mx-8" href="{{ route('inicio') }}">
                <img class="w-36 sm:w-56" src="{{ asset('img/logo_inner.png') }}" alt="">
            </a>

            <!-- Menú derecho -->
            <ul class="font-amsterdam hidden xl:flex text-xl gap-6 z-10">
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Galeria</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Noticias</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="">Foro</a>
                </li>
                <li class="transition-all duration-500 ease-in-out text-red-600 hover:text-red-600 hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">SuperFan</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Staff</a>
                </li>
            </ul>

            <!-- Ícono usuario a la derecha -->
            <div class="absolute flex items-center right-4 mr-6 sm:mr-20 z-10">
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
                    class="hidden absolute right-0 text-left top-12 mt-7 mr-9 w-40 divide-y rounded-lg shadow bg-black opacity-80 divide-gray-600 z-20">
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
            <div class="xl:hidden flex items-center absolute ml-5 sm:ml-20 left-4 z-10">
                <button id="menu-toggle" class="text-gray-400 hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:w-8 sm:h-8" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Menú desplegable (oculto por defecto) -->
        <div id="dropdown-menu" class="hidden font-amsterdam text-left border-t border-gray-600 text-gray-300">
            <ul class="flex flex-col ml-10 mt-4 mb-4 gap-4 text-xl">
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('inicio') }}">Inicio</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Musica</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Eventos</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Historia</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Artistas</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Galeria</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Noticias</a>
                </li>
                <li class="transition-colors duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="">Foro</a>
                </li>
                <li class="transition-all duration-500 ease-in-out text-red-600 hover:text-red-600 hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">SuperFan</a>
                </li>
                <li class="transition-all duration-500 ease-in-out hover:text-white hover:underline">
                    <a class="hover:animate-pulse" href="{{ route('underConstruction') }}">Staff</a>
                </li>
            </ul>
        </div>
    </header>

    {{ $slot }}

    {{-- Pie de pagina --}}
    <footer
        class="footer z-10 w-full border-t shadow flex items-center justify-between p-2 sm:px-10 bg-black border-gray-600 font-amsterdam">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © @php echo date('Y') @endphp <a href="/" class="hover:underline">INNER.</a> Todos los derechos reservados.
        </span>
        <ul
            class="flex flex-wrap items-center justify-center text-sm font-medium text-gray-500 dark:text-gray-400 gap-6 sm:mt-0">
            <li>
                <a target="_blank" class="flex items-center hover:underline me-4 md:me-6"
                    href="{{ $linkInstagram }}">
                    <img class="w-5 mr-1" src="{{ asset('img/logo_instagram.png') }}" alt="Instagram">
                </a>
            </li>
            <li>
                <a target="_blank" class="flex items-center hover:underline me-4 md:me-6"
                    href="{{ $linkYoutube }}">
                    <img class="w-6 mr-1" src="{{ asset('img/logo_youtube.png') }}" alt="YouTube">
                </a>
            </li>
            <li>
                <a target="_blank" class="flex items-center hover:underline me-4 md:me-6"
                    href="{{ $linkSpotify }}">
                    <img class="w-5 mr-1" src="{{ asset('img/logo_spotify.png') }}" alt="Spotify">
                </a>
            </li>
            <li>
                <a target="_blank" class="flex items-center hover:underline me-4 md:me-6"
                    href="{{ $linkItunes }}">
                    <img class="w-5 mr-1" src="{{ asset('img/logo_apple.png') }}" alt="Apple Music">
                </a>
            </li>
        </ul>
    </footer>


    @if ($login ?? false)
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>

</html>
