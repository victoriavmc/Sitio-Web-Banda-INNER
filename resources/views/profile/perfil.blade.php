<x-Opciones>
    <div class="bg-cover" style="background-image: url('{{ asset('img/perfil_fondo.jpg') }}')">
        @if (session('alertInicioSesion'))
            <x-alerts :type="session('alertInicioSesion')['type']">
                {{ session('alertInicioSesion')['message'] }}
            </x-alerts>
        @endif

        @if (session('alertCambios'))
            <x-alerts :type="session('alertCambios')['type']">
                {{ session('alertCambios')['message'] }}
            </x-alerts>
        @endif
        <div class="flex justify-center items-center min-h-[85.5vh]">
            <div class="flex bg-white bg-opacity-70 justify-center p-6 gap-6">
                <div class="container mx-auto py-8">
                    <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
                        <div class="col-span-4 sm:col-span-3">
                            <div class="bg-white shadow rounded-lg p-6">
                                <div class="flex flex-col items-center">
                                    @if ($imagenPerfil)
                                        <img src='{{ asset(Storage::url($imagenPerfil)) }}'
                                            class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                                    @else
                                        <img src='{{ asset('img/logo_usuario.png') }}'
                                            class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                                    @endif

                                    <h1 class="text-gray-700 text-xl font-bold">
                                        {{ $nombreApellido }}
                                    </h1>
                                    <p class="text-gray-700">{{ $usuario->usuarioUser }}</p>
                                </div>
                                <hr class="my-6 border-t border-gray-300">
                                <div class="flex flex-col">
                                    <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Contenido
                                        Descargable
                                        como {{ $usuario->rol->rol }}</span>
                                    <ul>
                                        <li class="text-gray-700 mb-2">Escuchar</li>
                                        <li class="text-gray-700 mb-2">Fondos</li>
                                        <li class="text-gray-700 mb-2">Premium</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-4 sm:col-span-9">
                            <div class="bg-white shadow rounded-lg p-6">
                                <h2 class="text-xl font-bold mt-6 mb-4">Comentarios</h2>
                                <div class="mb-6">
                                    @if (count($comentariosConPublicacion) > 0)
                                        @foreach ($comentariosConPublicacion as $comentario)
                                            <div class="flex justify-between flex-wrap gap-2 w-full">
                                                <a href="{{ route('foroUnico', $comentario['idPublicacion']) }}">
                                                    <!-- Usar notación de array -->
                                                    <span
                                                        class="text-gray-700 italic">{{ $comentario['descripcion'] }}</span>
                                                    <p>
                                                        <span class="text-gray-700 mr-2">hecho en
                                                            {{ $comentario['publicacionTitulo'] }} el día
                                                            {{ $comentario['fechaComentario'] }}</span>
                                                    </p>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-gray-700">
                                            <p>El usuario no realizó comentarios todavía.</p>
                                        </div>
                                    @endif


                                </div>
                                <h2 class="text-xl font-bold mt-6 mb-4">Publicaciones</h2>
                                <div class="mb-6">
                                    @if (count($publicaciones) > 0)
                                        @foreach ($publicaciones as $publicacion)
                                            <a href="{{ route('foroUnico', $publicacion['idPublicacion']) }}">
                                                <div class="flex justify-between flex-wrap gap-2 w-full">
                                                    <span
                                                        class="text-gray-700 font-bold">{{ $publicacion['publicacionTitulo'] }}</span>
                                                </div>
                                                <p>
                                                    <span
                                                        class="text-gray-700 mr-2 italic">{{ $publicacion['descripcion'] }}</span>
                                                </p>
                                                <p>
                                                    <span class="text-gray-700 mr-2 italic">Hecho el:
                                                        {{ $publicacion['fechaPublicacion'] }}</span>
                                                </p>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="text-gray-700">
                                            <p>El usuario no presenta publicaciones.</p>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Opciones>
