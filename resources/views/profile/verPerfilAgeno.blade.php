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
        <div class="p-10">
            <div class="flex max-h-max bg-white bg-opacity-70 justify-center p-6 gap-6">

                {{-- Antes ver --}}
                <div class="bg-gray-100">
                    <div class="container mx-auto py-8">
                        <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
                            <div class="col-span-4 sm:col-span-3">
                                <div class="bg-white shadow rounded-lg p-6">
                                    <div class="flex flex-col items-center">
                                        @php
                                            // Guardo el id del usuario
                                            $idUser = $usuario->idusuarios;

                                            // Ahora busco en la tabla revisionImagenes
                                            $imagenPerfil = DB::table('revisionImagenes')
                                                ->where('usuarios_idusuarios', $idUser)
                                                ->where('tipodefoto_idtipoDeFoto', 1)
                                                ->first();

                                            if ($imagenPerfil) {
                                                $ubicacionImagen = DB::table('imagenes')
                                                    ->where('idimagenes', $imagenPerfil->imagenes_idimagenes)
                                                    ->first();

                                                $ubicarImagen = null;
                                                if ($imagenPerfil) {
                                                    $ubicarImagen = $ubicacionImagen->subidaImg;
                                                }
                                            }
                                        @endphp

                                        @if ($ubicarImagen)
                                            <img src='{{ asset(Storage::url($ubicarImagen)) }}'
                                                class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0"></img>
                                        @else
                                            <img src='{{ asset('default-profile.png') }}'
                                                class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0"></img>
                                        @endif



                                        <h1 class="text-xl font-bold">
                                            {{ $usuario->datosPersonales->nombreDP . ' ' . $usuario->datosPersonales->apellidoDP }}
                                        </h1>
                                        <p class="text-gray-700">{{ $usuario->usuarioUser }}</p>
                                        <div class="mt-6 flex flex-wrap gap-4 justify-center">
                                            <a href="#"
                                                class="bg-red-600 hover:bg-red-500 text-white py-2 px-4 rounded">Reportar</a>
                                        </div>
                                    </div>
                                    <hr class="my-6 border-t border-gray-300">
                                    <div class="flex flex-col">
                                        <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Contenido
                                            Descargable
                                            como {{ $usuario->roles->rol }}</span>
                                        <ul>
                                            <li class="mb-2">Escuchar</li>
                                            <li class="mb-2">Fondos</li>
                                            <li class="mb-2">Premium</li>
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
    </div>
    </x-applayout>
