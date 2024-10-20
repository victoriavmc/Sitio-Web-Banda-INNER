<x-AppLayout>
    <div class="flex justify-center mx-3 mt-6 min-h-screen lg:flex-row">
        <div class="w-full lg:w-1/3 m-1">
            <form action="{{ route('modificar-cancion', $cancion->idcancion) }}" method="POST"
                enctype="multipart/form-data" class="w-full bg-white shadow-md p-6">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-200 text-red-600 rounded-lg p-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h1 class='flex font-extrabold text-2xl mb-2 justify-center uppercase'>Titulo del ALBUM:
                    {{ $tituloAlbum }}</h1>

                <div class="flex flex-wrap -mx-3 mb-6">

                    <div class="w-full md:w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            for="album_correcto">
                            ¿Es este el álbum de música?
                        </label>
                        <input type="hidden" name="idalbumMusical" value="{{ $cancion->albumMusical_idalbumMusical }}">

                        <div class="flex items-center mb-2">
                            <input type="radio" id="album_correcto_si" name="album_correcto" class="mr-2"
                                onclick="toggleAlbumList()" value="si" />
                            <label for="album_correcto_si">Sí</label>
                        </div>



                        <div class="flex items-center">
                            <input type="radio" id="album_correcto_no" name="album_correcto" class="mr-2"
                                onclick="toggleAlbumList()" value="no" />
                            <label for="album_correcto_no">No</label>
                        </div>
                    </div>

                    <!-- Lista de álbumes disponibles, inicialmente oculta -->
                    <div id="album-list" class="hidden">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            for="otroAlbum">
                            Selecciona otro álbum:
                        </label>
                        <select name="otroAlbum"
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d] mb-4">
                            <option value="">Seleccione un álbum</option>

                            @foreach ($albumesDisponibles as $album)
                                <option value="{{ $album->idalbumMusical }}">{{ $album->albumdatos->tituloAlbum }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            htmlFor="category_name">Nombre de Canción</label>
                        <input
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                            type="text" name="tituloCancion" placeholder="Nombre de Canción" required
                            value="{{ old('tituloCancion', $cancion->tituloCancion) }}" />
                    </div>

                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            htmlFor="category_name">Letra de Canción en Español</label>
                        <textarea rows="4"
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                            name="letraEspCancion">{{ old('letraEspCancion', $cancion->letraEspCancion) }}</textarea>
                    </div>

                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            htmlFor="category_name">Letra de Canción en Inglés</label>
                        <textarea rows="4"
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                            name="letraInglesCancion">{{ old('letraInglesCancion', $cancion->letraInglesCancion) }}</textarea>
                    </div>

                    <div class="w-full px-3 mb-8">
                        <div class="w-full px-3 mb-8">
                            <label
                                class="mx-auto cursor-pointer flex w-full max-w-lg flex-col items-center justify-center rounded-xl border-2 border-dashed border-green-400 bg-white p-6 text-center"
                                for="archivoDsCancion">
                                <h2 class="mt-4 text-xl font-medium text-gray-700 tracking-wide">Archivo de la Canción
                                </h2>
                                <p class="mt-2 text-gray-500 tracking-wide">Inserte la canción (mp3, mp4, ogg, wav).</p>
                                <input id="archivoDsCancion" type="file" class="hidden" name="archivoDsCancion"
                                    accept="audio/*" />
                            </label>
                        </div>
                    </div>

                    <div class="w-full md:w-full px-3 mb-6">
                        <button
                            class="appearance-none block w-full bg-green-700 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-green-600 focus:outline-none focus:bg-white focus:border-gray-500">Modificar
                            Canción en el Álbum</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleAlbumList() {
            const isCheckedNo = document.getElementById('album_correcto_no').checked;
            const albumList = document.getElementById('album-list');

            if (isCheckedNo) {
                // Si "No" está seleccionado, muestra la lista de álbumes
                albumList.classList.remove('hidden');
            } else {
                // Si "Sí" está seleccionado, oculta la lista de álbumes
                albumList.classList.add('hidden');
            }
        }
    </script>
</x-AppLayout>
