<x-AppLayout>
    @if (session('alertAlbum'))
        <x-alerts :type="session('alertAlbum')['type']">
            {{ session('alertAlbum')['message'] }}
        </x-alerts>
    @endif

    <div class="wrapper bg-center justify-center min-h-screen"
        style="background-image: url('{{ asset('img/logeo/reactivar_fondo.jpg') }}');">
        <div class=" p-5 bg-white bg-opacity-20 backdrop-blur-lg rounded-3xl shadow-2xl transform z-10 flex">
            <form id="form-reactivar" class="grid grid-cols-2 gap-5" method="POST"
                action="{{ route('modificar-album', $album->idalbumMusical) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Columna de la imagen -->
                <div id="image-container" class="relative w-80 h-46 bg-gray-300 rounded-lg overflow-hidden group"
                    style="background-image: url('{{ asset('storage/' . $imagen) }}'); background-size: cover; background-position: center;">

                    <!-- Mostrar el texto solo si la imagen es la imagen por defecto -->
                    @if ($imagen === 'imagen_por_defecto.jpg')
                        <p id="placeholder-text"
                            class="absolute inset-0 flex flex-col items-center justify-center text-gray-700 text-base font-semibold transition-opacity duration-300 group-hover:opacity-0 z-10">
                            <svg class="w-20 h-20 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                            </svg>
                            Selecciona una imagen de portada
                        </p>
                    @endif

                    <input type="file" name="imagen" id="imagen" class="hidden" accept="image/*"
                        onchange="previewImage(event)">

                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 text-gray-800 font-semibold py-2 px-4 rounded-lg opacity-0 group-hover:opacity-100 z-20">
                        <button type="button"
                            class="bg-red-500 hover:bg-red-700 transition-all duration-300 text-white flex items-center gap-1 p-2 rounded-md"
                            onclick="document.getElementById('imagen').click()">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold">Subir Imagen</span>
                        </button>
                    </div>
                </div>

                <!-- Columna del formulario -->
                <div class="flex-1 justify-center items-center">
                    <h3 class="font-bold text-center text-xl mb-4">Modificar Album</h3>

                    <!-- Titulo del album -->
                    <div class="mb-2">
                        <input type="text" name="titulo" autocomplete="new-password" placeholder="Titulo del album"
                            class="w-full border-none placeholder:text-base pl-0 text-black bg-black bg-opacity-0"
                            value="{{ old('titulo', $album->albumdatos->tituloAlbum) }}">
                        @error('titulo')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha del album -->
                    <div class="mb-2">
                        <input type="date" name="fecha" placeholder="Fecha del album"
                            class="w-full border-none pl-0 placeholder:text-gray-400 tex-black bg-black bg-opacity-0"
                            value="{{ old('fecha', $album->albumdatos->fechaSubido) }}">
                        @error('fecha')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botón para crear álbum -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 
                        border-b-4 border-red-700 hover:border-red-500 rounded">
                            Crear
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para previsualizar la imagen subida
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0]; // Obtener el archivo seleccionado

            if (file) {
                const reader = new FileReader(); // Crear un lector de archivos

                reader.onload = function(e) {
                    const container = document.getElementById('image-container');
                    const placeholderText = document.getElementById('placeholder-text');

                    // Cambiar el fondo del contenedor a la imagen subida
                    container.style.backgroundImage = `url('${e.target.result}')`;
                    container.style.backgroundSize = 'cover';
                    container.style.backgroundPosition = 'center';

                    // Ocultar el texto de "Selecciona una imagen de portada"
                    placeholderText.style.display = 'none';
                };

                reader.readAsDataURL(file); // Leer el archivo como Data URL
            }
        }
    </script>
</x-AppLayout>
