<x-AppLayout>
    <div class="flex flex-wrap -mx-3 mb-5">
        <div class="w-full max-w-full px-3 mb-6  mx-auto">
            <div
                class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] border border-dashed border-stone-200 bg-white m-5">
                <!-- card body  -->
                <div class="flex-auto block py-8 px-9">
                    <div>
                        <div class="mb-9">
                            <h1 class="mb-2 text-[1.75rem] font-semibold text-dark text-center">Staff</h1>
                        </div>
                        @foreach ($listaStaff as $item)
                            @if (!in_array($item['rol'], ['Guitar', 'Vocalist and Guitar', 'Bass Guitar', 'Drummer']))
                                <div class="flex flex-wrap w-full">
                                    <div class="flex flex-col mr-5 text-center mb-11 lg:mr-16">
                                        <div class="inline-block mb-4 relative shrink-0 rounded-[.95rem]">
                                            @if ($item['imagen'] != null)
                                                <!-- Si existe la imagen entonces muestra aquí -->
                                                <img src="{{ asset(Storage::url($item['imagen'])) }}"
                                                    alt="Imagen Principal"
                                                    class="w-[230px] h-[230px] max-w-[230px] max-h-[230px] object-cover mb-8">
                                            @else
                                                <!-- Mostrar una imagen por defecto si no hay imagen -->
                                                <img src="{{ asset('img/logo_usuario.png') }}" alt="Imagen por defecto"
                                                    class="w-[230px] h-[230px] max-w-[230px] max-h-[230px] object-cover mb-8">
                                            @endif
                                        </div>

                                        <div class="text-center">
                                            <a href="javascript:void(0)"
                                                class="text-dark font-semibold hover:text-primary text-[1.25rem] transition-colors duration-200 ease-in-out">
                                                {{ $item['nombre'] . ' ' . $item['apellido'] }}
                                            </a>
                                            <span class="block font-medium text-muted">{{ $item['rol'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-AppLayout>
