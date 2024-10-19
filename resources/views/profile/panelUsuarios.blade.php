<x-Opciones>

    <head>
        <link rel="stylesheet" href="https://boilerplate-shadcn-pro.vercel.app/_next/static/css/e4d7c44042e2fbaf.css" />
    </head>

    @if (session('alertEliminacion'))
        <x-alerts :type="session('alertEliminacion')['type']">
            {{ session('alertEliminacion')['message'] }}
        </x-alerts>
    @endif
    @if (!$funciona)
        <p class="text-center mt-5 text-2xl text-gray-500">No hay Usuarios registrados</p>
    @else
        <div class="flex flex-col bg-white min-h-screen">
            <div
                class="mx-auto mb-10 flex w-full flex-col px-5 pt-0 md:h-[unset] md:max-w-[95%] lg:h-[100vh] lg:max-w-[70%] lg:px-6 xl:pl-0 mt-10">
                <div class="h-min w-full rounded-lg">
                    <form class="flex items-center max-w-sm my-2" method="GET" action="{{ route('panel-de-usuarios') }}">
                        <label for="simple-search" class="sr-only">Buscar</label>
                        <div class="relative w-full">
                            <input type="text" id="simple-search" name="busqueda"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 hover:border-red-500 focus:border-red-500 block w-full ps-10 p-2.5"
                                placeholder="Buscar por usuario o email..." />
                        </div>
                        <button type="submit"
                            class="p-2.5 ms-2 text-sm font-medium text-white bg-red-500 rounded-lg border border-red-700 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Buscar</span>
                        </button>
                    </form>
                </div>
                <div
                    class="rounded-lg border bg-card text-card-foreground shadow-sm h-min w-full border-zinc-200 p-0  sm:overflow-auto">
                    <div class="overflow-x-scroll xl:overflow-x-hidden">
                        <table class="caption-bottom text-sm w-full">
                            <thead class="[&amp;_tr]:border-b border-b-[1px] border-zinc-200 p-6">
                                <tr class="">
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">Foto
                                            de Perfil</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">
                                            Nombre
                                            de usuario</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">
                                            Correo
                                            electronico</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">
                                            Nombre
                                            Completo</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">
                                            Estado</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">C.
                                            Reportes
                                        </p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">Rol
                                        </p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer border-zinc-200 pl-5 pr-4 pt-2 text-start"
                                        colspan="1">
                                        <p class="text-xs font-semibold text-zinc-500">Accion
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="[&amp;_tr:last-child]:border-0">
                                @if ($usuarios->isEmpty())
                                    <div class="text-center py-10">
                                        <p class="text-lg font-semibold text-zinc-700">No se encontraron usuarios.</p>
                                    </div>
                                @else
                                    @foreach ($usuarios as $usuario)
                                        @if ($usuario->idusuarios)
                                            <tr
                                                class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted px-6">
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                        <img alt="Foto de perfil" class="h-10 w-10 rounded-full"
                                                            src="{{ $usuario->urlImagen }}">
                                                    </a>
                                                </td>
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                        <p class="text-sm font-medium text-zinc-950">
                                                            {{ $usuario->usuarioUser }}</p>
                                                    </a>
                                                </td>
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                        <p class="text-sm font-medium text-zinc-950">
                                                            {{ $usuario->correoElectronicoUser }}</p>
                                                    </a>
                                                </td>
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                        <p class="text-sm font-medium text-zinc-950">
                                                            {{ $usuario->datosPersonales->nombreDP . ' ' . $usuario->datosPersonales->apellidoDP }}
                                                        </p>
                                                    </a>
                                                </td>
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                                        <p
                                                            class="text-sm font-medium {{ $usuario->datosPersonales->historialUsuario->first()->estado === 'Baneado' ? 'text-red-500' : 'text-zinc-950' }}">
                                                            {{ $usuario->datosPersonales->historialUsuario->first()->estado }}
                                                        </p>
                                                    </a>
                                                </td>
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    @if (isset($listaReportado[$usuario->idusuarios]) && $listaReportado[$usuario->idusuarios] > 0)
                                                        <p class="text-red-600 font-black">
                                                            {{ $listaReportado[$usuario->idusuarios] }}
                                                        </p>
                                                    @else
                                                        <p class="text-sm font-medium text-zinc-950">
                                                            No
                                                        </p>
                                                    @endif
                                                </td>
                                                <td
                                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] border-zinc-200 py-5 pl-5 pr-4">
                                                    <p class="text-sm font-medium text-zinc-950">
                                                        @if ($usuario->rol_idrol == 3)
                                                            SuperFan
                                                        @else
                                                            FanBasic
                                                        @endif
                                                    </p>
                                                </td>
                                                <td
                                                    class=" flex p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max py-5 pl-5 pr-4">
                                                    {{-- Botón para desplegable --}}
                                                    <div class="xl:absolute inline-block">
                                                        <button onclick="toggleDropdown(event)"
                                                            data-usuario-id="{{ $usuario->idusuarios }}"
                                                            class="hover:bg-slate-200 rounded-full transition-colors duration-600 ease-in-out">
                                                            <svg class="w-7 h-7 text-gray-800" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-width="2" d="M6 12h.01m6 0h.01m5.99 0h.01" />
                                                            </svg>
                                                        </button>

                                                        {{-- Contenedor del menú desplegable --}}
                                                        <div class="absolute right-0 z-50 rounded-xl hidden bg-white shadow-lg mt-2 transition-all duration-300"
                                                            id="dropdownMenu-{{ $usuario->idusuarios }}">
                                                            {{-- Botón para editar rol del usuario --}}
                                                            <div class="border-b-2">
                                                                <button type="button"
                                                                    data-usuario-id="{{ $usuario->idusuarios }}"
                                                                    onclick="openModal(this)"
                                                                    class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-200 w-full">
                                                                    <svg class="w-6 h-6 mr-2 text-gray-800"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                    </svg>
                                                                    <p>Editar rol</p>
                                                                </button>
                                                            </div>

                                                            {{-- Botón para borrar imagen del usuario --}}
                                                            <form
                                                                action="{{ route('borrar-imagen', $usuario->idusuarios) }}"
                                                                method="POST" class="border-b-2">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-200 w-full">
                                                                    <svg class="w-6 h-6 mr-2"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <path fill="none" stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 20H8.5l-4.21-4.3a1 1 0 0 1 0-1.41l10-10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41L11.5 20m6.5-6.7L11.7 7" />
                                                                    </svg>
                                                                    <p>Borrar imagen</p>
                                                                </button>
                                                            </form>

                                                            {{-- Boton para reportar usuario --}}
                                                            <div class="border-b-2">
                                                                <a href="{{ route('reportarUsuario', $usuario->idusuarios) }}"
                                                                    class="flex items-center whitespace-nowrap px-4 py-2 text-gray-800 hover:bg-gray-200 w-full">
                                                                    <svg class="w-6 h-6 mr-2 text-gray-800"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
                                                                    </svg>
                                                                    <p>Manejar Reporte</p>
                                                                </a>
                                                            </div>

                                                            {{-- Botón para eliminar usuario --}}
                                                            <form class="btnEliminarUsuario"
                                                                action="{{ route('eliminar-usuario', $usuario->idusuarios) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="flex items-center whitespace-nowrap px-4 py-2 text-gray-800 hover:bg-gray-200 w-full">
                                                                    <svg class="w-6 h-6 mr-2 text-gray-800"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                                    </svg>
                                                                    <p>Eliminar usuario</p>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="8" class="p-4 align-middle text-center">
                                                    <p class="text-sm font-medium text-zinc-950">No se encontraron
                                                        usuarios
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
                        <h3 class="leading-6 text-3xl font-medium text-gray-900">Cambiar Rol</h3>
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
                                    <option value="" selected disabled>Selecciona el tipo de rol</option>
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
                                    @foreach ($especialidades as $especialidad)
                                        <option value="{{ $especialidad->idtipoStaff }}">
                                            {{ $especialidad->nombreStaff }}
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
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const baseUrl = "{{ url('/panel-de-usuarios/modificar-rol') }}";
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

            function toggleDropdown(event) {
                // Obtener el botón clicado
                const button = event.currentTarget;
                const usuarioId = button.getAttribute('data-usuario-id'); // Asegúrate de pasar este atributo
                const dropdown = document.getElementById('dropdownMenu-' + usuarioId);

                // Verificar si el menú actual está visible
                const isDropdownVisible = !dropdown.classList.contains('hidden');

                // Cerrar todos los menús abiertos
                document.querySelectorAll('[id^="dropdownMenu"]').forEach(menu => {
                    menu.classList.add('hidden');
                });

                // Si el menú estaba oculto, mostrarlo, si estaba visible, ya se cerró
                if (!isDropdownVisible) {
                    dropdown.classList.remove('hidden');
                }
            }

            // Cerrar el desplegable si se hace clic fuera de él
            document.addEventListener('click', function(event) {
                // Busca todos los menús desplegables
                document.querySelectorAll('[id^="dropdownMenu"]').forEach(function(dropdown) {
                    // Verifica si el clic ocurrió fuera del menú desplegable y del botón que lo abre
                    if (!dropdown.contains(event.target) && !event.target.closest(
                            'button[onclick="toggleDropdown(event)"]')) {
                        dropdown.classList.add('hidden');
                    }
                });
            });
        </script>
    @endif

</x-Opciones>
