<x-AppLayout>
    @if (session('alertMotivo'))
        <x-alerts :type="session('alertMotivo')['type']">
            {{ session('alertMotivo')['message'] }}
        </x-alerts>
    @endif

    <!-- Encabezado -->
    <div class="bg-gray-300 py-8 flex justify-center items-center">
        <h1 class="text-5xl">Reportes</h1>
    </div>
    {{-- Necesito dividir la pantalla en 2, Izq y Derecha --}}
    <div class="grid md:grid-cols-[35%_65%] min-h-screen border">
        {{-- IZQUIERDO --}}
        <div class="bg-red-500 p-5 md:p-10 ">
            {{-- ENCABEZADO DEL USUARIO --}}

            <div class="flex justify-evenly">
                <h1 class='text-2xl font-semibold text-center uppercase'>
                    {{-- @dd($data['perfilReportado']) --}}
                    @if ($data['totalReportadas'] && $data['perfilReportado'] > 0)
                        Usuario Reportado
                    @else
                        Historial del Usuario
                    @endif
                </h1>
            </div>

            {{-- DATOS DEL USUARIO --}}
            <div class="flex justify-center mx-auto px-4 py-4">
                <div class="py-4 rounded shadow-md max-w-max bg-gray-50">
                    <div class="flex flex-col gap-2 md:flex-row justify-center items-center p-4 space-x-4 lg:px-8">
                        <img id="imagen"
                            class="cursor-pointer imagen-modal object-cover object-center w-full h-24 max-w-24 rounded-lg"
                            src="{{ $data['imagen'] ? asset(Storage::url($data['imagen'])) : asset('img/logo_usuario.png') }}"
                            alt="Foto de perfil">
                        <div>
                            <a href="{{ route('perfil-ajeno', $data['usuario']->idusuarios) }}">
                                <div class="text-lg font-semibold break-words">
                                    {{ $data['datosPersonales']->nombreDP . ' ' . $data['datosPersonales']->apellidoDP }}
                                </div>
                                <div class="text-sm text-gray-600 break-words">
                                    {{ $data['usuario']->usuarioUser }}
                                </div>
                            </a>
                            <div class="text-sm text-gray-600 break-words">
                                {{ $data['usuario']->rol->rol }}
                            </div>
                        </div>
                    </div>
                    <div class="p-4 space-y-4 lg:px-8">
                        <div class="w-full h-4">
                            {{ $data['datosPersonales']->generoDP }}
                        </div>

                        <div class="w-full h-4">
                            {{ $data['datosPersonales']->paisnacimiento->nombrePN }}
                        </div>

                        <div class="w-full h-4">
                            {{ $data['datosPersonales']->fechaNacimiento }}
                        </div>
                        <div class="w-3/4 h-4">
                            {{ $data['usuario']->correoElectronicoUser }}
                        </div>
                    </div>
                </div>
            </div>

            @php
                function formatReportes($reportes)
                {
                    if (count($reportes) > 1) {
                        $lastReporte = array_pop($reportes);
                        return implode(', ', $reportes) . ' y ' . $lastReporte;
                    }
                    return implode('', $reportes);
                }
            @endphp

            @if ((isset($totalReportadas) && $totalReportadas > 0) || (isset($perfilReportado) && $perfilReportado))
                <div class="flex space-x-2 items-center animate-out zoom-in duration-200 delay-300">
                    <div class="font-semibold text-center md:text-left">
                        <p class="mb-2">Reportado por
                            {{ count($quienesReportaron) === 1 ? 'el usuario:' : 'los usuarios:' }}</p>

                        <div class="flex space-x-2 items-center flex-col md:flex-row">
                            <div class="flex space-x-2 ml-10">
                                @foreach ($quienesReportaron as $usuarioReporto)
                                    <a href="{{ route('perfil-ajeno', $usuarioReporto['id']) }}"
                                        class="relative tooltip">
                                        <img title=""
                                            class="inline-block h-10 w-10 rounded-full ring-2 ring-gray-200 hover:scale-105 transform duration-100"
                                            src="{{ $usuarioReporto['imagen'] ? asset(Storage::url($usuarioReporto['imagen'])) : asset('img/logo_usuario.png') }}"
                                            alt="{{ $usuarioReporto['nombre'] }}">
                                        <span class="tooltip-text">
                                            {{ $usuarioReporto['nombre'] }}<br>
                                            {!! formatReportes($usuarioReporto['reportes']) !!}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- DERECHO --}}
        <div class="p-10">
            <form action="{{ route('decideReporte', $data['usuario']->idusuarios) }}" method="POST"
                class="flex flex-col max-w-max gap-5 ">
                @csrf
                {{-- Decidir que hacer --}}
                <div>
                    <label for="manejarReporte">Manejar Reporte</label>
                    <select name="manejarReporte" id="manejarReporte" required>
                        <option value="0">Anular Reporte</option>
                        <option value="1">Definir tiempo de baneo</option>
                        <option value="2">Borrar cuenta</option>
                    </select>
                    @error('manejarReporte')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Solo aparece si el usuario selecciona la opción 1 --}}
                <div id="fechaDesbaneoWrapper" style="display: none;">
                    <label for="fechaDesbaneo">Selecciona el tiempo de baneo:</label>
                    <input type="date" name="fechaDesbaneo" id="fechaDesbaneo">
                    @error('fechaDesbaneo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Solo aparece si el usuario selecciona la opción 1 o 2 --}}
                <div id="motivoWrapper" style="display: none;">
                    <label for="motivo">Selecciona un motivo de baneo:</label>

                    @foreach ($motivos as $motivo)
                        <div class="flex my-2 justify-between items-center gap-5">
                            <div class="flex items-center gap-1">
                                <input type="checkbox" id="motivo_{{ $motivo->idmotivos }}" name="motivo[]"
                                    value="{{ $motivo->idmotivos }}">
                                <label for="motivo_{{ $motivo->idmotivos }}">{{ $motivo->descripcion }}</label>
                            </div>


                            <div class="flex gap-2">
                                <button type="button" class="open-modal-btn" data-id="{{ $motivo->idmotivos }}"
                                    data-descripcion="{{ $motivo->descripcion }}">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @error('motivo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botón para enviar el formulario --}}
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-400 max-w-max text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                        Continuar
                    </button>

                    <div class="flex gap-2">
                        <button id="btnBorrarMotivo" type="button" style="display: none;"
                            class="bg-red-500 hover:bg-red-400 max-w-max text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                            Borrar Motivo
                        </button>


                        <button id="btnAbrirMotivo" type="button" style="display: none;"
                            class="bg-red-500 hover:bg-red-400 max-w-max text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                            Crear Motivo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal formulario crear motivo --}}
    <div id="modalCrearMotivo" class="hidden">
        <div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Crear Motivo</h2>
                <form action="{{ route('crearMotivo') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <label for="descripcion">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" required>
                        @error('descripcion')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="flex justify-between">
                            <button type="button"
                                class="bg-gray-500 hover:bg-gray-400 text-white text-base font-bold py-2 px-4 border-b-4 border-gray-700 hover:border-gray-500 rounded"
                                id="btnCerrarModal">
                                Cerrar
                            </button>
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                                Crear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal formulario modificar motivo --}}
    <div id="editModal" class="hidden">
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-md w-1/3">
                <h2 class="text-xl font-bold mb-4">Modificar Motivo</h2>
                <form id="editMotivoForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="modalMotivoId" name="id">
                    <div class="mb-4">
                        <label for="modalDescripcion"
                            class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input type="text" id="modalDescripcion" name="descripcion"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="button" id="closeModalBtn"
                            class="bg-gray-500 hover:bg-gray-400 text-white text-base font-bold py-2 px-4 border-b-4 border-gray-700 hover:border-gray-500 rounded">Cancelar</button>
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal formulario eliminar motivo --}}
    <div id="deleteModal" class="hidden">
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-md w-1/3">
                <h2 class="text-xl font-bold mb-4">Eliminar Motivo</h2>
                <form id="deleteMotivoForm" action="{{ route('eliminarMotivoAdmin', $motivo->idmotivos) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    {{-- Select y options con todos los motivos --}}
                    <div class="mb-4">
                        <label for="deleteMotivo" class="block text-sm font-medium text-gray-700">Motivo</label>
                        <select name="motivo" id="deleteMotivo"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach ($motivos as $motivo)
                                <option value="{{ $motivo->idmotivos }}">{{ $motivo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="button" id="closeDeleteModalBtn"
                            class="bg-gray-500 hover:bg-gray-400 text-white text-base font-bold py-2 px-4 border-b-4 border-gray-700 hover:border-gray-500 rounded">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contenedor del modal -->
    <div id="modal" class="hidden imagenG">
        <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const manejarReporte = document.getElementById('manejarReporte');
            const fechaDesbaneoWrapper = document.getElementById('fechaDesbaneoWrapper');
            const motivoWrapper = document.getElementById('motivoWrapper');
            const btnCrearMotivo = document.getElementById('btnAbrirMotivo');
            const btnBorrarMotivo = document.getElementById('btnBorrarMotivo');

            manejarReporte.addEventListener('change', (event) => {
                const value = parseInt(event.target.value);

                // Mostrar/ocultar campos según la opción seleccionada
                if (value === 1) {
                    fechaDesbaneoWrapper.style.display = 'block';
                    motivoWrapper.style.display = 'block';
                    btnCrearMotivo.style.display = 'block';
                    btnBorrarMotivo.style.display = 'block';

                } else if (value === 2) {
                    fechaDesbaneoWrapper.style.display = 'none';
                    motivoWrapper.style.display = 'block';
                    btnCrearMotivo.style.display = 'block';
                    btnBorrarMotivo.style.display = 'block';
                } else {
                    fechaDesbaneoWrapper.style.display = 'none';
                    motivoWrapper.style.display = 'none';
                    btnCrearMotivo.style.display = 'none';
                    btnBorrarMotivo.style.display = 'none';
                }
            });

            // Opcional: dispara el evento al cargar para manejar selección previa
            manejarReporte.dispatchEvent(new Event('change'));


            // Modal del formulario crear motivo
            const btnCerrarModal = document.getElementById('btnCerrarModal');
            const modal = document.getElementById('modal');

            btnCrearMotivo.addEventListener('click', () => {
                modalCrearMotivo.classList.remove('hidden');
            });

            btnCerrarModal.addEventListener('click', () => {
                modalCrearMotivo.classList.add('hidden');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const editMotivoForm = document.getElementById('editMotivoForm');
            const modalMotivoId = document.getElementById('modalMotivoId');
            const modalDescripcion = document.getElementById('modalDescripcion');

            // Abrir el modal y cargar los datos del motivo seleccionado
            document.querySelectorAll('.open-modal-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const motivoId = button.getAttribute('data-id');
                    const descripcion = button.getAttribute('data-descripcion');

                    // Establecer los valores del motivo en los campos del modal
                    modalMotivoId.value = motivoId;
                    modalDescripcion.value = descripcion;

                    // Actualizar la acción del formulario con el ID correspondiente
                    editMotivoForm.action = `/reportes/modificar-motivo/${motivoId}`;

                    // Mostrar el modal
                    modal.classList.remove('hidden');
                });
            });

            // Cerrar el modal
            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('deleteModal');
            const btnBorrarMotivo = document.getElementById('btnBorrarMotivo');
            const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
            const deleteMotivoForm = document.getElementById('deleteMotivoForm');

            // Abrir el modal y cargar los datos del motivo seleccionado
            btnBorrarMotivo.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            // Cerrar el modal
            closeDeleteModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
</x-AppLayout>
