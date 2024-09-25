<x-AppLayout>
    <!-- Fondo de pantalla completo -->
    <div class="relative h-screen">
        <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('img/superfan_fondo.png') }}"
            alt="FondoSuperFan">

        {{-- Encabezado central --}}
        <div class="relative top-10 w-full text-center">
            <h1
                class="text-transparent bg-clip-text bg-gradient-to-r from-black to-white text-5xl font-extrabold drop-shadow-lg">
                ¡Privilegios para Fans!
            </h1>
        </div>

        <!-- Contenido sobre el fondo, dividido en dos columnas -->
        <div class="relative mt-8 h-full grid grid-cols-2 gap-6 p-6">

            {{-- Lado Izquierdo - Fans --}}
            <div class="p-6 rounded-lg shadow-lg flex flex-col justify-between">
                <h1 class="text-3xl font-bold text-black text-center mb-4">Beneficios para Fans</h1>
                <ul class="text-lg text-black space-y-3">
                    <li>Registrate y podras tener:</li>
                    <li>- Acceso para leer contenido del foro</li>
                    <li>- Reaccionar con "like" o "dislike" (sin poder comentar)</li>
                    <li>- Descargar 3 imágenes exclusivas de fondo</li>
                    <li>- Descargar 1 canción disponible</li>
                </ul>
                <div class="text-center mt-4">
                    <a href={{ route('login') }} class='text-black
                    '><i></i>
                        ¡Regístrate Gratis!
                    </a>
                </div>
                <div class="flex ">
                    <img src="{{ asset('img/superfan_ladoIzq.png') }}" alt="Lado Izquierdo" class="object-cover">
                </div>
            </div>

            {{-- Lado Derecho - SuperFans --}}
            <div class="p-6 rounded-lg shadow-lg flex flex-col justify-between">
                <h2 class="text-3xl font-bold text-center mb-4">Beneficios para SuperFans</h2>
                <ul class="text-lg text-white space-y-3">
                    <li>Ya registrado si te suscribis podras:</li>
                    <li>- Crear contenido y comentar en el foro</li>
                    <li>- Descargar todos los fondos de pantalla disponibles</li>
                    <li>- Descargar todas las canciones disponibles</li>
                </ul>
                <p class="text-center text-2xl text-red-600 font-bold">
                    Precio: $16
                </p>
                <div class="flex justify-center">
                    <a href={{ route('login') }} class='text-white
                    '><i></i>
                        ¡Accede a Contenido Premium!
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-AppLayout>
