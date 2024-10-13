<x-AppLayout>
    {{-- Div Principal --}}
    <div class="bg-white">
        <!-- Encabezado -->
        <div class="bg-white">
            <header class="bg-gray-300 py-8 flex justify-center items-center">
                <h1 class="text-5xl">Reportes</h1>
            </header>
        </div>

        {{-- Necesito dividir la pantalla en 2, Izq y Derecha --}}
        <div class="grid grid-cols-1 md:grid-cols-12 border">
            {{-- IZQUIERDO --}}
            <div class="bg-red-500  md:col-span-4 p-10 ">
                {{-- ENCABEZADO DEL USUARIO --}}
                <h1 class='text-2xl font-semibold text-center uppercase'>
                    @if (isset($totalReportadas) && $totalReportadas > 0)
                        Usuario Reportado
                    @else
                        Historial del Usuario
                    @endif
                </h1>
                {{-- DATOS DEL USUARIO --}}
                <div class="max-w-4xl mx-auto px-4 py-8">
                    <div class=" space-y-4">
                        <div class="py-4 rounded shadow-md  bg-gray-50">
                            <div class="flex p-4 space-x-4 sm:px-8">
                                <div class="flex-shrink-0 w-24 h-24">
                                    <img src="{{ $imagen ? asset(Storage::url($imagen)) : asset('img/logo_usuario.png') }}"
                                        alt="Foto de perfil">
                                </div>
                                <div class="flex-1 py-2 space-y-4">
                                    <div class="text-lg font-semibold break-words">
                                        {{ $datosPersonales->nombreDP . ' ' . $datosPersonales->apellidoDP }}
                                    </div>
                                    <div class="text-sm text-gray-600 break-words">
                                        {{ $usuario->usuarioUser }}
                                    </div>
                                    <div class="text-sm text-gray-600 break-words">
                                        {{ $usuario->rol->rol }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 space-y-4 sm:px-8">
                                <div class="w-full h-4"> {{ $datosPersonales->generoDP }} </div>
                                <div class="w-full h-4">
                                    {{ $datosPersonales->paisnacimiento->nombrePN }}
                                </div>
                                <div class="w-full h-4">
                                    {{ $datosPersonales->fechaNacimiento }} </div>
                                <div class="w-3/4 h-4"> {{ $usuario->correoElectronicoUser }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- DERECHO --}}
            <div class="md:col-span-8 p-10">
                {{-- ENCABEZADO DE REPORTES --}}
                <div class="m-auto mb-4">
                    <h1 class="text-3xl">
                        @if (isset($totalReportadas) && $totalReportadas === 1)
                            Actividad Reportada
                        @elseif (isset($totalReportadas) && $totalReportadas > 1)
                            Actividades Reportadas
                        @else
                            No Presenta Reportes
                        @endif
                    </h1>
                </div>
                {{-- Si es que le reportaron entonces que muestre en especifico que le reportaron --}}
                {{-- 1-Perfil 2-Comentarios 3-Contenido  --}}
                @if (isset($totalReportadas) && $totalReportadas > 0)
                    @foreach ($actividadesReportadas as $actividad)
                        <h2 class="text-2xl mb-4">
                            @if (isset($actividad['tipoActividad']) && $actividad['tipoActividad'] === 2)
                                Fue Reportado desde los Comentarios
                            @elseif (isset($actividad['tipoActividad']) && $actividad['tipoActividad'] === 3)
                                Fue Reportado desde el Contenido
                            @elseif (isset($actividad['tipoActividad']) &&
                                    $actividad['tipoActividad'] === 3 &&
                                    isset($actividad['tipoActividad']) &&
                                    $actividad['tipoActividad'] === 2)
                                Fue Reportado desde los Comentarios y el Contenido
                            @else
                                Fue Reportado desde el Perfil
                            @endif
                        </h2>
                    @endforeach

                @endif

                {{-- Cierres divs --}}
            </div>
        </div>
    </div>
    <div class="py-8 flex justify-center items-center">
        @if ($totalReportadas === 0 && $totalNoReportadas === 0)
            <!-- Si no hay actividades reportadas, ni no reportadas -->
            <h1 class="text-3xl  text-center">
                El usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b> no ha realizado
                ninguna
                actividad.
            </h1>
        @elseif ($totalReportadas === count($actividades))
            <!-- Si todas las actividades fueron reportadas -->
            <h1 class="text-3xl text-center">
                Todas las publicaciones del usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b>
                fueron reportadas.
            </h1>
        @elseif ($totalReportadas > 0 && $totalNoReportadas > 0)
            <p>Se le han reportado algunas actividades.</p>
        @else
            <!-- Si hay actividades, pero no reportadas -->
            <h1 class="text-3xl  text-center">
                El usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b> tiene actividades
                registradas, pero ninguna ha sido reportada..
            </h1>
        @endif
    </div>
</x-AppLayout>
