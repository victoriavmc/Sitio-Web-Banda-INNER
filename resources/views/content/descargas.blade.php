<x-AppLayout>
    <div class="min-h-screen">
        <div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Muestra</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Titulo Album</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Fecha Album</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Tipo</th>
                        <th class="w-1/4 py-4 px-4 text-left text-gray-600 font-bold uppercase">Descargar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    {{-- @dd($albumInfo) --}}
                    @foreach ($albumInfo as $item)
                        <tr>
                            <td class="py-4 px-4 border-b border-gray-200">
                                {{-- Muestra imagen/video o cancion --}}
                                @if (!empty($item['imagenes']))
                                    {{-- Muestra la primera imagen --}}
                                    <img src="{{ asset($item['imagenes'][0]['rutaImagen']) }}" alt="Imagen"
                                        class="w-16 h-16 object-cover">
                                @elseif (!empty($item['videos']))
                                    {{-- Muestra el primer video --}}
                                    <video width="100" height="100" controls>
                                        <source src="{{ asset($item['videos'][0]['rutaVideo']) }}" type="video/mp4">
                                        Tu navegador no soporta el video.
                                    </video>
                                @elseif (!empty($item['canciones']))
                                    {{-- Muestra el primer audio --}}
                                    <audio controls>
                                        <source src="{{ asset($item['canciones'][0]['rutaCancion']) }}"
                                            type="audio/mpeg">
                                        Tu navegador no soporta el audio.
                                    </audio>
                                @else
                                    {{-- Muestra un mensaje si no hay contenido --}}
                                    <span>No hay contenido</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 border-b font-semibold border-gray-200">{{ $item['tituloAlbum'] }}</td>
                            <td class="py-4 px-4 border-b border-gray-200 truncate">{{ $item['fechaAlbum'] }}</td>
                            <td class="py-4 px-4 border-b border-gray-200">Imagen/Video/Cancion
                                {{-- Dice que tipo de dato es --}}
                            </td>
                            <td class="py-4 px-4 border-b border-gray-200">
                                <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Si / No</span>
                            </td>
                            {{-- <td class="py-4 px-4 border-b border-gray-200">
                                <span class="bg-red-500 text-white py-1 px-2 rounded-full text-xs"> No </span>
                            </td> --}}
                            <td class="p-3 px-5 flex justify-center">
                                <button type="button"
                                    class="mr-3 text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Modificar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-AppLayout>
