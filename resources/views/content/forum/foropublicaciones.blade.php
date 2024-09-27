<x-AppLayout>
    <!-- Columna del formulario -->
    <div class="form-column flex-1 flex justify-center items-center bg-white">
        <form action="{{ route('crearPForo', ['type' => 1]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h1 class="font-bold deepshadow mb-4 text-black">Crear Publicación de Foro</h1>

            {{-- Titulo --}}
            <div class="form-wrapper mb-4">
                <label for="titulo" class="form-label text-black">Título</label>
                @error('titulo')
                    <span class="font-bold text-red-500">{{ $message }}</span>
                @enderror
                <input type="text" name="titulo" placeholder="titulo"
                    class="form-control pl-0 text-black bg-black bg-opacity-0"">
            </div>

            <!-- Descripcion -->
            <div class="form-wrapper mb-4 font-urbanist">
                <label for="descripcion" class="form-label text-black">Descripción</label>
                @error('descripcion')
                    <span class="font-bold text-red-500">{{ $message }}</span>
                @enderror
                <textarea type="text" name="descripcion" placeholder="descripcion"
                    class="form-control pl-0 text-black bg-black bg-opacity-0""></textarea>
            </div>

            <!-- Imagen/es -->
            <div class="form-wrapper mb-4">
                <label for="image" class="form-label text-black">Imagen/es (* Es opcional, pero la primera es para la
                    portada)</label>
                @error('imagen')
                    <span class="font-bold text-red-500">{{ $message }}</span>
                @enderror
                <input type="file" name="imagen[]" class="form-control pl-0 text-black bg-black bg-opacity-0"
                    multiple>

            </div>

            <!-- Botón de Crear Publicacion -->
            <div class="m-auto w-max">
                <button type="submit"
                    class="px-6 py-2 bg-indigo-500 text-black font-semibold rounded-md hover:bg-indigo-600 focus:outline-none">Enviar</button>
            </div>
        </form>
    </div>
</x-AppLayout>
