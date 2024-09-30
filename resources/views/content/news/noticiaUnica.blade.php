<x-AppLayout>
    <!-- Container -->
    <div class="bg-[#232125] min-h-[86.5vh] px-5 py-16 md:px-10 md:py-10">
        {{-- Botón para modificar: solo el autor puede modificar --}}
        @auth
            @if ((Auth::user()->idusuarios == Auth::user()->rol->idrol) == 1 || Auth::user()->rol->idrol == 2)
                <div class="flex gap-5 mb-5">
                    <a href="{{ route('editarP', $recuperoPublicacion->idcontenidos) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modificar</a>
                    {{-- Botón para eliminar: el autor o los usuarios con rol 1 o 2 pueden eliminar --}}
                    <form action="{{ route('eliminarContenido', $recuperoPublicacion->idcontenidos) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                    </form>
                </div>
            @endif
        @endauth
        <!-- Title -->
        <h2 class="text-center text-3xl font-bold md:text-5xl lg:text-left"> {{ $recuperoPublicacion->titulo }} </h2>
        <br>
        <!-- Content -->
        <div class="mx-auto w-full h-full grid gap-10 lg:grid-cols-2 lg:auto-rows-min">
            <div class="flex flex-col gap-4 rounded-md">
                @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 0)
                    <!-- Mostrar la primera imagen de la lista -->
                    <img src="{{ asset(Storage::url($listaPublicacionConImg[0])) }}" alt="Imagen Principal"
                        class="w-full h-72 inline-block object-cover">
                @else
                    <!-- Mostrar una imagen por defecto si no hay imágenes disponibles -->
                    <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                        class="w-full h-72 inline-block object-cover">
                @endif
                {{-- EN CASO DE QUE HAYA IMÁGENES --}}
                @if (count($listaPublicacionConImg) > 1)
                    @foreach (array_slice($listaPublicacionConImg, 1) as $imagen)
                        <div class="p-5 sm:p-8">
                            <div
                                class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                                <img src="{{ asset(Storage::url($imagen)) }}" alt="Imagen de la banda">
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="flex flex-col items-start py-4">
                    <div class="mb-4 rounded-md bg-gray-100 px-2 py-1.5">
                        <p class="text-sm font-semibold text-blue-600"> {{ $recuperoPublicacion->fechaSubida }} </p>
                    </div>
                    <p class="mb-4 text-base font-normal md:text-lg"> {{ $recuperoPublicacion->descripcion }} </p>
                </div>

            </div>
            {{-- Apartado Noticias y eventos --}}
            <div class="lg:flex lg:gap-4 lg:flex-col">
                {{-- NOTICIAS --}}
                <div
                    class="center w-full mb-4 lg:mb-0 relative inline-block select-none whitespace-nowrap rounded-lg bg-red-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white">
                    Noticias
                </div>
                <ul class="lg:overflow-y-auto lg:max-h-72 custom-scrollbar">
                    @foreach ($mostrarAparteNoticias as $noticiaExtra)
                        <a href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}">
                            <li href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}"
                                class="flex flex-col pb-5 lg:mb-3 lg:flex-row lg:border-b lg:border-gray-300">
                                @if (isset($noticiaExtra->imagenes) && !empty($noticiaExtra->imagenes[0]))
                                    <img src="{{ asset(Storage::url($noticiaExtra->imagenes[0])) }}"
                                        alt="Imagen de {{ $noticiaExtra->titulo }}"
                                        class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @else
                                    <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                        class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @endif
                                <div class="flex flex-col gap-3 items-start pt-4 lg:px-8">
                                    <div class="flex gap-2 items-center">
                                        <p class="text-sm font-semibold">Fecha de Publicacion:</p>
                                        <div class="rounded-md bg-gray-100 px-2 py-1.5">
                                            <p class="text-sm font-semibold text-blue-600">
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
                <ul class="lg:overflow-y-auto lg:max-h-72 custom-scrollbar">
                    @foreach ($mostrarAparteEventos as $eventos)
                        <a href="{{ route('eventos') }}">
                            <li href="#"
                                class="flex flex-col pb-5 lg:mb-3 lg:flex-row lg:border-b lg:border-gray-300">
                                @if (isset($eventos['imagenes']) && !empty($eventos['imagenes'][0]))
                                    <img src="{{ asset(Storage::url($eventos['imagenes'][0])) }}"
                                        alt="Imagen de {{ $eventos['nombreLugar'] }}"
                                        class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @else
                                    <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                        class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                                @endif
                                <div class="flex flex-col gap-3 items-start pt-4 lg:px-8">
                                    <div class="flex gap-2 items-center">
                                        <p class="text-sm font-semibold">Fecha del Evento:</p>
                                        <div class="rounded-md bg-gray-100 px-2 py-1.5">
                                            <p class="text-sm font-semibold text-blue-600"> {{ $eventos['fechashow'] }}
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
</x-AppLayout>
