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
        <div class="grid grid-cols-1 md:grid-cols-12 border">
            {{-- IZQUIERDO --}}
            <div class="bg-red-500  md:col-span-4 p-10 ">
                {{-- ENCABEZADO DEL USUARIO --}}

                <div class="flex justify-evenly">
                    <h1 class='text-2xl font-semibold text-center uppercase'>
                        @if ((isset($totalReportadas) && $totalReportadas > 0) || (isset($perfilReportado) && $perfilReportado))
                            No Presenta Reportes
                        @elseif ($totalReportadas === 1)
                            Actividad Reportada
                        @elseif ($totalReportadas > 1)
                            Actividades Reportadas
                        @else
                            Fue Reportado el Perfil
                        @endif
                    </h1>

                    <a class="bg-white hover:bg-gray-400 hover:text-white text-black text-base font-bold py-2 px-2 border-b-4 border-gray-700 hover:border-gray-500 rounded flex items-center"
                        href="">
                        Manejar Reporte
                    </a>
                </div>


                {{-- DATOS DEL USUARIO --}}
                <div class="max-w-4xl mx-auto px-4 py-8">
                    <div class=" space-y-4">
                        <div class="py-4 rounded shadow-md  bg-gray-50">
                            <div class="flex p-4 space-x-4 sm:px-8">
                                <img id="imagen"
                                    class="cursor-pointer imagen-modal object-cover object-center w-full h-24 max-w-24 rounded-lg"
                                    src="{{ $imagen ? asset(Storage::url($imagen)) : asset('img/logo_usuario.png') }}"
                                    alt="Foto de perfil">
                                <div class="flex-1 py-2 space-y-4">
                                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                                        <div class="text-lg font-semibold break-words">
                                            {{ $datosPersonales->nombreDP . ' ' . $datosPersonales->apellidoDP }}
                                        </div>
                                        <div class="text-sm text-gray-600 break-words">
                                            {{ $usuario->usuarioUser }}
                                        </div>
                                    </a>
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
                {{-- ENCABEZADO DE REPORTES --}}
                <div class="m-auto mb-4">
                    <h1 class="text-3xl">
                        @if ($perfilReportado < 1)
                            No Presenta Reportes
                        @elseif ($totalReportadas === 1)
                            Actividad Reportada
                        @elseif ($totalReportadas > 1)
                            Actividades Reportadas
                        @else
                            Fue Reportado el Perfil
                        @endif
                    </h1>

                </div>
                {{-- Si es que le reportaron entonces que muestre en especifico que le reportaron --}}
                {{-- 1-Perfil 2-Comentarios 3-Contenido --}}
                @if ($perfilReportado >= 1)
                    {{-- SI LE REPORTARON EL PERFIL --}}
                    <a href="{{ route('perfil-ajeno', $usuario->idusuarios) }}">
                        <h1 class=" mb-4 text-2xl">Revisa el perfil de <b
                                class="text-red-500">{{ $usuario->usuarioUser }}</b>
                        </h1>
                    </a>
                @endif
                {{-- SI LE REPORTARON PUBLICACION O PERFIL --}}
                @if ($totalReportadas >= 1)
                    {{-- SI LE REPORTARON LA PUBLICACION --}}
                    @if (count($actividadesReportadas['contenidos']) > 0)
                        <h2 class="text-2xl mb-4"> Publicaciones <b class=" text-base font-thin italic text-red-500">*
                                Podes acceder a la publicación haciendo clic en el titulo</b></h2>
                        <!-- Mostrar publicaciones reportadas -->
                        @foreach ($actividadesReportadas['contenidos'] as $contenido)
                            <div class="relative ml-0 md:mr-10">
                                <span class="absolute top-0 left-0 w-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                <div class="relative p-5 bg-white border-2 border-red-500 rounded-lg">
                                    <div class="flex items-center -mt-1">
                                        <a href={{ route('foroUnico', $contenido['id']) }}>
                                            <h3 class="my-2 ml-3 text-2xl font-bold text-gray-800">
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
                                                <div class="group relative cursor-pointer">
                                                    <img src="{{ asset(Storage::url($imagen)) }}"
                                                        alt="ImagenesCargadas"
                                                        class="imagen-modal cursor-pointer w-full h-48 object-cover object-center max-w-full rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Botón para eliminar publicacion -->
                            @if (Auth::user()->rol->idrol == 1)
                                <form class="my-4" action="{{ route('eliminarContenido', $contenido['id']) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-2 border-b-4 border-red-700 hover:border-red-500 rounded flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <p class="text-base font-semibold ml-1">Eliminar</p>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    @endif

                    {{-- SI LE REPORTARON EL COMENTARIO --}}
                    @if (count($actividadesReportadas['comentarios']) > 0)
                        <h2 class="text-2xl mb-4"> Comentarios <b class=" text-base font-thin italic text-red-500">*
                                Podes visualizar el comentario desde la publicación haciendo clic en el titulo</b>
                        </h2>
                        <!-- Mostrar comentarios reportados -->
                        @foreach ($actividadesReportadas['comentarios'] as $contenido)
                            <div class="relative ml-0 md:mr-10">
                                <span class="absolute top-0 left-0 w-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                <div class="relative p-5 bg-white border-2 border-red-500 rounded-lg">
                                    <div class="flex items-center -mt-1">
                                        <a href={{ route('foroUnico', $contenido['idComentario']) }}>
                                            <h3 class="my-2 ml-3 text-2xl font-bold text-gray-800">
                                                {{ $contenido['tituloContenido'] }}
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
                                                <div class="group relative cursor-pointer">
                                                    <img src="{{ asset(Storage::url($imagen)) }}"
                                                        alt="ImagenesCargadas"
                                                        class="imagen-modal cursor-pointer w-full h-48 object-cover object-center max-w-full rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                            <!-- Botón para eliminar comentario -->
                            @if (Auth::user()->rol->idrol == 1)
                                <form class="mt-4"
                                    action="{{ route('eliminarComentario', $contenido['idComentario']) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-2 border-b-4 border-red-700 hover:border-red-500 rounded flex items-center"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <p class="text-base font-semibold ml-1">Eliminar</p>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    @endif
                @endif

                {{-- SI NO HAY ACTIVIDADES REPORTADAS NI NO REPORTADAS --}}
                @if ($totalReportadas === 0 && $totalNoReportadas === 0)
                    <div class="py-8 flex justify-center h-full items-center">
                        <!-- Si no hay actividades reportadas, ni no reportadas -->
                        <h1 class="text-3xl text-center">
                            El usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b> no ha realizado
                            ninguna
                            actividad.
                        </h1>
                    </div>
                    {{-- SI TIENE ACTIVIDADES PERO NI UNA REPORTADA --}}
                @elseif ($totalReportadas === 0 && $totalNoReportadas >= 1)
                    <h1 class="text-3xl mb-4 text-center">
                        Actividades Registradas <b class="text-base font-thin italic text-red-500"> * No Reportadas.
                        </b>
                    </h1>
                    {{-- SI NO REPORTARON LA PUBLICACION --}}
                    @if (count($actividadesNoReportadas['contenidos']) > 0)
                        <h2 class="text-2xl mb-4"> Publicaciones <b
                                class=" text-base font-thin italic text-red-500 ">*
                                Podes acceder a la publicación haciendo clic en el titulo</b></h2>
                        <!-- Mostrar publicaciones  -->
                        @foreach ($actividadesNoReportadas['contenidos'] as $contenido)
                            <div class="relative ml-0 md:mr-10">
                                <span class="absolute top-0 left-0 w-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                <div class="relative p-5 bg-white border-2 border-red-500 rounded-lg">
                                    <div class="flex items-center -mt-1">
                                        <a href={{ route('foroUnico', $contenido['id']) }}>
                                            <h3 class="my-2 ml-3 text-2xl font-bold text-gray-800">
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
                                                <div class="group relative cursor-pointer">
                                                    <img src="{{ asset(Storage::url($imagen)) }}"
                                                        alt="ImagenesCargadas"
                                                        class="imagen-modal cursor-pointer w-full h-48 object-cover object-center max-w-full rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                            <!-- Botón para eliminar publicacion -->
                            @if (Auth::user()->rol->idrol == 1)
                                <form class="my-4" action="{{ route('eliminarContenido', $contenido['id']) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <p class="text-base font-semibold">Eliminar</p>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    @endif
                    {{-- SI NO REPORTARON EL COMENTARIO --}}
                    @if (count($actividadesNoReportadas['comentarios']) > 0)
                        <h2 class="text-2xl mb-4"> Comentarios <b class=" text-base font-thin italic text-red-500">*
                                Podes visualizar el comentario desde la publicación haciendo clic en el
                                titulo</b>
                        </h2>
                        <!-- Mostrar comentarios -->
                        @foreach ($actividadesNoReportadas['comentarios'] as $contenido)
                            <div class="relative ml-0 md:mr-10">
                                <span class="absolute top-0 left-0 w-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                                <div class="relative p-5 bg-white border-2 border-red-500 rounded-lg">
                                    <div class="flex items-center -mt-1">
                                        <a href={{ route('foroUnico', $contenido['idComentario']) }}>
                                            <h3 class="my-2 ml-3 text-2xl font-bold text-gray-800">
                                                {{ $contenido['tituloContenido'] }}
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
                                                <div class="group relative cursor-pointer">
                                                    <img src="{{ asset(Storage::url($imagen)) }}"
                                                        alt="ImagenesCargadas"
                                                        class="imagen-modal cursor-pointer w-full h-48 object-cover object-center max-w-full rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                            <!-- Botón para eliminar comentario -->
                            @if (Auth::user()->rol->idrol == 1)
                                <form class="my-4"
                                    action="{{ route('eliminarComentario', $contenido['idComentario']) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <p class="text-base font-semibold">Eliminar</p>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    @endif
                @endif
                {{-- Cierres divs --}}
            </div>
        </div>
        <!-- SI TODAS LAS ACTIVIDADES FUERON REPORTADAS -->
        @if ($totalReportadas === count($actividades) && count($actividades) !== 0)
            <div class="py-8 flex justify-center items-center">
                <!-- Si todas las actividades fueron reportadas -->
                <h1 class="text-3xl text-center">
                    Todas las publicaciones del usuario <b class="text-red-500">{{ $usuario->usuarioUser }}</b>
                    fueron reportadas.
                </h1>
            </div>
            {{-- SI TIENE ACTIVIDADES REPORTADAS Y NO REPORTADAS --}}
        @elseif ($totalReportadas > 0 && $totalNoReportadas > 0)
            <div class="py-8 flex flex-col ml-4">
                <h1 class="text-3xl mb-4 ml-4 text-center">
                    Otras Actividades realizadas por <b class="text-red-500">{{ $usuario->usuarioUser }}</b>
                </h1>
                {{-- SI NO REPORTARON LA PUBLICACION --}}
                @if (count($actividadesNoReportadas['contenidos']) > 0)
                    <h2 class="text-2xl mb-4 justify-normal"> Publicaciones <b
                            class=" text-base font-thin italic text-red-500 ">*
                            Podes acceder a la publicación haciendo clic en el titulo</b></h2>
                    <!-- Mostrar publicaciones  -->
                    @foreach ($actividadesNoReportadas['contenidos'] as $contenido)
                        <div class="relative ml-0 md:mr-10">
                            <span class="absolute top-0 left-0 w-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                            <div class="relative p-5 bg-white border-2 border-red-500 rounded-lg">
                                <div class="flex items-center -mt-1">
                                    <a href={{ route('foroUnico', $contenido['id']) }}>
                                        <h3 class="my-2 ml-3 text-2xl font-bold text-gray-800">
                                            {{ $contenido['titulo'] }}
                                        </h3>
                                    </a>
                                </div>
                                <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">Fecha de la
                                    publicación: {{ $contenido['fechaComent'] }} </p>
                                <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}</p>
                                {{-- Imagenes NO REPORTADAS CONTENIDO --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                                    @foreach ($contenido['rutaImagen'] as $imagen)
                                        <div class="group cursor-pointer relative">
                                            <div class="group relative cursor-pointer">
                                                <img src="{{ asset(Storage::url($imagen)) }}" alt="ImagenesCargadas"
                                                    class="imagen-modal cursor-pointer w-full h-48 object-cover object-center max-w-full rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button
                                                        class="btn-ampliar bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                                        Ampliar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Botón para eliminar publicacion -->
                        @if (Auth::user()->rol->idrol == 1)
                            <form class="my-4" action="{{ route('eliminarContenido', $contenido['id']) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-2 border-b-4 border-red-700 hover:border-red-500 rounded flex items-center">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                    <p class="text-base font-semibold ml-1">Eliminar</p>
                                </button>
                            </form>
                        @endif
                    @endforeach
                @endif
                {{-- SI NO REPORTARON EL COMENTARIO --}}
                @if (count($actividadesNoReportadas['comentarios']) > 0)
                    <h2 class="text-2xl mb-4 justify-normal"> Comentarios <b
                            class=" text-base font-thin italic text-red-500">*
                            Podes visualizar el comentario desde la publicación haciendo clic en el
                            titulo</b>
                    </h2>
                    <!-- Mostrar comentarios -->
                    @foreach ($actividadesNoReportadas['comentarios'] as $contenido)
                        <div class="relative ml-0 md:mr-10">
                            <span class="absolute top-0 left-0 w-full mt-1 ml-1 bg-red-500 rounded-lg"></span>
                            <div class="relative p-5 bg-white border-2 border-red-500 rounded-lg">
                                <div class="flex items-center -mt-1">
                                    <a href={{ route('foroUnico', $contenido['idComentario']) }}>
                                        <h3 class="my-2 ml-3 text-2xl font-bold text-gray-800">
                                            {{ $contenido['tituloContenido'] }}
                                        </h3>
                                    </a>
                                </div>
                                <p class="mt-3 mb-1 text-xs font-medium text-red-500 uppercase">Fecha de la
                                    publicación: {{ $contenido['fechaComent'] }} </p>
                                <p class="mb-2 text-gray-600">{{ $contenido['descripcion'] }}</p>
                                {{-- Imagenes NO REPORTADAS CONTENIDO --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                                    @foreach ($contenido['rutaImagen'] as $imagen)
                                        <div class="group cursor-pointer relative">
                                            <div class="group relative cursor-pointer">
                                                <img src="{{ asset(Storage::url($imagen)) }}" alt="ImagenesCargadas"
                                                    class="imagen-modal cursor-pointer w-full h-48 object-cover object-center max-w-full rounded-lg transition-transform transform scale-100 group-hover:scale-105" />
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button
                                                        class="btn-ampliar bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                                        Ampliar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        <!-- Botón para eliminar publicacion -->
                        @if (Auth::user()->rol->idrol == 1)
                            <form class="my-4"
                                action="{{ route('eliminarContenido', $contenido['idComentario']) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-5 py-2 px-10 hover:bg-gray-300">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                    <p class="text-base font-semibold my-1">Eliminar</p>
                                </button>
                            </form>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif
    </div>
    <!-- Contenedor del modal -->
    <div id="modal" class="hidden imagenG">
        <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>

</x-AppLayout>
