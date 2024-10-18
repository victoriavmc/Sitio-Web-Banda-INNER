<x-AppLayout>
    {{-- Div Principal --}}
    <div class="bg-white min-h-screen">
        <!-- Encabezado -->
        <div class="bg-white">
            <header class="bg-gray-300 py-8 flex justify-center items-center">
                <h1 class="text-5xl">Reportes</h1>
            </header>
        </div>
        {{-- Necesito dividir la pantalla en 2, Izq y Derecha --}}
        <div class="grid grid-cols-1 md:grid-cols-12 h-full border">
            {{-- IZQUIERDO --}}
            <div class="bg-red-500  md:col-span-4 p-10 ">
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
                <div class="max-w-4xl mx-auto px-4 py-8">
                    <div class=" space-y-4">
                        <div class="py-4 rounded shadow-md  bg-gray-50">
                            <div class="flex p-4 space-x-4 sm:px-8">
                                <img id="imagen"
                                    class="cursor-pointer imagen-modal object-cover object-center w-full h-24 max-w-24 rounded-lg"
                                    src="{{ $data['imagen'] ? asset(Storage::url($data['imagen'])) : asset('img/logo_usuario.png') }}"
                                    alt="Foto de perfil">
                                <div class="flex-1 py-2 space-y-4">
                                    {{-- @dd($data); --}}
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
                            <div class="p-4 space-y-4 sm:px-8">
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
            <div class="md:col-span-8 p-10">
                <form action="/reportar" method="POST">
                    @csrf <!-- Para proteger contra CSRF -->
                    <label for="motivo">Selecciona un motivo para el reporte:</label>
                    <select name="motivo" id="motivo" required>
                        @foreach ($motivos as $motivo)
                            <option value="{{ $motivo->idmotivos }}">{{ $motivo->descripcion }}</option>
                        @endforeach
                    </select>

                    <button type="submit">Reportar</button>
                </form>


            </div>
        </div>
        <!-- Contenedor del modal -->
        <div id="modal" class="hidden imagenG">
            <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
                <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
            </div>
        </div>
    </div>
</x-AppLayout>
