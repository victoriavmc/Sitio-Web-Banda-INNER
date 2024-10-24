<x-AppLayout>
    @if (session('alertAlbum'))
        <x-alerts :type="session('alertAlbum')['type']">
            {{ session('alertAlbum')['message'] }}
        </x-alerts>
    @endif
    <div class="min-h-screen p-5">
        <div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
            <table class="w-full table-fixed gap-2">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Muestra</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Titulo Album</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Fecha Album</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Tipo</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Descargar</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Permitir descarga</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($media as $item)
                        <tr>
                            <td class="py-4 px-4 border-b border-gray-200">
                                {{-- Muestra imagen/video o cancion --}}
                                @if ($item['tipo'] == 'Imagen')
                                    <div
                                        class="imagen-modal cursor-pointer h-24 w-24 overflow-hidden rounded-lg ring-2 ring-gray-700 dark:ring-gray-100">
                                        <img src="{{ asset(Storage::url($item['ruta'])) }}" alt="{{ $item['id'] }}" />
                                    </div>
                                @elseif ($item['tipo'] == 'Video')
                                    <video class="h-24 w-24 imagen-modal cursor-pointer" controls>
                                        <source src="{{ asset(Storage::url($item['ruta'])) }}" type="video/mp4"
                                            alt="{{ $item['id'] }}">
                                        Tu navegador no soporta el elemento de video.
                                    </video>
                                @elseif ($item['tipo'] == 'Cancion')
                                    <div class="flex justify-between items-center w-24 my-2">
                                        <button
                                            class="aspect-square bg-white flex justify-center items-center rounded-full p-1 shadow-md dark:bg-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                viewBox="0 0 24 24">
                                                <path fill="#816cfa" fill-rule="evenodd"
                                                    d="M7 6a1 1 0 0 1 2 0v4l6.4-4.8A1 1 0 0 1 17 6v12a1 1 0 0 1-1.6.8L9 14v4a1 1 0 1 1-2 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button
                                            class="aspect-square bg-white flex justify-center items-center rounded-full p-1 shadow-md dark:bg-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 512 512">
                                                <path fill="#816cfa"
                                                    d="M133 440a35.37 35.37 0 0 1-17.5-4.67c-12-6.8-19.46-20-19.46-34.33V111c0-14.37 7.46-27.53 19.46-34.33a35.13 35.13 0 0 1 35.77.45l247.85 148.36a36 36 0 0 1 0 61l-247.89 148.4A35.5 35.5 0 0 1 133 440" />
                                            </svg>
                                        </button>
                                        <button
                                            class="aspect-square bg-white flex justify-center items-center rounded-full p-1 shadow-md dark:bg-gray-800">
                                            <svg class="rotate-180" xmlns="http://www.w3.org/2000/svg" width="12"
                                                height="12" viewBox="0 0 24 24">
                                                <path fill="#816cfa" fill-rule="evenodd"
                                                    d="M7 6a1 1 0 0 1 2 0v4l6.4-4.8A1 1 0 0 1 17 6v12a1 1 0 0 1-1.6.8L9 14v4a1 1 0 1 1-2 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4 border-b font-semibold border-gray-200">{{ $item['tituloAlbum'] }}</td>
                            <td class="py-4 px-4 border-b border-gray-200 truncate">{{ $item['fechaAlbum'] }}</td>
                            <td class="py-4 px-4 border-b border-gray-200">{{-- Muestra imagen/video o cancion --}}
                                @if ($item['tipo'] == 'Imagen')
                                    <h1>Imagen</h1>
                                @elseif ($item['tipo'] == 'Video')
                                    <h1>Video</h1>
                                @elseif ($item['tipo'] == 'Cancion')
                                    <h1>Canción</h1>
                                @endif

                            </td>
                            <td class="py-4 px-4 border-b border-gray-200">
                                @if ($item['descarga'] !== 'No')
                                    <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Sí</span>
                                @else
                                    <span class="bg-red-500 text-white py-1 px-2 rounded-full text-xs">No</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 border-b border-gray-200">
                                <form action="{{ route('descargarAlbumMusical') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="tipo" value="{{ $item['tipo'] }}">
                                    <input type="hidden" name="idEspecifico" value="{{ $item['id'] }}">
                                    <input type="hidden" name="descarga" value="{{ $item['descarga'] }}">
                                    <button type="submit"
                                        class="mr-3 text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Modificar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Contenedor del modal -->
    <div id="modal" class="hidden imagenG">
        <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>
</x-AppLayout>
