<x-AppLayout>
    <div class='container'>
        <div class="max-w-2xl mx-auto p-4">
            <form action={{ route('crearPublicacion') }} method="POST">
                <div class="mb-6">
                    <label for="tituloForo" class="block text-lg font-medium text-gray-800 mb-1">TituloForo</label>
                    <input type="text" id="tituloForo" name="tituloForo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
                        required>
                </div>

                <div class="mb-6">
                    <label for="descriptorForo" class="block text-lg font-medium text-gray-800 mb-1">Contenido</label>
                    <textarea id="descriptorForo" name="descriptorForo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" rows="6"
                        required></textarea>
                </div>

                {{-- NO TODAVIA --}}
                {{-- <div class="mb-6">
                    <label for="image" class="block text-lg font-medium text-gray-800 mb-1">Imagen: (1 por
                        publicacion)</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full">
                </div> --}}

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-500 text-white font-semibold rounded-md hover:bg-indigo-600 focus:outline-none">Subir
                        Publicacion</button>
                </div>
            </form>
        </div>
        <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#content'))
                .catch(error => {
                    console.error(error);
                });
        </script>
    </div>

</x-AppLayout>
