<div class="flex justify-center">
    <form action="{{ route('crearP', $action) }}" method="POST" enctype="multipart/form-data"
        class="border-2 border-black p-4 rounded-xl">
        @csrf
        <div class="flex flex-col gap-4">
            {{-- Título --}}
            <div class="flex flex-col gap-1">
                <label for="titulo" class="font-semibold text-lg">Título</label>
                <input type="text" name="titulo" placeholder="titulo" class="rounded-xl">
            </div>
            <!-- Descripción -->
            <div class="flex flex-col gap-1 font-urbanist">
                <label for="descripcion" class="font-semibold text-lg">Descripción</label>
                <textarea type="text" name="descripcion" placeholder="descripcion"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500"></textarea>
            </div>
            <!-- Imagen/es -->
            <div class="flex flex-col gap-1">
                <label for="image" class="font-semibold text-lg">Imagen/es (* Es opcional, pero la primera es para la
                    portada)</label>
                <input type="file" name="imagen[]" class="rounded-xl" multiple>
            </div>
            <!-- Botón de Crear Publicación -->
            <button type="submit"
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Enviar
            </button>
        </div>
    </form>
</div>
