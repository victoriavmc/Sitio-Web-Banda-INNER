<x-Opciones>

    <head>
        <link rel="stylesheet" href="https://boilerplate-shadcn-pro.vercel.app/_next/static/css/e4d7c44042e2fbaf.css" />
    </head>

    @if (session('alertEliminacion'))
        <x-alerts :type="session('alertEliminacion')['type']">
            {{ session('alertEliminacion')['message'] }}
        </x-alerts>
    @endif

    <div class="flex flex-col bg-white min-h-[86vh]">
        <div
            class="mx-auto mb-10 flex w-full flex-col px-5 pt-0 md:h-[unset] md:max-w-[95%] lg:h-[100vh] lg:max-w-[70%] lg:px-6 xl:pl-0 mt-10">
            <div class="h-min w-full rounded-lg">
                <form class="flex items-center max-w-sm my-2" method="GET" action="{{ route('panel-de-staff') }}">
                    <label for="simple-search" class="sr-only">Buscar</label>
                    <div class="relative w-full">
                        <input type="text" id="simple-search" name="busqueda"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar por usuario o email..." />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Buscar</span>
                    </button>
                </form>
            </div>
            <div
                class="rounded-lg border bg-card text-card-foreground shadow-sm h-min w-full border-zinc-200 p-0 dark:border-zinc-800 sm:overflow-auto">
                <div class="overflow-x-scroll xl:overflow-x-hidden">
                    <div class="relative w-full overflow-auto">
                        <table class="caption-bottom text-sm w-full">
                            <thead class="[&amp;_tr]:border-b border-b-[1px] border-zinc-200 p-6 dark:border-zinc-800">
                                <tr class="dark:border-zinc-800">
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Foto
                                            de Perfil</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                                            Nombre
                                            de usuario</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                                            Correo
                                            electronico</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                                            Nombre
                                            Completo</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">C.
                                            Reportes
                                        </p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Rol
                                        </p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start dark:border-zinc-800"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Accion
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="[&amp;_tr:last-child]:border-0">
                                @foreach ($usuarios as $usuario)
                                    <tr
                                        class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted px-6 dark:hover:bg-gray-900">
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">
                                            <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                <img alt="Foto de perfil" class="h-10 w-10 rounded-full"
                                                    src="{{ $usuario->urlImagen }}">
                                            </a>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">
                                            <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                <p class="text-sm font-medium text-zinc-950 dark:text-white">
                                                    {{ $usuario->usuarioUser }}</p>
                                            </a>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">
                                            <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                <p class="text-sm font-medium text-zinc-950 dark:text-white">
                                                    {{ $usuario->correoElectronicoUser }}</p>
                                            </a>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">
                                            <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                <p class="text-sm font-medium text-zinc-950 dark:text-white">
                                                    {{ $usuario->datosPersonales->nombreDP . ' ' . $usuario->datosPersonales->apellidoDP }}
                                                </p>
                                            </a>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">

                                            @if ($usuario->reportesUser > 0)
                                                <p class="text-red-600 font-black">
                                                    {{ $usuario->reportesUser }}
                                                </p>
                                            @else
                                                <p class="text-sm font-medium text-zinc-950 dark:text-white">
                                                    No
                                                </p>
                                            @endif

                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">
                                            <p class="text-sm font-medium text-zinc-950 dark:text-white">
                                                {{ $usuario->staffExtra->tipoStaff->nombreStaff }}
                                            </p>
                                        </td>

                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4 dark:border-white/10">
                                            <div class="flex gap-2 justify-between">
                                                <div class="bg-gray-200">
                                                    <button type="button" data-usuario-id="{{ $usuario->idusuarios }}"
                                                        onclick="openModal(this)">
                                                        <img class="w-5 h-6"
                                                            src="{{ asset('img/panel/icono_modificar.jpg') }}"
                                                            alt="Modificar Rol">
                                                    </button>
                                                </div>
                                                <div class="bg-gray-200">
                                                    <form
                                                        action="{{ route('borrar-imagen-staff', $usuario->idusuarios) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit">
                                                            <img class="w-5 h-6"
                                                                src="{{ asset('img/panel/icono_eliminar_imagen.jpg') }}"
                                                                alt="Eliminar Imagen">
                                                        </button>
                                                    </form>
                                                </div>
                                                {{-- <div class="bg-gray-200">
                                                    <form class="btnEliminarUsuario"
                                                        action="{{ route('eliminar-staff', $usuario->idusuarios) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit">
                                                            <img class="w-5 h-6"
                                                                src="{{ asset('img/panel/icono_eliminar.jpg') }}"
                                                                alt="Eliminar Usuario">
                                                        </button>
                                                    </form>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>


    {{-- Modal --}}
    <div id="modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto">
        <div class="flex h-screen items-center justify-center">
            <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Cambiar Rol</h3>
                </div>
                <!-- Cuerpo del Modal con el formulario -->
                <div class="mt-2 px-7 py-3">
                    <form action="" method="POST">
                        @csrf
                        <!-- Select de Roles -->
                        <div class="mb-4">
                            <label for="rol" class="block text-gray-700 text-sm font-bold mb-2">
                                Selecciona el Rol
                            </label>
                            <select id="rol" name="rol"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none">
                                <option value="" selected disabled>-- Selecciona el tipo de rol --</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->idrol }}">{{ $rol->rol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Select de Especialidades de Staff (oculto por defecto) -->
                        <div id="especialidad-container" class="mb-4 hidden">
                            <label for="especialidad" class="block text-gray-700 text-sm font-bold mb-2">
                                Selecciona la Especialidad del Staff
                            </label>
                            <select id="especialidad" name="especialidad"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none">
                                @foreach ($especialidadModal as $especialidades)
                                    <option value="{{ $especialidades->idtipoStaff }}">
                                        {{ $especialidades->nombreStaff }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Botones -->
                        <div class="flex justify-end">
                            <button type="button"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2"
                                onclick="closeModal()">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = "{{ url('/panel-de-staff/modificar-rol') }}";
        // Código para ordenación
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.querySelector('table');
            const headers = table.querySelectorAll('th');

            headers.forEach((header, index) => {
                header.addEventListener('click', () => {
                    const rows = Array.from(table.querySelectorAll('tbody tr'));
                    const isAscending = header.classList.contains('asc');

                    rows.sort((rowA, rowB) => {
                        const cellA = rowA.children[index].innerText.trim();
                        const cellB = rowB.children[index].innerText.trim();
                        const a = isNaN(cellA) ? cellA.toLowerCase() : parseFloat(cellA);
                        const b = isNaN(cellB) ? cellB.toLowerCase() : parseFloat(cellB);
                        return isAscending ? (a > b ? 1 : -1) : (a < b ? 1 : -1);
                    });

                    rows.forEach(row => table.querySelector('tbody').appendChild(row));

                    headers.forEach(header => header.classList.remove('asc', 'desc'));
                    header.classList.add(isAscending ? 'desc' : 'asc');
                });
            });
        });

        // Código para búsqueda en vivo
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('#simple-search');
            const table = document.querySelector('table');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', () => {
                const searchValue = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const isMatch = Array.from(cells).some(cell =>
                        cell.innerText.toLowerCase().includes(searchValue)
                    );

                    row.style.display = isMatch ? '' : 'none';
                });
            });
        });

        function toggleEspecialidad(rolId) {
            const staffRoleIds = [3, 4]; // IDs de roles que pertenecen al staff
            const especialidadContainer = document.getElementById('especialidad-container');

            if (staffRoleIds.includes(parseInt(rolId))) {
                especialidadContainer.classList.remove('hidden');
            } else {
                especialidadContainer.classList.add('hidden');
            }
        }

        function openModal(button) {
            const usuarioId = button.getAttribute('data-usuario-id');

            const form = document.querySelector('#modal form');

            form.action = `${baseUrl}/${usuarioId}`;

            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>


</x-Opciones>
