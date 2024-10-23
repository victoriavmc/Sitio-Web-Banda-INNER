<x-AppLayout>
    <div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
        <table class="w-full table-fixed">
            <thead>
                <tr class="bg-gray-100">
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Archivo</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Tipo</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Descargar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr>
                    <td class="py-4 px-6 border-b border-gray-200">John Doe</td>
                    <td class="py-4 px-6 border-b border-gray-200 truncate">johndoe@gmail.com</td>
                    <td class="py-4 px-6 border-b border-gray-200">
                        <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Active</span>
                    </td>
                    {{-- <td class="py-4 px-6 border-b border-gray-200">
                        <span class="bg-red-500 text-white py-1 px-2 rounded-full text-xs">Inactive</span>
                    </td> --}}
                    <td class="p-3 px-5 flex justify-end">
                        <button type="button"
                            class="mr-3 text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Modificar</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</x-AppLayout>
