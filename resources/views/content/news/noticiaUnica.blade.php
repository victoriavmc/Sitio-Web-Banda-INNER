<x-AppLayout>
    <section class="bg-gray-900">
        <!-- Container -->
        <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
            <!-- Title -->
            <h2 class="text-center text-3xl font-bold md:text-5xl lg:text-left"> {{ $recuperoPublicacion->titulo }} </h2>
            <br>
            <!-- Content -->
            <div class="mx-auto grid gap-8 lg:grid-cols-2">
                <a href="#" class="flex flex-col gap-4 rounded-md [grid-area:1/1/4/2] lg:pr-8">
                    @if ($listaPublicacionConImg && count($listaPublicacionConImg) > 0)
                        <!-- Mostrar la primera imagen de la lista -->
                        <img src="{{ asset(Storage::url($listaPublicacionConImg[0])) }}" alt="Imagen Principal"
                            class="w-full h-72 inline-block object-cover">
                    @else
                        <!-- Mostrar una imagen por defecto si no hay imágenes disponibles -->
                        <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                            class="w-full h-72 inline-block object-cover">
                    @endif
                    <div class="flex flex-col items-start py-4">
                        <div class="mb-4 rounded-md bg-gray-100 px-2 py-1.5">
                            <p class="text-sm font-semibold text-blue-600"> {{ $recuperoPublicacion->fechaSubida }} </p>
                        </div>
                        <p class="mb-4 text-base font-normal md:text-lg"> {{ $recuperoPublicacion->descripcion }} </p>
                    </div>
                </a>
                {{-- Apartado Noticias y eventos --}}
                <div class="md:flex md:justify-between lg:flex-col">
                    {{-- NOTICIAS --}}
                    @foreach ($mostrarAparteNoticias as $noticiaExtra)
                        <a href="{{ route('noticiaUnica', $noticiaExtra->idcontenidos) }}"
                            class="flex flex-col pb-5 lg:mb-3 lg:flex-row lg:border-b lg:border-gray-300">
                            @if (isset($noticiaExtra->imagenes) && !empty($noticiaExtra->imagenes[0]))
                                <img src="{{ asset(Storage::url($noticiaExtra->imagenes[0])) }}"
                                    alt="Imagen de {{ $noticiaExtra->titulo }}"
                                    class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                            @else
                                <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                    class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                            @endif
                            <div class="flex flex-col items-start pt-4 lg:px-8">
                                <div class="mb-2 rounded-md bg-gray-100 px-2 py-1.5">
                                    <p class="text-sm font-semibold text-blue-600"> {{ $noticiaExtra->fechaSubida }}
                                    </p>
                                </div>
                                <p class="mb-2 text-sm font-bold sm:text-base"> {{ $noticiaExtra->titulo }} </p>
                            </div>
                        </a>
                    @endforeach
                    {{-- EVENTOS --}}
                    @foreach ($mostrarAparteEventos as $eventos)
                        <a href="#" class="flex flex-col pb-5 lg:mb-3 lg:flex-row lg:border-b lg:border-gray-300">
                            @if (isset($eventos['imagenes']) && !empty($eventos['imagenes'][0]))
                                <img src="{{ asset(Storage::url($eventos['imagenes'][0])) }}"
                                    alt="Imagen de {{ $eventos['nombreLugar'] }}"
                                    class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                            @else
                                <img src="{{ asset('img/logo_inner_negro.png') }}" alt="Imagen por defecto"
                                    class="inline-block h-60 w-full object-cover md:h-32 lg:h-32 lg:w-32" />
                            @endif
                            <div class="flex flex-col items-start pt-4 lg:px-8">
                                <div class="mb-2 rounded-md bg-gray-100 px-2 py-1.5">
                                    <p class="text-sm font-semibold text-blue-600"> {{ $eventos['fechashow'] }} </p>
                                </div>
                                <p class="mb-2 text-sm font-bold sm:text-base"> {{ $eventos['nombreLugar'] }} </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-AppLayout>
