<x-AppLayout>
    <div class="flex flex-col mx-3 mt-6 min-h-screen lg:flex-row">
        <div class="w-full lg:w-1/3 m-1">
            <form action="{{ route('guardar-cancion', ['id' => $idAlbum]) }}" method="POST" enctype="multipart/form-data"
                class="w-full bg-white shadow-md p-6">
                @csrf
                {{-- Mostrar mensajes de error --}}
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-200 text-red-600 rounded-lg p-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h1 class='flex font-extrabold text-2xl mb-2 
                justify-center uppercase'>Titulo del
                    ALBUM:
                    {{ $tituloAlbum }}
                </h1>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            htmlFor="category_name">Nombre de Canción</label>
                        <input
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                            type="text" name="tituloCancion" placeholder="Nombre de Canción" required />
                    </div>

                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            htmlFor="category_name">Letra de Canción en Español</label>
                        <textarea textarea rows="4"
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                            type="text" name="letraEspCancion"> </textarea>
                    </div>

                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            htmlFor="category_name">Letra de Canción en Ingles</label>
                        <textarea textarea rows="4"
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                            type="text" name="letraInglesCancion"> </textarea>
                    </div>
                    <div class="w-full px-3 mb-8">
                        {{-- Aca deberia ser Insertar Mp3 --}}
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
                            class="appearance-none block w-full bg-green-700 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-green-600 focus:outline-none focus:bg-white focus:border-gray-500">Agregar
                            Cancion al Album</button>
                    </div>


                </div>
            </form>
        </div>
        <div class="w-full lg:w-2/3 m-1 bg-white shadow-lg text-lg rounded-sm border border-gray-200">
            <div class="overflow-x-auto rounded-lg p-3">
                <table class="table-auto w-full">
                    <thead class="text-sm font-semibold uppercase text-gray-800 bg-gray-50 mx-auto">
                        <tr>
                            <th></th>
                            <th><svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-5 h-5 mx-auto">
                                    <path
                                        d="M6 22h12a2 2 0 0 0 2-2V8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2zm7-18 5 5h-5V4zm-4.5 7a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 8.5 11zm.5 5 1.597 1.363L13 13l4 6H7l2-3z">
                                    </path>
                                </svg></th>
                            <th class="p-2">
                                <div class="font-semibold">Category</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-left">Description</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Action</div>
                            </th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><img src="https://images.pexels.com/photos/25652584/pexels-photo-25652584/free-photo-of-elegant-man-wearing-navy-suit.jpeg?auto=compress&cs=tinysrgb&w=400"
                                    class="h-8 w-8 mx-auto" /></td>
                            <td>Sample Name</td>
                            <td>Sample Description</td>
                            <td class="p-2">
                                <div class="flex justify-center">
                                    <a href="#"
                                        class="rounded-md hover:bg-green-100 text-green-600 p-2 flex justify-between items-center">
                                        <span>
                                            <FaEdit class="w-4 h-4 mr-1" />
                                        </span> Edit
                                    </a>
                                    <button
                                        class="rounded-md hover:bg-red-100 text-red-600 p-2 flex justify-between items-center">
                                        <span>
                                            <FaTrash class="w-4 h-4 mr-1" />
                                        </span> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-AppLayout>
