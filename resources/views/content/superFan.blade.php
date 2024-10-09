<x-AppLayout>

    @if (session('alertRegistro'))
        {{-- Componente de alerta para el registro exitoso o fallido --}}
        <x-alerts :type="session('alertRegistro')['type']">
            {{ session('alertRegistro')['message'] }}
        </x-alerts>
    @endif

    <!-- Fondo de pantalla completo -->
    <div class="relative min-h-screen flex flex-col gap-10 p-5 bg-cover"
        style="background-image: url({{ asset('img/superfan_fondo.png') }})">

        {{-- SI ES INVITADO --}}
        @guest
            {{-- Encabezado central --}}
            <div class="text-center">
                <h1
                    class="text-transparent bg-clip-text bg-gradient-to-r from-black to-white text-5xl font-extrabold drop-shadow-lg">
                    ¡Privilegios para Fans!
                </h1>
            </div>

            <div class="grid grid-cols-2 h-full gap-4 z-10 relative">
                {{-- Lado Izquierdo Fans --}}
                <div class="flex flex-col gap-10">
                    <div class="text-black text-2xl">
                        Beneficios para Fans
                        <ul class="list-none pl-0">
                            <li>Registrate y podras tener:</li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                Acceso para leer contenido del foro y comentarios.
                            </li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                Descargar 3 imágenes exclusivas de fondo
                            </li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                Descargar 1 canción disponible
                            </li>
                            {{-- <li>- Reaccionar con "like" o "dislike" (sin poder comentar)</li> --}}
                        </ul>
                        <div class="text-center mt-4">
                            <a href={{ route('registro') }} class='text-black'>
                                <button
                                    class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                    ¡Regístrate Gratis!
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="flex w-full">
                        <img src="{{ asset('img/superfan_ladoIzq.png') }}" alt="Lado Izquierdo" class="w-3/4">
                    </div>
                </div>

                {{-- Lado Derecho - SuperFans --}}
                <div class="text-white text-2xl">Beneficios para SuperFans
                    <ul class="list-none pl-0">
                        <li>Ya registrado si te suscribis podras:</li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M9.713 3.64c.581-.495.872-.743 1.176-.888a2.58 2.58 0 0 1 2.222 0c.304.145.595.393 1.176.888c.599.51 1.207.768 2.007.831c.761.061 1.142.092 1.46.204c.734.26 1.312.837 1.571 1.572c.112.317.143.698.204 1.46c.063.8.32 1.407.83 2.006c.496.581.744.872.889 1.176c.336.703.336 1.52 0 2.222c-.145.304-.393.595-.888 1.176a3.3 3.3 0 0 0-.831 2.007c-.061.761-.092 1.142-.204 1.46a2.58 2.58 0 0 1-1.572 1.571c-.317.112-.698.143-1.46.204c-.8.063-1.407.32-2.006.83c-.581.496-.872.744-1.176.889a2.58 2.58 0 0 1-2.222 0c-.304-.145-.595-.393-1.176-.888a3.3 3.3 0 0 0-2.007-.831c-.761-.061-1.142-.092-1.46-.204a2.58 2.58 0 0 1-1.571-1.572c-.112-.317-.143-.698-.204-1.46a3.3 3.3 0 0 0-.83-2.006c-.496-.581-.744-.872-.89-1.176a2.58 2.58 0 0 1 .001-2.222c.145-.304.393-.595.888-1.176c.52-.611.769-1.223.831-2.007c.061-.761.092-1.142.204-1.46a2.58 2.58 0 0 1 1.572-1.571c.317-.112.698-.143 1.46-.204a3.3 3.3 0 0 0 2.006-.83" />
                                    <path
                                        d="M12.5 14.5V8.6a.6.6 0 0 1 .6-.6h1.4m-2 6.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0" />
                                </g>
                            </svg>
                            Crear contenido y comentar en el foro.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M9.713 3.64c.581-.495.872-.743 1.176-.888a2.58 2.58 0 0 1 2.222 0c.304.145.595.393 1.176.888c.599.51 1.207.768 2.007.831c.761.061 1.142.092 1.46.204c.734.26 1.312.837 1.571 1.572c.112.317.143.698.204 1.46c.063.8.32 1.407.83 2.006c.496.581.744.872.889 1.176c.336.703.336 1.52 0 2.222c-.145.304-.393.595-.888 1.176a3.3 3.3 0 0 0-.831 2.007c-.061.761-.092 1.142-.204 1.46a2.58 2.58 0 0 1-1.572 1.571c-.317.112-.698.143-1.46.204c-.8.063-1.407.32-2.006.83c-.581.496-.872.744-1.176.889a2.58 2.58 0 0 1-2.222 0c-.304-.145-.595-.393-1.176-.888a3.3 3.3 0 0 0-2.007-.831c-.761-.061-1.142-.092-1.46-.204a2.58 2.58 0 0 1-1.571-1.572c-.112-.317-.143-.698-.204-1.46a3.3 3.3 0 0 0-.83-2.006c-.496-.581-.744-.872-.89-1.176a2.58 2.58 0 0 1 .001-2.222c.145-.304.393-.595.888-1.176c.52-.611.769-1.223.831-2.007c.061-.761.092-1.142.204-1.46a2.58 2.58 0 0 1 1.572-1.571c.317-.112.698-.143 1.46-.204a3.3 3.3 0 0 0 2.006-.83" />
                                    <path
                                        d="M12.5 14.5V8.6a.6.6 0 0 1 .6-.6h1.4m-2 6.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0" />
                                </g>
                            </svg>
                            Descargar todos los fondos de pantalla disponibles.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M9.713 3.64c.581-.495.872-.743 1.176-.888a2.58 2.58 0 0 1 2.222 0c.304.145.595.393 1.176.888c.599.51 1.207.768 2.007.831c.761.061 1.142.092 1.46.204c.734.26 1.312.837 1.571 1.572c.112.317.143.698.204 1.46c.063.8.32 1.407.83 2.006c.496.581.744.872.889 1.176c.336.703.336 1.52 0 2.222c-.145.304-.393.595-.888 1.176a3.3 3.3 0 0 0-.831 2.007c-.061.761-.092 1.142-.204 1.46a2.58 2.58 0 0 1-1.572 1.571c-.317.112-.698.143-1.46.204c-.8.063-1.407.32-2.006.83c-.581.496-.872.744-1.176.889a2.58 2.58 0 0 1-2.222 0c-.304-.145-.595-.393-1.176-.888a3.3 3.3 0 0 0-2.007-.831c-.761-.061-1.142-.092-1.46-.204a2.58 2.58 0 0 1-1.571-1.572c-.112-.317-.143-.698-.204-1.46a3.3 3.3 0 0 0-.83-2.006c-.496-.581-.744-.872-.89-1.176a2.58 2.58 0 0 1 .001-2.222c.145-.304.393-.595.888-1.176c.52-.611.769-1.223.831-2.007c.061-.761.092-1.142.204-1.46a2.58 2.58 0 0 1 1.572-1.571c.317-.112.698-.143 1.46-.204a3.3 3.3 0 0 0 2.006-.83" />
                                    <path
                                        d="M12.5 14.5V8.6a.6.6 0 0 1 .6-.6h1.4m-2 6.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0" />
                                </g>
                            </svg>
                            Descargar todas las canciones disponibles.
                        </li>
                        {{-- <li>- Reaccionar con "like" o "dislike" (sin poder comentar)</li> --}}
                    </ul>
                    <p class="text-center text-2xl text-red-600 font-bold">
                        Precio: $16
                    </p>
                    <div class="flex justify-center">
                        <a href={{ route('underConstruction') }} class='text-black'>
                            <button
                                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                ¡Accede a Contenido Premium!
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        @endguest
        <!-- Contenido para usuarios autenticados -->
        @auth
            {{-- En caso de ser 1 o 2 --}}
            @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                <div class="grid grid-cols-2 gap-4  z-10 relative">
                    <div class="text-black text-2xl">
                        <p>Selecciona cómo deseas ver:</p>
                        {{-- <form action="{{ route('') }}" method="POST"> --}}
                        {{-- @csrf --}}
                        <select name="vista" onchange="this.form.submit()">
                            <option value="1" selected>Invitado</option>
                            <option value="3">Fan</option>
                            <option value="4">SuperFan</option>
                        </select>
                        {{-- </form> --}}
                    </div>
                </div>
                {{-- En caso de ser 4 --}}
            @elseif (Auth::user()->rol->idrol == 4)
                <div class="grid grid-cols-2 gap-4  z-10 relative">

                    {{-- Lado Izquierdo Descargas --}}
                    <div class="text-black text-2xl">
                        Gracias por ser Fan!
                        <ul class="list-none pl-0">
                            <li>Descargas Gratuitas:</li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                D1 Img. / D3
                            </li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                Descargar 1 canción disponible
                            </li>
                        </ul>
                        <div class="flex ">
                            <img src="{{ asset('img/superfan_ladoIzq.png') }}" alt="Lado Izquierdo" class="object-cover">
                        </div>
                    </div>

                    {{-- Lado Derecho - SuperFans --}}
                    <div class="text-white text-2xl">Beneficios para SuperFans
                        <ul class="list-none pl-0">
                            <li>Ya registrado si te suscribis podras:</li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5">
                                        <path
                                            d="M9.713 3.64c.581-.495.872-.743 1.176-.888a2.58 2.58 0 0 1 2.222 0c.304.145.595.393 1.176.888c.599.51 1.207.768 2.007.831c.761.061 1.142.092 1.46.204c.734.26 1.312.837 1.571 1.572c.112.317.143.698.204 1.46c.063.8.32 1.407.83 2.006c.496.581.744.872.889 1.176c.336.703.336 1.52 0 2.222c-.145.304-.393.595-.888 1.176a3.3 3.3 0 0 0-.831 2.007c-.061.761-.092 1.142-.204 1.46a2.58 2.58 0 0 1-1.572 1.571c-.317.112-.698.143-1.46.204c-.8.063-1.407.32-2.006.83c-.581.496-.872.744-1.176.889a2.58 2.58 0 0 1-2.222 0c-.304-.145-.595-.393-1.176-.888a3.3 3.3 0 0 0-2.007-.831c-.761-.061-1.142-.092-1.46-.204a2.58 2.58 0 0 1-1.571-1.572c-.112-.317-.143-.698-.204-1.46a3.3 3.3 0 0 0-.83-2.006c-.496-.581-.744-.872-.89-1.176a2.58 2.58 0 0 1 .001-2.222c.145-.304.393-.595.888-1.176c.52-.611.769-1.223.831-2.007c.061-.761.092-1.142.204-1.46a2.58 2.58 0 0 1 1.572-1.571c.317-.112.698-.143 1.46-.204a3.3 3.3 0 0 0 2.006-.83" />
                                        <path
                                            d="M12.5 14.5V8.6a.6.6 0 0 1 .6-.6h1.4m-2 6.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0" />
                                    </g>
                                </svg>
                                Crear contenido y comentar en el foro.
                            </li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5">
                                        <path
                                            d="M9.713 3.64c.581-.495.872-.743 1.176-.888a2.58 2.58 0 0 1 2.222 0c.304.145.595.393 1.176.888c.599.51 1.207.768 2.007.831c.761.061 1.142.092 1.46.204c.734.26 1.312.837 1.571 1.572c.112.317.143.698.204 1.46c.063.8.32 1.407.83 2.006c.496.581.744.872.889 1.176c.336.703.336 1.52 0 2.222c-.145.304-.393.595-.888 1.176a3.3 3.3 0 0 0-.831 2.007c-.061.761-.092 1.142-.204 1.46a2.58 2.58 0 0 1-1.572 1.571c-.317.112-.698.143-1.46.204c-.8.063-1.407.32-2.006.83c-.581.496-.872.744-1.176.889a2.58 2.58 0 0 1-2.222 0c-.304-.145-.595-.393-1.176-.888a3.3 3.3 0 0 0-2.007-.831c-.761-.061-1.142-.092-1.46-.204a2.58 2.58 0 0 1-1.571-1.572c-.112-.317-.143-.698-.204-1.46a3.3 3.3 0 0 0-.83-2.006c-.496-.581-.744-.872-.89-1.176a2.58 2.58 0 0 1 .001-2.222c.145-.304.393-.595.888-1.176c.52-.611.769-1.223.831-2.007c.061-.761.092-1.142.204-1.46a2.58 2.58 0 0 1 1.572-1.571c.317-.112.698-.143 1.46-.204a3.3 3.3 0 0 0 2.006-.83" />
                                        <path
                                            d="M12.5 14.5V8.6a.6.6 0 0 1 .6-.6h1.4m-2 6.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0" />
                                    </g>
                                </svg>
                                Descargar todos los fondos de pantalla disponibles.
                            </li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5">
                                        <path
                                            d="M9.713 3.64c.581-.495.872-.743 1.176-.888a2.58 2.58 0 0 1 2.222 0c.304.145.595.393 1.176.888c.599.51 1.207.768 2.007.831c.761.061 1.142.092 1.46.204c.734.26 1.312.837 1.571 1.572c.112.317.143.698.204 1.46c.063.8.32 1.407.83 2.006c.496.581.744.872.889 1.176c.336.703.336 1.52 0 2.222c-.145.304-.393.595-.888 1.176a3.3 3.3 0 0 0-.831 2.007c-.061.761-.092 1.142-.204 1.46a2.58 2.58 0 0 1-1.572 1.571c-.317.112-.698.143-1.46.204c-.8.063-1.407.32-2.006.83c-.581.496-.872.744-1.176.889a2.58 2.58 0 0 1-2.222 0c-.304-.145-.595-.393-1.176-.888a3.3 3.3 0 0 0-2.007-.831c-.761-.061-1.142-.092-1.46-.204a2.58 2.58 0 0 1-1.571-1.572c-.112-.317-.143-.698-.204-1.46a3.3 3.3 0 0 0-.83-2.006c-.496-.581-.744-.872-.89-1.176a2.58 2.58 0 0 1 .001-2.222c.145-.304.393-.595.888-1.176c.52-.611.769-1.223.831-2.007c.061-.761.092-1.142.204-1.46a2.58 2.58 0 0 1 1.572-1.571c.317-.112.698-.143 1.46-.204a3.3 3.3 0 0 0 2.006-.83" />
                                        <path
                                            d="M12.5 14.5V8.6a.6.6 0 0 1 .6-.6h1.4m-2 6.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0" />
                                    </g>
                                </svg>
                                Descargar todas las canciones disponibles.
                            </li>
                            {{-- <li>- Reaccionar con "like" o "dislike" (sin poder comentar)</li> --}}
                        </ul>
                        <p class="text-center text-2xl text-red-600 font-bold">
                            Precio: $16
                        </p>
                        <div class="flex justify-center">
                            <a href={{ route('underConstruction') }} class='text-black'>
                                <button
                                    class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                    ¡Accede a Contenido Premium!
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- En caso de ser 3 --}}
            @elseif (Auth::user()->rol->idrol == 3)
                <div class="grid grid-cols-2 gap-4  z-10 relative">

                    {{-- Lado Izquierdo Descargas --}}
                    <div class="text-black text-2xl">
                        Gracias por ser SuperFan!
                        <ul class="list-none pl-0">
                            <li>Descargas Premium:</li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                Imagenes disponible.(Varias)
                            </li>
                            <li class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 32 32">
                                    <g fill="black">
                                        <path
                                            d="m13.735 19.496l-1.53-1.53a.61.61 0 0 0-.85 0a.61.61 0 0 0 0 .85l1.53 1.53c.23.23.61.23.85 0s.24-.61 0-.85m-3.54.49l1.53 1.53c.23.23.23.61 0 .85a.61.61 0 0 1-.85 0l-1.53-1.53a.61.61 0 0 1 0-.85a.61.61 0 0 1 .85 0" />
                                        <path
                                            d="M27.485 2.416a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.16.368l-.933.43l-.157-.358a.58.58 0 0 1-.01-.41c.04-.14.04-.31-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.164.375l-.943.435l-.16-.37a.53.53 0 0 1-.01-.41a.64.64 0 0 0-.02-.47a.683.683 0 0 0-.9-.36c-.35.15-.51.55-.36.9c.07.16.19.27.34.34c.13.06.24.15.3.28l.167.386l-.378.174a.78.78 0 0 0-.233 1.157l-.077-.077l-8.558 8.558a3.37 3.37 0 0 1 .728-3.588c.6-.61.63-1.59.03-2.2s-1.59-.61-2.19-.01c-.93.93-1.52 2.08-1.76 3.29c-.27 1.36-1.42 2.35-2.8 2.48c-1.66.15-3.27.86-4.53 2.13c-2.83 2.86-2.79 7.57.1 10.37c2.85 2.77 7.41 2.74 10.23-.08a7.3 7.3 0 0 0 2.1-4.53a3.1 3.1 0 0 1 2.49-2.77c.55-.11 1.09-.3 1.61-.56c.76-.38 1.07-1.31.69-2.07a1.546 1.546 0 0 0-2.07-.69a3.34 3.34 0 0 1-2.755.115l8.562-8.561a.78.78 0 0 0 1.143-.134l1.08-1.81c.12-.2.36-.29.58-.2c.57.22 1.24.1 1.68-.38c.54-.58.55-1.49.02-2.07c-.5-.549-1.206-.578-1.892-.293l-.158-.347a.58.58 0 0 1-.01-.41c.06-.15.06-.32-.01-.48m-14.28 12.78c.306.177.526.473.604.826l-.164.164c-.25.25-.25.65 0 .89l.99.99c.244.244.631.25.873.018c.29.078.735.141 1.023.182l.204.03q.037.007.07.01t.07.01l.017.002c.196.022.753.085 1.403-.042q.063-.011.128-.025c.367-.074.795-.16.982.375c.07.18.01.39-.25.56c-.15.1-.52.24-.69.28c-.82.19-1.4.52-1.94 1.11c-.72.68-1.16 1.5-1.32 2.39c-.12.68-.24 1.35-.52 1.97c-.3.64-.7 1.22-1.21 1.73c-.58.59-1.26 1.03-2.01 1.33c-.7.28-1.51-.05-1.78-.75c-.06-.15-.09-.32-.09-.48c.003-.252.063-.535.126-.832c.16-.751.338-1.594-.336-2.268l-2.25-2.25c-1-1-1.02-2.63-.03-3.65l.02-.02c.79-.8 1.83-1.21 2.92-1.25c.65-.03 1.21-.36 1.52-.87c.25-.41.71-.63 1.18-.58c.16.02.32.07.46.15m-3.84 9.57c.1.1.1.26-.01.35l-1.06 1.06c-.1.1-.26.1-.36 0l-2.41-2.41c-.1-.1-.1-.26 0-.36l1.07-1.05c.1-.1.26-.1.36 0z" />
                                    </g>
                                </svg>
                                Canciónes disponible.(Varias)
                            </li>
                        </ul>
                        <div class="flex ">
                            <img src="{{ asset('img/superfan_ladoIzq.png') }}" alt="Lado Izquierdo" class="object-cover">
                        </div>
                    </div>

                    {{-- Lado Derecho - SuperFans --}}
                    <div class="text-white text-2xl">Gracias por ser parte de nuestra comunidad!
                    </div>
                </div>
            @endif
        @endauth
    </div>
</x-AppLayout>
