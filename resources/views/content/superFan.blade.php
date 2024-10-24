<x-AppLayout>
    @if (session('alertRegistro'))
        {{-- Componente de alerta para el registro exitoso o fallido --}}
        <x-alerts :type="session('alertRegistro')['type']">
            {{ session('alertRegistro')['message'] }}
        </x-alerts>
    @endif
    <div class="relative min-h-screen flex flex-col gap-10 p-5 bg-cover">
        {{-- Si es invitado --}}
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
                                Descargar 3 Imágenes Exclusivas.
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
                                Descargar 1 Canción Disponible.
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
                                Descargar 1 Video Exclusivo.
                            </li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href={{ route('registro') }} class='text-black'>
                                <button
                                    class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                    ¡Regístrate Gratis!
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Lado Derecho SuperFan --}}
                <x-lado-derecho>
                </x-lado-derecho>
            </div>
        @endguest
        <!-- Contenido para usuarios autenticados -->
        {{-- {{ dd($media) }} --}}
        @auth
            {{-- En caso de ser 1 o 2 --}}
            @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                <a href={{ route('descargas') }}>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                        Manejar Descargas
                    </button>
                </a>
                <a href={{ route('descargas') }}>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                        Manejar Precio
                    </button>
                </a>
            @elseif (Auth::user()->rol->idrol == 4)
                <div class="grid grid-cols-2 h-full gap-4 z-10 relative">
                    {{-- Lado Izquierdo Fans --}}
                    <div class="text-black text-2xl">
                        Gracias por ser Fan!
                        <ul class="list-none pl-0 p-4">
                            <li>Descargas Gratuitas:</li>
                        </ul>
                        @php
                            $contadorImagenes = 0; // Contador para las imágenes
                            $contadorVideos = 0; // Contador para los videos
                            $contadorCanciones = 0; // Contador para los Canciones
                        @endphp
                        <div class="p-5 sm:p-8">
                            <div
                                class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                                @foreach ($media as $item)
                                    @if ($item['tipo'] == 'Imagen' && $contadorImagenes < 3)
                                        <div
                                            class="imagen-modal cursor-pointer h-24 w-24 overflow-hidden rounded-lg ring-2 ring-gray-700 dark:ring-gray-100">
                                            <img src="{{ asset(Storage::url($item['ruta'])) }}" alt="{{ $item['id'] }}" />
                                        </div>
                                        {{-- Boton para descargar automaticamente --}}
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ asset(Storage::url($item['ruta'])) }}" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="black"
                                                        d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                                </svg>
                                            </a>
                                        </div>
                                        @php
                                            $contadorImagenes++; // Incrementar contador de imágenes solo cuando se muestra una
                                        @endphp
                                    @elseif ($item['tipo'] == 'Video' && $contadorVideos < 1)
                                        <video class="h-24 w-24 imagen-modal cursor-pointer" controls>
                                            <source src="{{ asset(Storage::url($item['ruta'])) }}" type="video/mp4"
                                                alt="{{ $item['id'] }}">
                                            Tu navegador no soporta el elemento de video.
                                        </video>
                                        {{-- Boton para descargar automaticamente --}}
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ asset(Storage::url($item['ruta'])) }}" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="black"
                                                        d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                                </svg>
                                            </a>
                                        </div>
                                        @php
                                            $contadorVideos++; // Incrementar contador de videos solo cuando se muestra uno
                                        @endphp
                                    @elseif ($item['tipo'] == 'Cancion' && $contadorCanciones < 1)
                                        <div
                                            class="imagen-modal cursor-pointer h-24 w-24 overflow-hidden rounded-lg ring-2 ring-gray-700 dark:ring-gray-100">
                                            <img src="{{ asset(Storage::url($item['fotoAlbum'])) }}"
                                                alt="{{ $item['id'] }}" />
                                        </div>
                                        <h1>{{ $item['tituloAlbum'] }}</h1>
                                        {{-- Boton para descargar automaticamente --}}
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ asset(Storage::url($item['ruta'])) }}" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="black"
                                                        d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                                </svg>
                                            </a>
                                        </div>
                                        @php
                                            $contadorCanciones++; // Incrementar contador de canciones
                                        @endphp
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Lado Derecho SuperFan --}}
                    <x-lado-derecho>
                    </x-lado-derecho>
                </div>
            @elseif (Auth::user()->rol->idrol == 3)
                <div class="grid grid-cols-2 h-full gap-4 z-10 relative">
                    {{-- Lado Izquierdo Fans --}}
                    <div class="text-black text-2xl">
                        Gracias por ser SuperFan!
                        <ul class="list-none pl-0">
                            <li>Descargas Premium:</li>
                        </ul>
                        <div class="p-5 sm:p-8">
                            <div
                                class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                                @foreach ($media as $item)
                                    @if ($item['tipo'] == 'Imagen')
                                        <div
                                            class="imagen-modal cursor-pointer h-24 w-24 overflow-hidden rounded-lg ring-2 ring-gray-700 dark:ring-gray-100">
                                            <img src="{{ asset(Storage::url($item['ruta'])) }}"
                                                alt="{{ $item['id'] }}" />
                                        </div>
                                        {{-- Boton para descargar automaticamente --}}
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ asset(Storage::url($item['ruta'])) }}" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="black"
                                                        d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                                </svg>
                                            </a>
                                        </div>
                                    @elseif ($item['tipo'] == 'Video')
                                        <video class="h-24 w-24 imagen-modal cursor-pointer" controls>
                                            <source src="{{ asset(Storage::url($item['ruta'])) }}" type="video/mp4"
                                                alt="{{ $item['id'] }}">
                                            Tu navegador no soporta el elemento de video.
                                        </video>
                                        {{-- Boton para descargar automaticamente --}}
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ asset(Storage::url($item['ruta'])) }}" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="black"
                                                        d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                                </svg>
                                            </a>
                                        </div>
                                    @elseif ($item['tipo'] == 'Cancion')
                                        <div
                                            class="imagen-modal cursor-pointer h-24 w-24 overflow-hidden rounded-lg ring-2 ring-gray-700 dark:ring-gray-100">
                                            <img src="{{ asset(Storage::url($item['fotoAlbum'])) }}"
                                                alt="{{ $item['id'] }}" />
                                        </div>

                                        <h1>{{ $item['tituloAlbum'] }}</h1>

                                        {{-- Boton para descargar automaticamente --}}
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ asset(Storage::url($item['ruta'])) }}" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="black"
                                                        d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                    {{-- Lado Derecho - SuperFans --}}
                    <div class="text-2xl">Gracias por ser parte de nuestra comunidad!
                    </div>
                </div>
            @endif
        @endauth
    </div>
    <!-- Contenedor del modal -->
    <div id="modal" class="hidden imagenG">
        <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>
</x-AppLayout>
