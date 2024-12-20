<x-AppLayout>
    @error('password')
        <x-alerts type=Warning>
            {{ $message }}
        </x-alerts>
    @enderror

    <div class="absolute bg-gray-100">
        <div
            class="sidebar w-[3.35rem] h-[100vh] overflow-hidden border-r hover:w-64 hover:bg-white hover:shadow-lg transition-all duration-300">
            <div class="flex flex-col justify-between pt-2 pb-6">
                <div>
                    <ul class="mt-6 space-y-2 tracking-wide">
                        <li class="min-w-max">
                            <p aria-label="dashboard"
                                class="relative flex items-center space-x-4 bg-gradient-to-r from-black to-gray-600 px-2 py-3 text-white">
                                <img class="w-8" src="{{ asset('img/sidebar/logo_menu.webp') }}" alt="LogoMenu">
                                <span class="-mr-1 font-medium">Menu</span>
                            </p>
                        </li>
                        <li class="min-w-max">
                            <a href="{{ route('perfil') }}"
                                class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600 
                                {{ Request::is('perfil') ? 'text-red-500' : '' }}">
                                <svg class="-ml-1 h-6 w-6" viewBox="0 0 24 24" fill="none">
                                    <defs>
                                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%"
                                            y2="0%">
                                            <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:rgb(255,255,255);stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <path
                                        d="M6 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8ZM6 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-1Z"
                                        fill="{{ Request::is('perfil') ? '#EF4444' : 'url(#grad1)' }}"></path>
                                    <path d="M13 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2V8Z"
                                        fill="{{ Request::is('perfil') ? '#EF4444' : 'url(#grad1)' }}"></path>
                                    <path d="M13 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-1Z"
                                        fill="{{ Request::is('perfil') ? '#EF4444' : 'url(#grad1)' }}"></path>
                                </svg>
                                <span
                                    class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('perfil') ? 'text-red-500' : 'text-gray-600' }}">Información
                                    de Perfil</span>
                            </a>
                        </li>
                        <li class="min-w-max">
                            <a href="{{ route('modificar-perfil') }}"
                                class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 group-hover:fill-red-500 {{ Request::is('modificar-perfil') ? 'text-red-500' : 'text-gray-600' }}"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span
                                    class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('modificar-perfil') ? 'text-red-500' : 'text-gray-600' }}">Modificar
                                    Perfil</span>
                            </a>
                        </li>
                        @if ($rol == 3)
                            <li class="min-w-max">
                                <a href="{{ route('orden-de-pago') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path class="fill-current text-gray-300 group-hover:text-red-300"
                                            d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path class="fill-current text-gray-600 group-hover:text-red-500"
                                            fill-rule="evenodd"
                                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('suscripcion') ? 'text-red-500' : 'text-gray-600' }}">Comprobantes
                                        de Pago</span>
                                </a>
                            </li>
                        @elseif ($rol == 4)
                            <li class="min-w-max">
                                <a href="{{ route('underConstruction') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path class="fill-current text-gray-300 group-hover:text-red-300"
                                            d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path class="fill-current text-gray-600 group-hover:text-red-500"
                                            fill-rule="evenodd"
                                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('suscripcion') ? 'text-red-500' : 'text-gray-600' }}">Suscripción</span>
                                </a>
                            </li>
                        @endif
                        <li class="min-w-max">
                            <a href="{{ route('notificaciones') }}"
                                class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20">
                                    <path
                                        class="fill-current group-hover:fill-red-500 {{ Request::is('notificaciones') ? 'text-red-500' : 'text-gray-600' }}"
                                        d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                    <path
                                        class="fill-current group-hover:fill-red-300 {{ Request::is('notificaciones') ? 'text-red-300' : 'text-gray-300' }}"
                                        d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                </svg>
                                <span
                                    class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('notificaciones') ? 'text-red-500' : 'text-gray-600' }}">Preferencia
                                    de
                                    Notificaciones</span>
                            </a>
                        </li>
                        @if ($rol == 1 || $rol == 2)
                            <li class="min-w-max">
                                <a href="{{ route('modificar-redes') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            class="fill-current group-hover:fill-red-500 {{ Request::is('modificar-redes') ? 'text-red-500' : 'text-gray-600' }}"
                                            fill-rule="evenodd"
                                            d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z"
                                            clip-rule="evenodd" />
                                        <path
                                            class="fill-current group-hover:fill-red-300 {{ Request::is('modificar-redes') ? 'text-red-300' : 'text-gray-300' }}"
                                            d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('modificar-redes') ? 'text-red-500' : 'text-gray-600' }}">Modificar
                                        Redes Sociales</span>
                                </a>
                            </li>
                        @endif
                        @if ($rol == 3 || $rol == 4)
                            <li class="min-w-max">
                                <form action="{{ route('eliminar-cuenta') }}" method="POST" id="btnEliminarCuenta">
                                    @method('delete')
                                    @csrf
                                    <button class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600"
                                        type="submit">
                                        <svg class="w-5 h-5 text-gray-800 dark:text-white group-hover:text-red-500"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <span
                                            class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('modificar-redes') ? 'text-red-500' : 'text-gray-600' }}">Eliminar
                                            Cuenta</span>
                                    </button>
                                </form>
                            </li>
                        @endif
                        <hr>
                        @if ($rol == 1)
                            <li class="min-w-max">
                                <p aria-label="dashboard"
                                    class="relative flex items-center space-x-4 bg-gradient-to-r from-black to-gray-600 px-2.5 py-3 text-white">
                                    <img class="w-7" src="{{ asset('img/sidebar/logo_administracion.webp') }}"
                                        alt="">
                                    <span class="-mr-1 font-medium">Administracion</span>
                                </p>
                            </li>
                            <li class="min-w-max">
                                <a href="{{ route('panel-de-staff') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            class="fill-current group-hover:text-red-300 {{ Request::is('panel-de-staff') ? 'text-red-300' : 'text-gray-300' }}"
                                            fill-rule="evenodd"
                                            d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1H8a3 3 0 00-3 3v1.5a1.5 1.5 0 01-3 0V6z"
                                            clip-rule="evenodd" />
                                        <path
                                            class="fill-current group-hover:text-red-500 {{ Request::is('panel-de-staff') ? 'text-red-500' : 'text-gray-600' }}"
                                            d="M6 12a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H2h2a2 2 0 002-2v-2z" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('panel-de-staff') ? 'text-red-500' : 'text-gray-600' }}">Panel
                                        de Staffs</span>
                                </a>
                            </li>
                            <li class="min-w-max">
                                <a href="{{ route('panel-de-usuarios') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 group-hover:fill-red-500 {{ Request::is('panel-de-usuarios') ? 'fill-red-500' : '' }}"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('panel-de-usuarios') ? 'text-red-500' : 'text-gray-600' }}">Panel
                                        de Usuario</span>
                                </a>
                            </li>
                            <li class="min-w-max">
                                <a href="{{ route('comprobantes.listar') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            class="fill-current group-hover:text-red-500 {{ Request::is('panel-de-underConstruction') ? 'text-red-300' : 'text-gray-600' }}"
                                            d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                        <path
                                            class="fill-current group-hover:text-red-300 {{ Request::is('panel-de-underConstruction') ? 'text-red-500' : 'text-gray-300' }}"
                                            d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('analiticas') ? 'text-red-500' : 'text-gray-600' }}">Ordenes
                                        de Compra
                                    </span>
                                </a>
                            </li>
                            <li class="min-w-max">
                                <a href="{{ route('superFan') }}"
                                    class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path class="fill-current text-gray-300 group-hover:text-red-300"
                                            d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path class="fill-current text-gray-600 group-hover:text-red-500"
                                            fill-rule="evenodd"
                                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="-mr-1 font-medium group-hover:text-red-500 {{ Request::is('suscripcion') ? 'text-red-500' : 'text-gray-600' }}">Manejar
                                        Acceso Exclusivo
                                    </span>
                                </a>
                            </li>
                            <hr>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{ $slot }}
</x-AppLayout>
