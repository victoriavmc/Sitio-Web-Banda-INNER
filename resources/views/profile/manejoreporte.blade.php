<x-AppLayout>
    <!-- Div Principal -->
    <div class="bg-white min-h-screen">

        <!-- Encabezado -->
        <div class="bg-white">
            <header class="bg-gray-300 py-8">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="flex justify-center items-center space-x-4">
                        <h1 class='text-5xl'>Reportes</h1>
                    </div>
                </div>
            </header>
        </div>
        <!-- 2 Columnas -->
        <div class="h-full grid grid-cols-1 md:grid-cols-12 border">
            <!-- Izquierda -->
            <div class="bg-red-500  md:col-span-4 p-10 ">
                <!-- Diferencia entre usuario reportado y solo historial del usuario -->
                @if (isset($reportes['totalReportes']) && $reportes['totalReportes'] > 0)
                    <h1 class='text-2xl font-semibold text-center'> USUARIO REPORTADO </h1>
                @else
                    <h1 class='text-2xl font-semibold text-center uppercase'> Historial del Usuario
                    </h1>
                @endif

                <!-- Datos Personales del usuario -->
                <div class="max-w-4xl mx-auto px-4 py-8">
                    <div class=" space-y-4">
                        <div class="py-4 rounded shadow-md  bg-gray-50">
                            <div class="flex p-4 space-x-4 sm:px-8">
                                <div class="flex-shrink-0 w-24 h-24">
                                    <img src="{{ $imagen ? asset(Storage::url($imagen)) : asset('img/logo_usuario.png') }}"
                                        alt="Foto de perfil">
                                </div>
                                <div class="flex-1 py-2 space-y-4">
                                    <div class="w-full h-3">
                                        {{ $datosPersonales->nombreDP . ' ' . $datosPersonales->apellidoDP }}
                                    </div>
                                    <div class="w-5/6 h-3">
                                        {{ $usuario->usuarioUser }}
                                    </div>
                                    <div class="w-full h-4">{{ $usuario->rol->rol }} </div>
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

            <!-- Derecha -->
            <div class="md:col-span-8 p-10">
                <!-- Caso segun reporte -->
                <div class="m-auto mb-4">
                    <h1 class="text-3xl">
                        @if (isset($reportes['totalReportes']) && $reportes['totalReportes'] == 1)
                            Actividad Reportada
                        @elseif (isset($reportes['totalReportes']) && $reportes['totalReportes'] > 1)
                            Actividades Reportadas
                        @elseif (
                            (isset($reportes['totalReportes']) &&
                                $reportes['totalReportes'] === 0 &&
                                count($listaActividadReportadaContenido) === 0) ||
                                count($listaActividadReportadaComentario) === 0)
                            <h1 class="text-3xl  text-center">
                                El usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b> no ha realizado
                                ninguna
                                actividad.
                            </h1>
                        @else
                            No Presenta Reportes
                        @endif
                    </h1>
                </div>

                <!-- Verifico si presenta Actividades realizadas -->
                <div class="w-full">
                    <!-- No le reportaron nada -->
                    @if (empty($listaActividadReportadaContenido) && empty($listaActividadReportadaComentario))
                        <div class="relative h-full ml-0 md:mr-10">
                            <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-blue-400 rounded-lg"></span>
                            <div class="relative h-full p-5 bg-white border-2 border-blue-400 rounded-lg">
                                <h3 class="my-2 ml-3 text-lg font-bold text-gray-800">
                                    No se presentan reportes de publicaciones ni comentarios.
                                </h3>
                            </div>
                        </div>
                        <!-- Le reportaron Publicaciones -->
                    @elseif(count($listaActividadReportadaContenido) > 0)
                        <h2 class="text-2xl mb-4"> Publicaciones <b class=" text-base font-thin italic">*
                                Podes acceder a la publicación haciendo clic en el titulo</b></h2>
                        <!-- Mostrar publicaciones reportadas -->
                        @foreach ($listaActividadReportadaContenido as $contenido)
                            <div class="relative h-full ml-0 md:mr-10 mb-6">
                                <span
                                    class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                <div class="relative h-full p-5 bg-white border-2 border-red-500 rounded-lg">
                                    <div class="flex items-center -mt-1">
                                        <a href={{ route('foroUnico', $contenido['id']) }}>
                                            <h3 class="my-2 ml-3 text-lg font-bold text-gray-800">
                                                {{ $contenido['titulo'] }}
                                            </h3>
                                        </a>

                                    </div>
                                    <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">Fecha de la
                                        publicación: {{ $contenido['fechaComent'] }} </p>
                                    <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}</p>
                                    {{-- Imagenes NO REPORTADAS CONTENIDO --}}
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                                        @foreach ($contenido['rutaImagen'] as $imagen)
                                            <div class="group cursor-pointer relative">
                                                <img src="{{ asset(Storage::url($imagen)) }}" alt="ImagenesCargadas"
                                                    class="w-full h-48 object-cover rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button
                                                        class="bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                                        Ampliar
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Le reportaron Comentarios -->
                    @elseif(count($listaActividadReportadaComentario) > 0)
                        <h2 class="text-2xl mb-4"> Comentarios <b class=" text-base font-thin italic">*
                                Podes visualizar el comentario desde la publicación haciendo clic en el titulo</b> </h2>
                        <!-- Mostrar comentarios reportados -->
                        @foreach ($listaActividadReportadaComentario as $contenido)
                            <div class="relative h-full ml-0 md:mr-10 mb-6">
                                <span
                                    class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                <div class="relative h-full p-5 bg-white border-2 border-red-500 rounded-lg">
                                    <div class="flex items-center -mt-1">
                                        <h3 class="my-2 ml-3 text-lg text-gray-800">
                                            Realizado en la publicación:
                                            <a href="{{ route('foroUnico', $contenido['id']) }}"" class="text-red-500">
                                                <b>
                                                    {{ $contenido['tituloContenido'] }}
                                                </b>
                                            </a>
                                        </h3>
                                    </div>
                                    <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">Fecha del
                                        comentario: {{ $contenido['fechaComent'] }}</p>
                                    <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}</p>
                                    {{-- Imagenes NO REPORTADAS COMENTARIOS --}}
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                                        @foreach ($contenido['rutaImagen'] as $imagen)
                                            <div class="group cursor-pointer relative">
                                                <img src="{{ asset(Storage::url($imagen)) }}" alt="ImagenesCargadas"
                                                    class="w-full h-48 object-cover rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button
                                                        class="bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                                        Ampliar
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <!-- Segun Le reportaron  -->
                    <div class="mt-5 mb-5 w-full">
                        @if ($totalNoReportadas > 0)
                            <!-- Si tiene otras actividades -->
                            <h1 class="text-3xl mb-4 ml-4">
                                Otras Actividades realizadas por <b
                                    class="text-red-500">{{ $usuario->usuarioUser }}</b>
                            </h1>
                            <!-- Contenidos no reportados -->
                            @if (count($listaActividadNOReportadaContenido) > 0)
                                <h2 class="text-2xl ml-4 mb-4"> Publicaciones <b class=" text-base font-thin italic">*
                                        Podes acceder a la publicación haciendo clic en el titulo</b></h2>
                                <!-- Mostrar publicaciones NO reportadas -->
                                @foreach ($listaActividadNOReportadaContenido as $contenido)
                                    <div class="relative h-full md:mr-10 mb-6 ml-4">
                                        <span
                                            class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                        <div class="relative h-full p-5 bg-white border-2 border-red-500 rounded-lg">
                                            <div class="flex items-center -mt-1">
                                                <a href={{ route('foroUnico', $contenido['id']) }}>
                                                    <h3 class="my-2 ml-3 text-lg font-bold text-gray-800">
                                                        {{ $contenido['titulo'] }}
                                                    </h3>
                                                </a>
                                            </div>
                                            <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">
                                                Fecha de la
                                                publicación: {{ $contenido['fechaComent'] }} </p>
                                            <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}
                                            </p>
                                            {{-- Imagenes REPORTADAS CONTENIDO --}}
                                            <div
                                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                                                @foreach ($contenido['rutaImagen'] as $imagen)
                                                    <div class="group cursor-pointer relative">
                                                        <img src="{{ asset(Storage::url($imagen)) }}"
                                                            alt="ImagenesCargadas"
                                                            class="w-full h-48 object-cover rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                        <div
                                                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <button
                                                                class="bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                                                Ampliar
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Comentarios no reportados -->
                            @if (count($listaActividadNOReportadaComentario) > 0)
                                <h2 class="text-2xl ml-4 mb-4"> Comentarios <b class=" text-base font-thin italic">*
                                        Podes visualizar el comentario desde la publicación haciendo clic en el
                                        titulo</b></h2>
                                <!-- Mostrar comentarios NO reportados -->
                                @foreach ($listaActividadNOReportadaComentario as $contenido)
                                    <div class="relative h-full ml-4 md:mr-10 mb-6">
                                        <span
                                            class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                        <div class="relative h-full p-5 bg-white border-2 border-red-500 rounded-lg">
                                            <div class="flex items-center -mt-1">

                                                <h3 class="my-2 ml-3 text-lg text-gray-800">
                                                    Realizado en la publicación:
                                                    <a href="{{ route('foroUnico', $contenido['id']) }}""
                                                        class="text-red-500">
                                                        <b>
                                                            {{ $contenido['tituloContenido'] }}
                                                        </b>
                                                    </a>
                                                </h3>

                                            </div>
                                            <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">
                                                Fecha del
                                                comentario: {{ $contenido['fechaComent'] }}</p>
                                            <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}
                                            </p>
                                            {{-- Imagenes REPORTADAS COMENTARIOS --}}
                                            <div
                                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                                                @foreach ($contenido['rutaImagen'] as $imagen)
                                                    <div class="group cursor-pointer relative">
                                                        <img src="{{ asset(Storage::url($imagen)) }}"
                                                            alt="ImagenesCargadas"
                                                            class="w-full h-48 object-cover rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                        <div
                                                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <button
                                                                class="bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                                                Ampliar
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @elseif (count($listaActividadReportadaContenido) > 0 || count($listaActividadReportadaComentario) > 0)
                            <!-- Si no hay actividades no reportadas pero sí reportadas -->
                            <h1 class="text-3xl text-center">
                                Todas las publicaciones del usuario <b
                                    class="text-red-500">{{ $usuario->usuarioUser }}</b>
                                fueron reportadas.
                            </h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-AppLayout>
