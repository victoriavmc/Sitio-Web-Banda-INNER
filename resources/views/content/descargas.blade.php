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
