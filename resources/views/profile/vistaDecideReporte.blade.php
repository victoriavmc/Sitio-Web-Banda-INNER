<x-AppLayout>
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
                {{-- <a href="{{ route('vistaDecideReporte') }}"
                        class="bg-white hover:bg-gray-400 hover:text-white text-black text-base font-bold py-2 px-2 border-b-4 border-gray-700 hover:border-gray-500 rounded flex items-center">
                        Manejar Reporte
                    </a> --}}
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
                        <div class="w-full h-4"> {{ $data['datosPersonales']->generoDP }} </div>
                        <div class="w-full h-4">
                            {{ $data['datosPersonales']->paisnacimiento->nombrePN }}
                        </div>
                        <div class="w-full h-4">
                            {{ $data['datosPersonales']->fechaNacimiento }} </div>
                        <div class="w-3/4 h-4"> {{ $data['usuario']->correoElectronicoUser }}
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
                class="flex flex-col gap-5">
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
                        <div class="flex gap-1 my-2">
                            <input type="checkbox" id="motivo_{{ $motivo->idmotivos }}" name="motivo[]"
                                value="{{ $motivo->idmotivos }}">
                            <label for="motivo_{{ $motivo->idmotivos }}">{{ $motivo->descripcion }}</label>
                        </div>
                    @endforeach

                    @error('motivo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botón para enviar el formulario --}}
                <button type="submit"
                    class="bg-red-500 hover:bg-red-400 max-w-max text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                    Continuar
                </button>
            </form>
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

            manejarReporte.addEventListener('change', (event) => {
                const value = parseInt(event.target.value);

                // Mostrar/ocultar campos según la opción seleccionada
                if (value === 1) {
                    fechaDesbaneoWrapper.style.display = 'block';
                    motivoWrapper.style.display = 'block';
                } else if (value === 2) {
                    fechaDesbaneoWrapper.style.display = 'none';
                    motivoWrapper.style.display = 'block';
                } else {
                    fechaDesbaneoWrapper.style.display = 'none';
                    motivoWrapper.style.display = 'none';
                }
            });

            // Opcional: dispara el evento al cargar para manejar selección previa
            manejarReporte.dispatchEvent(new Event('change'));
        });
    </script>
</x-AppLayout>
