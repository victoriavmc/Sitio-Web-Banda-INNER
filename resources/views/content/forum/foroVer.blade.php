<x-AppLayout>
    <div class="bg-white flex justify-center items-center h-[81vh] flex-col">
        <!-- Blog post with featured image -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <!-- Blog post header -->
                <div>
                    <h1 class="text-3xl text-black font-bold mt-6 mb-4">{{ $publicacion->titulo }}</h1>
                    <p class="text-black text-sm mb-4">Publicado el: {{ $publicacion->fechaSubidaPublicacion }}</p>
                </div>

                <!-- Featured image -->
                <div class="flex justify-center">
                    @if ($rutaImagen != null)
                        <img src="{{ asset(Storage::url($rutaImagen)) }}" class="max-w-xl mb-8" alt="ImagenForo">
                    @endif
                </div>

                <!-- Blog post content -->
                <div class="prose text-black text-base prose-sm sm:prose lg:prose-lg xl:prose-xl mx-auto">
                    {{ $publicacion->descriptorForo }}
                </div>
                {{-- <div class="flex w-full gap-6 justify-end">
                    <div
                        class="like-btn flex items-center 
                                    justify-center w-12 h-12 
                                    rounded-full bg-gray-200 
                                    cursor-pointer transition 
                                    duration-300 ease-in-out">
                        <i class="fas fa-thumbs-up 
                                      text-black text-xl">
                        </i>
                    </div>
                    <div
                        class="dislike-btn flex items-center 
                                    justify-center w-12 h-12 
                                    rounded-full bg-gray-200 
                                    cursor-pointer transition 
                                    duration-300 ease-in-out">
                        <i class="fas fa-thumbs-down 
                                      text-black text-xl">
                        </i>
                    </div>
                </div> --}}
            </div>
        </div>

        <div
            class="w-full max-w-2xl my-4 flex flex-col items-start space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6 px-4 py-8 border-2 border-dashed border-gray-400 dark:border-gray-400 shadow-lg rounded-lg">
            <span
                class=" text-xs font-medium top-0 left-0 rounded-br-lg rounded-tl-lg px-2 py-1 bg-primary-100 dark:bg-gray-900 dark:text-black border-gray-400 dark:border-gray-400 border-b-2 border-r-2 border-dashed ">
                Autor
            </span>
            <div class="w-full flex justify-center sm:justify-start sm:w-auto">
                <img class="object-cover w-20 h-20 mt-3 mr-3 rounded-full" src="{{ $imagenUsuario }}"
                    alt="Imagen del usuario">
            </div>
            <div class="w-full sm:w-auto flex flex-col items-center sm:items-start">
                <p class="font-display mb-2 text-2xl font-semibold text-black" itemprop="author">
                    {{ $nombreUsuario }}
                </p>
                <div class="mb-4 md:text-lg ">
                    <p class="text-black">{{ $rolNombre }}</p>
                </div>
            </div>
        </div>

        {{-- COMENTARIOS --}}
        <div class="antialiased mx-auto max-w-screen-sm">
            <h3 class="mb-4 text-lg font-semibold text-black">Comentarios</h3>

            <div class="space-y-4">
                {{-- Respuestas muestra --}}
                {{-- <div class="flex">
                    <div class="flex-shrink-0 mr-3">
                        <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10"
                            src="https://images.unsplash.com/photo-1604426633861-11b2faead63c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80"
                            alt="">
                    </div>
                    <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                        <strong>Sarah</strong> <span class="text-xs text-black">3:34 PM</span>
                        <p class="text-sm">
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                            sed diam nonumy eirmod tempor invidunt ut labore et dolore
                            magna aliquyam erat, sed diam voluptua.
                        </p>
                        <div class="mt-4 flex items-center">
                            <div class="flex -space-x-2 mr-2">
                                <img class="rounded-full w-6 h-6 border border-white"
                                    src="https://images.unsplash.com/photo-1554151228-14d9def656e4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80"
                                    alt="">
                                <img class="rounded-full w-6 h-6 border border-white"
                                    src="https://images.unsplash.com/photo-1513956589380-bad6acb9b9d4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80"
                                    alt="">
                            </div>
                            <div class="text-sm text-black font-semibold">
                                5 Replies
                            </div>
                        </div>
                    </div>
                </div> --}}


                @foreach ($comentarios as $comentario)
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            @php
                                // Guardo el id del usuario
                                $idUser = $comentario->usuarios_idusuarios;

                                // Ahora busco en la tabla revisionImagenes
                                $imagenPerfil = DB::table('revisionImagenes')
                                    ->where('usuarios_idusuarios', $idUser)
                                    ->where('tipodefoto_idtipoDeFoto', 1)
                                    ->first();

                                // Verificamos si $imagenPerfil no es null para evitar errores
                                $ubicarImagen = null;
                                if ($imagenPerfil) {
                                    // Ahora obtengo de la tabla imagenes la ubicacion de subida
                                    $ubicacionImagen = DB::table('imagenes')
                                        ->where('idimagenes', $imagenPerfil->imagenes_idimagenes)
                                        ->first();

                                    if ($ubicacionImagen) {
                                        $ubicarImagen = $ubicacionImagen->subidaImg; // Ajusta según el nombre correcto de la columna
                                    }
                                }
                            @endphp

                            @if ($ubicarImagen)
                                <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10"
                                    src="{{ asset(Storage::url($ubicarImagen)) }}" alt="">
                            @else
                                {{-- FIJARSE ACA Q ONDA --}}
                                <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10"
                                    src="{{ asset(Storage::url('logo_usuario.png')) }}" alt="">
                                {{-- Imagen por defecto --}}
                            @endif
                        </div>


                        <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                            <strong class="text-black">{{ $comentario->usuarios->usuarioUser }}</strong>
                            <span class="text-xs text-black">{{ $comentario->fechaSubidComentario }}</span>
                            <p class="text-sm text-black">
                                {{ $comentario->textocomentarios }}
                            </p>
                        </div>
                        {{-- <div class="flex justify-between">
                            <div
                                class="like-btn flex items-center 
                                    justify-center w-12 h-12 
                                    rounded-full bg-gray-200 
                                    cursor-pointer transition 
                                    duration-300 ease-in-out">
                                <i
                                    class="fas fa-thumbs-up 
                                      text-black text-xl">
                                </i>
                            </div>
                            <div
                                class="dislike-btn flex items-center 
                                    justify-center w-12 h-12 
                                    rounded-full bg-gray-200 
                                    cursor-pointer transition 
                                    duration-300 ease-in-out">
                                <i
                                    class="fas fa-thumbs-down 
                                      text-black text-xl">
                                </i>
                            </div>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-AppLayout>
