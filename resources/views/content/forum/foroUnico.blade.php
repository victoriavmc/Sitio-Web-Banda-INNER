<x-AppLayout>
    <div class="bg-white flex justify-center items-center min-h-[86.5vh] flex-col">
        @if (Auth::check() && Auth::user()->rol)
            @if (Auth::user()->rol->idrol == 3 || Auth::user()->rol->idrol == 4)
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Aquí se muestra el contenido del post -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                        <h2 class="text-xl font-bold mb-4">{{ $recuperoPublicacion->titulo }}</h2>
                        <p>{{ $recuperoPublicacion->contenido }}</p>

                        <!-- Solo los usuarios con rol 1 y 2 o el autor pueden modificar/eliminar el post -->
                        @if (Auth::user()->rol->idrol == 1 ||
                                Auth::user()->rol->idrol == 2 ||
                                Auth::user()->idusuarios == $recuperoPublicacion->idusuarios)
                            <div class="mt-4 flex space-x-4">
                                <!-- Botón para eliminar el contenido -->
                                <form action="{{ route('eliminarContenido', $recuperoPublicacion->idcontenidos) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
                                        Eliminar
                                    </button>
                                </form>

                                <!-- Botón para modificar el contenido (solo el autor) -->
                                @if (Auth::user()->idusuarios == $recuperoPublicacion->idusuarios)
                                    <a href="{{ route('editarContenido', $recuperoPublicacion->idcontenidos) }}"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-yellow-700 rounded">
                                        Modificar
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Mostrar los comentarios -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6 px-4 py-4">
                        <h3 class="text-lg font-bold mb-4">Comentarios</h3>
                        @foreach ($recuperoComentarios as $comentario)
                            <div class="mb-4 p-4 border rounded">
                                <p class="mb-2"><strong>{{ $comentario->usuario->name }}</strong>:
                                    {{ $comentario->contenido }}</p>

                                <!-- Solo los usuarios con rol 1 o 2 o el autor del comentario pueden eliminar/modificar -->
                                @if (Auth::user()->rol->idrol == 1 ||
                                        Auth::user()->rol->idrol == 2 ||
                                        Auth::user()->idusuarios == $comentario->idusuarios)
                                    <div class="flex space-x-2">
                                        <!-- Botón para eliminar el comentario -->
                                        <form action="{{ route('eliminarComentario', $comentario->idcomentarios) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-700 rounded">
                                                Eliminar
                                            </button>
                                        </form>

                                        <!-- Botón para modificar el comentario (solo el autor) -->
                                        @if (Auth::user()->idusuarios == $comentario->idusuarios)
                                            <a href="{{ route('editarComentario', $comentario->idcomentarios) }}"
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 border border-yellow-700 rounded">
                                                Modificar
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Formulario para agregar un nuevo comentario (solo para usuarios con rol 4) -->
                    @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2 || Auth::user()->rol->idrol == 4)
                        <div class="card-body text-black mt-6">
                            <form action="{{ route('crearComentario', $recuperoPublicacion->idcontenidos) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="contenido">Contenido del Comentario:</label>
                                    <textarea name="contenido" id="contenido" class="form-control" rows="3" placeholder="Escribe tu comentario..."></textarea>
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    Agregar Comentario
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        @else
            <script>
                window.location.href = "{{ route('superFan') }}";
            </script>
        @endif
    </div>
</x-AppLayout>
