<x-AppLayout>
    <style>
        #modal {
            z-index: 999;
            /* Asegura que el modal esté al frente */
        }

        .imagen {
            transition: transform 0.3s ease;
        }

        #modalImage {
            transition: transform 0.3s ease;
            cursor: pointer;
            /* Añade un cursor pointer para cerrar el modal al hacer clic */
        }
    </style>

    <!-- Container -->
    <div class="min-h-screen px-5 py-16 md:px-10 md:py-10">
        {{-- Botón para modificar: solo el autor puede modificar --}}
        @auth
            @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                <div class="flex gap-5 mb-5">
                    <a href="{{ route('editarP', ['id' => $recuperoPublicacion->idcontenidos, 'tipo' => 3]) }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Modificar</a>
                    {{-- Botón para eliminar: el autor o los usuarios con rol 1 o 2 pueden eliminar --}}
                    <form class="btnEliminarContenido" action="{{ route('eliminarContenido', $recuperoPublicacion->idcontenidos) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                    </form>
                </div>
            @endif
        @endauth

        <!-- Content -->
        <div
            class="mx-auto w-full h-full grid gap-5 lg:grid-cols-[60%_40%] lg:auto-rows-min bg-white rounded-xl p-4 shadow-xl">
            <div class="flex flex-col gap-4 lg:border-r-2 lg:pr-5">
                <!-- Title -->
                <h2 class="mb-3 text-3xl font-bold md:text-5xl lg:text-left"> {{ $recuperoPublicacion->titulo }}
                </h2>

                @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 0)
                    <!-- Mostrar la primera imagen de la lista -->
                    <div class="w-full flex justify-center">
                        <img src="{{ asset(Storage::url($listaPublicacionConImg[0])) }}" alt="Imagen Principal"
                            id="imagen" class="cursor-pointer imagen-modal w-80 h-full inline-block object-cover">
                    </div>
                @else
                    <!-- Mostrar una imagen por defecto si no hay imágenes disponibles -->
                    <div class="w-full flex justify-center">
                        <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                            class="w-80 h-full inline-block object-cover">
                    </div>
                @endif
                {{-- EN CASO DE QUE HAYA IMÁGENES --}}
                @if (count($listaPublicacionConImg) > 1)
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                        @foreach (array_slice($listaPublicacionConImg, 1) as $imagen)
                            <div class="">
                                <img id="imagen"
                                    class="cursor-pointer imagen-modal object-cover object-center w-full h-40 max-w-full rounded-lg"
                                    src="{{ asset(Storage::url($imagen)) }}" alt="Imagen de la banda">
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="flex flex-col items-start py-4">
                    <div class="mb-4 rounded-md shadow-xl bg-red-500 px-2 py-1.5">
                        <p class="text-sm font-semibold text-white"> {{ $recuperoPublicacion->fechaSubida }} </p>
                    </div>
                    <p class="mb-4 text-base font-normal md:text-lg"> {{ $recuperoPublicacion->descripcion }} </p>
                </div>

            </div>
            {{-- Apartado Noticias y eventos --}}
            <div class="lg:flex lg:gap-4 lg:flex-col lg:pr-4">
                {{-- NOTICIAS --}}
                <div
                    class="center w-full mb-4 lg:mb-0 relative inline-block select-none whitespace-nowrap rounded-lg bg-red-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white">
                    Noticias
                </div>
                <ul class="lg:overflow-y-auto lg:max-h-72 custom-scrollbar">
                    @foreach ($mostrarAparteNoticias as $noticiaExtra)
                        <a href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}">
                            <li href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}"
                                class="flex flex-col p-2 lg:flex-row lg:border-b lg:border-gray-300">
                                @if (isset($noticiaExtra->imagenes) && !empty($noticiaExtra->imagenes[0]))
                                    <img src="{{ asset(Storage::url($noticiaExtra->imagenes[0])) }}"
                                        alt="Imagen de {{ $noticiaExtra->titulo }}"
                                        class=" inline-block h-60 rounded-xl w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @else
                                    <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                        class="inline-block h-60 rounded-xl w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @endif
                                <div class="flex flex-col gap-3 items-start pt-4 lg:px-8">
                                    <div class="flex gap-2 items-center">
                                        <p class="text-sm font-semibold">Fecha de Publicacion:</p>
                                        <div class="rounded-md shadow-xl bg-red-500 px-2 py-1.5">
                                            <p class="text-sm font-semibold text-white">
                                                {{ $noticiaExtra->fechaSubida }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mb-2 text-sm font-bold sm:text-base"> {{ $noticiaExtra->titulo }} </p>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
                {{-- EVENTOS --}}
                <div
                    class="center w-full mb-4 lg:mb-0 relative inline-block select-none whitespace-nowrap rounded-lg bg-[#000] py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white">
                    Eventos
                </div>
                <ul class="lg:max-h-72">
                    @foreach ($mostrarAparteEventos as $eventos)
                        <a href="{{ route('eventos') }}">
                            <li class="flex flex-col lg:flex-row p-2 lg:border-b lg:border-gray-300">
                                @if (isset($eventos['imagenes']) && !empty($eventos['imagenes'][0]))
                                    <img src="{{ asset(Storage::url($eventos['imagenes'][0])) }}"
                                        alt="Imagen de {{ $eventos['nombreLugar'] }}"
                                        class="inline-block h-60 rounded-xl w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @else
                                    <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                        class="inline-block h-60 rounded=xl w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @endif
                                <div class="flex flex-col gap-3 items-start pt-4 lg:px-8">
                                    <div class="flex gap-2 items-center">
                                        <p class="text-sm font-semibold">Fecha del Evento:</p>
                                        <div class="rounded-md shadow-xl bg-red-500 px-2 py-1.5">
                                            <p class="text-sm font-semibold text-white"> {{ $eventos['fechashow'] }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mb-2 text-sm font-bold sm:text-base"> {{ $eventos['nombreLugar'] }} </p>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Contenedor del modal -->
    <div id="modal" class="hidden imagenG">
        <div id="modal" class=" fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center">
            <img id="modalImage" class="max-w-7xl h-3/4 rounded-lg">
        </div>
    </div>
</x-AppLayout>
