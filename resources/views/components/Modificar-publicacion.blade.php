<div class="flex justify-center">
    <form action="{{ route('modificarP', $contenido->idcontenidos) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border-2 border-black p-4 rounded-xl mb-5">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-lg" for="titulo">Título</label>
                    <input class="rounded-xl" type="text" name="titulo" value="{{ old('titulo', $contenido->titulo) }}"
                        required>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-lg" for="descripcion">Descripción</label>
                    <textarea name="descripcion"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500"
                        required>{{ old('descripcion', $contenido->descripcion) }}</textarea>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-lg" for="imagen">Imagen/es (*Opcional, pero la primera es
                        portada)</label>
                    <input class="rounded-xl" type="file" name="imagen[]" multiple>
                </div>
                <button type="submit"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Actualizar
                </button>
            </div>
        </div>

        <div class="border-2 border-black p-4 rounded-xl grid grid-cols-3">
            
        </div>
    </form>
</div>
