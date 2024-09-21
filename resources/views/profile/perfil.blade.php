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
        <div class="flex justify-center items-center h-[85.5vh]">
            <div class="flex bg-white bg-opacity-70 justify-center p-6 gap-6">
                <div class="container mx-auto py-8">
                    <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
                        <div class="col-span-4 sm:col-span-3">
                            <div class="bg-white shadow rounded-lg p-6">
                                <div class="flex flex-col items-center">
                                    @php
                                        // Guardo el id del usuario
                                        $idUser = $usuario->idusuarios;

                                        // Ahora busco en la tabla revisionImagenes
                                        $imagenPerfil = DB::table('revisionimagenes')
                                            ->where('usuarios_idusuarios', $idUser)
                                            ->where('tipodefoto_idtipoDeFoto', 1)
                                            ->first();

                                        if ($imagenPerfil) {
                                            $idImagenP = $imagenPerfil->imagenes_idimagenes;

                                            // Ahora busco la imagen en la tabla imagenes
                                            $ubicacionImagen = DB::table('imagenes')
                                                ->where('idimagenes', $idImagenP)
                                                ->first();

                                            $ubicarImagen = $ubicacionImagen ? $ubicacionImagen->subidaImg : null;
                                        } else {
                                            $ubicarImagen = null; // Inicializo la variable
                                        }
                                    @endphp

                                    @if ($ubicarImagen)
                                        <img src='{{ asset(Storage::url($ubicarImagen)) }}'
                                            class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                                    @else
                                        <img src='{{ asset('img/logo_usuario.png') }}'
                                            class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                                    @endif

                                    <h1 class="text-gray-700 text-xl font-bold">
                                        {{ $usuario->datospersonales->nombreDP . ' ' . $usuario->datospersonales->apellidoDP }}
                                    </h1>
                                    <p class="text-gray-700">{{ $usuario->usuarioUser }}</p>
                                </div>
                                <hr class="my-6 border-t border-gray-300">
                                <div class="flex flex-col">
                                    <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Contenido
                                        Descargable
                                        como {{ $usuario->roles->rol }}</span>
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
                                    <div class="flex justify-between flex-wrap gap-2 w-full">
                                        <span class="text-gray-700 italic">breve comentario de 30 caracteres
                                            max</span>
                                        <p>
                                            <span class="text-gray-700 mr-2">hecho en TITULO dia Fecha</span>
                                        </p>
                                    </div>
                                </div>
                                <h2 class="text-xl font-bold mt-6 mb-4">Publicaciones</h2>
                                <div class="mb-6">
                                    <div class="flex justify-between flex-wrap gap-2 w-full">
                                        <span class="text-gray-700 font-bold">Titulo de la publicacion</span>

                                    </div>
                                    <p>
                                        <span class="text-gray-700 mr-2 italic">breve descripcion de 30 caracteres
                                            max</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Opciones>
