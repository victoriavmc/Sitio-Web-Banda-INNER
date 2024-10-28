<div class="flex justify-center">
    <form action="{{ route('modificarP', $contenido->idcontenidos) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border-2 border-black p-4 rounded-xl mb-5">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-lg" for="titulo">Título</label>
                    <input class="rounded-xl" type="text" name="titulo"
                        value="{{ old('titulo', $contenido->titulo) }}" required>
                    @error('titulo')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-lg" for="descripcion">Descripción</label>
                    <textarea name="descripcion"
                        class="block resize-none p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500"
                        required>{{ old('descripcion', $contenido->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imágenes existentes -->
                @if (!empty($imagenes) && count($imagenes) > 0)
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg">Imágenes Existentes</label>
                        <div class="border-2 border-black p-4 rounded-xl grid grid-cols-3 gap-4">
                            @foreach ($imagenes as $id => $imagen)
                                <div class="relative" data-imagen-id="{{ $id }}">
                                    <img class="cursor-pointer imagenG imagen-modal object-cover object-center w-full h-40 max-w-full rounded-lg"
                                        src="{{ asset(Storage::url($imagen)) }}" alt="">

                                    <!-- Botón eliminar imagen -->
                                    <button type="button"
                                        class="top-2 right-2 absolute bg-red-500 text-white rounded-full hover:bg-red-700 z-10 eliminar-imagen">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                        </svg>
                                    </button>

                                    <!-- Campo oculto para imágenes eliminadas -->
                                    <input type="hidden" name="imagenesEliminadas[]" value=""
                                        class="input-eliminar-imagen">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-lg" for="imagen">Imagen/es (*Opcional, pero la primera es
                        portada)</label>
                    <input class="rounded-xl" type="file" name="imagen[]" accept="image/*" multiple>
                    @error('imagen')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Actualizar
                </button>
            </div>
        </div>
    </form>

    <!-- Contenedor del modal -->
    <div id="modal" class="hidden">
        <div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>

    <script>
        // Mostrar el modal con la imagen seleccionada
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.eliminar-imagen').forEach(boton => {
                boton.addEventListener('click', function() {
                    const contenedor = this.closest('[data-imagen-id]');
                    const inputEliminar = contenedor.querySelector('.input-eliminar-imagen');
                    // Establecer el ID de la imagen para eliminar
                    inputEliminar.value = contenedor.getAttribute('data-imagen-id');
                    contenedor.style.display = 'none'; // Ocultar la imagen
                });
            });
        });
    </script>
</div>
