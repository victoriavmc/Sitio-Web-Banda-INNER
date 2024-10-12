<x-AppLayout>
    <div class="bg-white min-h-screen">
        <div class="min-h-screen bg-white">
            <header class="bg-gray-300 py-8">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="flex justify-center items-center space-x-4">
                        <h1 class='text-5xl'>Reportes</h1>
                    </div>
                </div>
            </header>
            {{-- #DIVS  --}}
            <div class="grid grid-cols-1 md:grid-cols-12 border">
                {{-- #IZQUIERDO --}}
                <div class="bg-gray-900 md:col-span-4 p-10">
                    <h1 class='text-2xl text-red-600 text-center'> USUARIO REPORTADO </h1>
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
                {{-- #DERECHO --}}
                <div class="md:col-span-8 p-10">
                    <div class="m-auto mb-4">
                        <h1 class="text-3xl">
                            @if (isset($reportes['totalReportes']) && $reportes['totalReportes'] === 1)
                                Actividad Reportada
                            @elseif (isset($reportes['totalReportes']) && $reportes['totalReportes'] > 1)
                                Actividades Reportadas
                            @else
                                No Presenta Reportes
                            @endif
                        </h1>
                    </div>
                    <div class="w-full">
                        @if (empty($listaActividadReportadaContenido) && empty($listaActividadReportadaComentario))
                            <div class="relative h-full ml-0 md:mr-10">
                                <span
                                    class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-gray-400 rounded-lg"></span>
                                <div class="relative h-full p-5 bg-white border-2 border-gray-400 rounded-lg">
                                    <h3 class="my-2 ml-3 text-lg font-bold text-gray-800">
                                        No se presentan reportes de publicaciones ni comentarios.
                                    </h3>
                                </div>
                            </div>

                            {{-- Actividades realizadas por el usuario --}}

                            <div class="flex flex-col ml-4 sm:flex-wrap">
                                <div class="mt-5 mb-5 w-full">
                                    @if (count($actividades) > 0)
                                        <h1 class="text-3xl mb-4">
                                            Otras Actividades realizadas por <b
                                                class="text-red-500">{{ $usuario->usuarioUser }}</b>
                                        </h1>
                                        <!-- Aquí puedes listar las actividades del usuario -->
                                        @if (count($listaActividadNOReportadaContenido) > 0)
                                            <h2 class="text-2xl ml-4 mb-4"> Publicaciones</h2>
                                            <!-- Mostrar publicaciones reportadas -->
                                            @foreach ($listaActividadNOReportadaContenido as $contenido)
                                                <div class="relative h-full md:mr-10 mb-6 ml-4">
                                                    <span
                                                        class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                                    <div
                                                        class="relative h-full p-5 bg-white border-2 border-red-500 rounded-lg">
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
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if (count($listaActividadNOReportadaComentario) > 0)
                                            <h2 class="text-2xl ml-4 mb-4"> Comentarios</h2>
                                            <!-- Mostrar comentarios reportados -->
                                            @foreach ($listaActividadNOReportadaComentario as $contenido)
                                                <div class="relative h-full ml-4 md:mr-10 mb-6">
                                                    <span
                                                        class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                                    <div
                                                        class="relative h-full p-5 bg-white border-2 border-red-500 rounded-lg">
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
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                </div>
                            </div>
                        @else
                            <h1 class="text-3xl">
                                El usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b> no
                                ha realizado ninguna actividad.
                            </h1>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@else
    @if (count($listaActividadReportadaContenido) > 0)
        <h2 class="text-2xl mb-4"> Publicaciones</h2>
        <!-- Mostrar publicaciones reportadas -->
        @foreach ($listaActividadReportadaContenido as $contenido)
            <div class="relative h-full ml-0 md:mr-10 mb-6">
                <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
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
                </div>
            </div>
        @endforeach
    @endif
    @if (count($listaActividadReportadaComentario) > 0)
        <h2 class="text-2xl mb-4"> Comentarios</h2>
        <!-- Mostrar comentarios reportados -->
        @foreach ($listaActividadReportadaComentario as $contenido)
            <div class="relative h-full ml-0 md:mr-10 mb-6">
                <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
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
                </div>
            </div>
        @endforeach
    @endif
    </div>
    </div>
    </div>
    <div class="mt-5 mb-5 w-full">
        @if ($totalNoReportadas > 0)
            <h1 class="text-3xl mb-4 ml-4">
                Otras Actividades realizadas por <b class="text-red-500">{{ $usuario->usuarioUser }}</b>
            </h1>
            <!-- Aquí puedes listar las actividades del usuario -->
            @if (count($listaActividadNOReportadaContenido) > 0)
                <h2 class="text-2xl ml-4 mb-4"> Publicaciones</h2>
                <!-- Mostrar publicaciones reportadas -->
                @foreach ($listaActividadNOReportadaContenido as $contenido)
                    <div class="relative h-full md:mr-10 mb-6 ml-4">
                        <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
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
                        </div>
                    </div>
                @endforeach
            @endif

            @if (count($listaActividadNOReportadaComentario) > 0)
                <h2 class="text-2xl ml-4 mb-4"> Comentarios</h2>
                <!-- Mostrar comentarios reportados -->
                @foreach ($listaActividadNOReportadaComentario as $contenido)
                    <div class="relative h-full ml-4 md:mr-10 mb-6">
                        <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
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
                            <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">
                                Fecha del
                                comentario: {{ $contenido['fechaComent'] }}</p>
                            <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        @elseif (count($listaActividadReportadaContenido) > 0 || count($listaActividadReportadaComentario) > 0)
            <!-- Si no hay actividades no reportadas pero sí reportadas -->
            <h1 class="text-3xl text-center">
                Todas las publicaciones del usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b>
                fueron reportadas.
            </h1>
        @else
            <!-- Si no hay actividades reportadas ni no reportadas -->
            <h1 class="text-3xl  text-center">
                El usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b> no ha realizado ninguna
                actividad.
            </h1>
        @endif
    </div>
    @endif
</x-AppLayout>
