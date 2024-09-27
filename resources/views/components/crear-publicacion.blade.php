<form action="{{ route('crearP', $action) }}" method="POST" enctype="multipart/form-data">

    @csrf
    {{-- Título --}}
    <div class="form-wrapper mb-4">
        <label for="titulo" class="form-label text-black">Título</label>
        <input type="text" name="titulo" placeholder="titulo"
            class="form-control pl-0 text-black bg-black bg-opacity-0">
    </div>

    <!-- Descripción -->
    <div class="form-wrapper mb-4 font-urbanist">
        <label for="descripcion" class="form-label text-black">Descripción</label>
        <textarea type="text" name="descripcion" placeholder="descripcion"
            class="form-control pl-0 text-black bg-black bg-opacity-0"></textarea>
    </div>

    <!-- Imagen/es -->
    <div class="form-wrapper mb-4">
        <label for="image" class="form-label text-black">Imagen/es (* Es opcional, pero la primera es para la
            portada)</label>
        <input type="file" name="imagen[]" class="form-control pl-0 text-black bg-black bg-opacity-0" multiple>
    </div>

    <!-- Botón de Crear Publicación -->
    <div class="m-auto w-max">
        <button type="submit"
            class="px-6 py-2 bg-indigo-500 text-black font-semibold rounded-md hover:bg-indigo-600 focus:outline-none">Enviar</button>
    </div>
</form>
