<x-AppLayout>
    <div class="flex justify-center min-h-screen p-5">
        <div class="w-full max-h-max lg:w-1/3 m-1">
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

                <div class="flex flex-wrap">
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
                        <div class="w-full">
                            <label
                                class="mx-auto cursor-pointer flex w-full max-w-lg flex-col items-center justify-center rounded-xl border-2 border-dashed border-red-400 bg-white p-6 text-center"
                                for="archivoDsCancion">
                                <h2 class="text-xl font-medium text-gray-700 tracking-wide">Archivo de la Canción
                                </h2>
                                <p class="mt-2 text-gray-500 tracking-wide">Inserte la canción (mp3, mp4, ogg, wav).</p>
                                <input id="archivoDsCancion" type="file" class="hidden" name="archivoDsCancion"
                                    accept="audio/*" />
                            </label>
                        </div>
                    </div>

                    <div class="w-full md:w-full px-3 mb-6">
                        <button
                            class="appearance-none block w-full bg-red-700 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-red-600 focus:outline-none focus:bg-white focus:border-gray-500">Agregar
                            Cancion al Album</button>
                    </div>


                </div>
            </form>
        </div>
        @if (!$listaCancion)
        @else
            <div class="w-full lg:w-2/3 m-1 bg-white shadow-lg text-lg rounded-sm border border-gray-200">
                <div class="overflow-x-auto rounded-lg p-3">
                    <table class="table-auto w-full">
                        <thead class="text-sm font-semibold uppercase text-gray-800 bg-gray-50 mx-auto">
                            <tr>
                                <th>
                                    <div class="fill-current w-5 h-5 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 48 48">
                                            <circle cx="24" cy="24" r="21.5" fill="none" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="24" cy="24" r="5.5" fill="none" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path fill="black"
                                                d="M24.75 24a.75.75 0 1 1-.75-.75a.76.76 0 0 1 .75.75" />
                                            <path fill="none" stroke="black" stroke-linecap="round"
                                                stroke-linejoin="round" d="M24 7.5A16.5 16.5 0 0 0 7.5 24" />
                                            <path fill="none" stroke="black" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M24 13a11 11 0 0 0-11 11m11 16.5A16.5 16.5 0 0 0 40.5 24" />
                                            <path fill="none" stroke="black" stroke-linecap="round"
                                                stroke-linejoin="round" d="M24 35a11 11 0 0 0 11-11" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Nombre de Canción</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Letra de Canción Español</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Letra de Canción Ingles</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Archivo de Audio</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Acciones</div>
                                </th>
                            </tr>
                            @foreach ($listaCancion as $item)
                                <tr>
                                    <td> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 20 20">
                                            <path fill="black" fill-rule="evenodd"
                                                d="M16 1H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1m-3.205 10.519c-.185.382-.373.402-.291 0C12.715 10.48 12.572 8.248 11 8v4.75c0 .973-.448 1.82-1.639 2.203c-1.156.369-2.449-.016-2.752-.846s.377-1.84 1.518-2.256c.637-.232 1.375-.292 1.873-.101V5h1c0 2.355 4.065 1.839 1.795 6.519"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </td>
                                    <td> {{ $item['tituloCancion'] }}</td>
                                    <td>
                                        @if ($item['letraEspCancion'])
                                            Cargado
                                        @else
                                            No Cargado
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['letraInglesCancion'])
                                            Cargado
                                        @else
                                            No Cargado
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['descargable'])
                                            Cargado
                                        @else
                                            No Cargado
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        <div class="flex justify-center">
                                            <a href="{{ route('formulario-modificar-cancion', $item['idCancion']) }}"
                                                class="rounded-md uppercase hover:bg-green-100 text-green-600 p-2 flex justify-between items-center">
                                                <span>
                                                    <FaEdit class="w-4 h-4 mr-1" />
                                                </span>
                                                Editar
                                            </a>

                                            <form action="{{ route('eliminar-cancion', $item['idCancion']) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-md uppercase hover:bg-red-100 text-red-600 p-2 flex justify-between items-center">
                                                    <span>
                                                        <FaTrash class="w-4 h-4 mr-1" />
                                                    </span>
                                                    Borrar
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-AppLayout>
