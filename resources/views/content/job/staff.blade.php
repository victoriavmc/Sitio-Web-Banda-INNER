<x-AppLayout>
    <div class="flex items-center justify-center min-h-screen bg-white">
        <div class="flex flex-col mt-8">
            <div class="container max-w-7xl px-4">
                <div class="flex w-full flex-wrap justify-center text-center">
                    <h1 class="text-gray-900 text-5xl font-bold mb-2">
                        Miembros del Staff
                    </h1>
                </div>
                <!-- NO trae datos de la base de datos -->
                @if (!$listaStaff)
                    <section class="bg-white">
                        <div
                            class="max-w-screen-xl 2xl:max-w-screen-2xl px-8 md:px-12 mx-auto py-12 mt-0 md:mt-10 space-y-24 flex flex-col justify-center lg:h-screen">
                            <div class="grid grid-cols-1 gap-2 mt-12 list-none md:grid-cols-2 max-w-5xl mx-auto"
                                role="list">
                                <article
                                    class="mx-auto shadow-xl bg-cover bg-center min-h-150 relative border-8 border-black transform duration-500 hover:-translate-y-12 group"
                                    style="background-image:url('{{ asset('img/artistas/victoriavmc.webp') }}');">
                                    <div
                                        class="bg-black relative h-full group-hover:bg-opacity-0 min-h-150 flex flex-wrap flex-col pt-[30rem] hover:bg-opacity-75 transform duration-300">
                                        <div class="bg-black p-8 h-full justify-end flex flex-col">
                                            <h1
                                                class="text-white mt-2 text-xl mb-5 transform  translate-y-20 uppercase group-hover:translate-y-0 duration-300 group-hover:text-orange-500">
                                                VictoriaVMC </h1>
                                            <p
                                                class="opacity-0 text-white text-xl group-hover:opacity-80 transform duration-500 ">
                                                Fan de la Pepsi y el Csgo. </p>
                                        </div>
                                    </div>
                                </article>
                                <article
                                    class="mx-auto  shadow-xl mt-20 md:mt-0 bg-cover bg-center min-h-150 relative border-8 border-black  transform duration-500 hover:-translate-y-12   group"
                                    style="background-image:url('{{ asset('img/artistas/santi.webp') }}');">
                                    <div
                                        class="bg-black relative h-full group-hover:bg-opacity-0 min-h-150  flex flex-wrap flex-col pt-[30rem] hover:bg-opacity-75 transform duration-300">
                                        <div class=" bg-black p-8 h-full justify-end flex flex-col">
                                            <h1
                                                class="text-white mt-2 text-xl mb-5 transform  translate-y-20 uppercase group-hover:translate-y-0 duration-300 group-hover:text-orange-500">
                                                Santi </h1>
                                            <p
                                                class="opacity-0 text-white text-xl group-hover:opacity-80 transform duration-500 ">
                                                Fan de los juegos de Rol. </p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section>
                @else
                    <!-- SI trae datos de la base de datos -->
                    <!-- Team Members -->
                    <div class="grid grid-cols-3 gap-4 justify-items-center">
                        @foreach ($listaStaff as $item)
                            @if (!in_array($item['rol'], ['Guitar', 'Vocalist and Guitar', 'Bass Guitar', 'Drummer']))
                                <div class="w-full md:w-4/5 mb-6 px-6 sm:px-6 lg:px-4">
                                    <div class="flex flex-col">
                                        <!-- Avatar -->
                                        <a href="{{ route('perfil-ajeno', $item['id']) }}" class="flex justify-center">
                                            @if ($item['imagen'] != null)
                                                <!-- Si existe la imagen entonces muestra aquí -->
                                                <img src="{{ asset(Storage::url($item['imagen'])) }}"
                                                    alt="Imagen Principal"
                                                    class="rounded-2xl drop-shadow-md hover:drop-shadow-xl w-56 transition-all duration-200 delay-100">
                                            @else
                                                <!-- Mostrar una imagen por defecto si no hay imagen -->
                                                <img src="{{ asset('img/logo_usuario.webp') }}" alt="Imagen por defecto"
                                                    class="rounded-2xl drop-shadow-md hover:drop-shadow-xl w-56 transition-all duration-200 delay-100">
                                            @endif
                                        </a>

                                        <!-- Details -->
                                        <div class="text-center mt-6">
                                            <!-- Name -->
                                            <a href="{{ route('perfil-ajeno', $item['id']) }}">
                                                <h1 class="text-gray-900 text-xl font-bold mb-1">
                                                    {{ $item['nombre'] . ' ' . $item['apellido'] }}
                                                </h1>

                                                <!-- Title -->
                                                <div class="text-gray-700 font-light mb-2">
                                                    {{ $item['rol'] }}
                                                </div>
                                            </a>
                                            <!-- Social Icons -->
                                            <div
                                                class="flex items-center justify-center opacity-50 hover:opacity-100 transition-opacity duration-300">
                                                <!-- Instagram -->
                                                {{-- @dd($item['link']) --}}
                                                @if ($item['link'] != 'Sin enlace')
                                                    <a href="{{ $item['link'] }}" target="_blank"
                                                        class="flex rounded-full hover:bg-orange-50 h-10 w-10">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M8.64 4.737A7.97 7.97 0 0 1 12 4a7.997 7.997 0 0 1 6.933 4.006h-.738c-.65 0-1.177.25-1.177.9 0 .33 0 2.04-2.026 2.008-1.972 0-1.972-1.732-1.972-2.008 0-1.429-.787-1.65-1.752-1.923-.374-.105-.774-.218-1.166-.411-1.004-.497-1.347-1.183-1.461-1.835ZM6 4a10.06 10.06 0 0 0-2.812 3.27A9.956 9.956 0 0 0 2 12c0 5.289 4.106 9.619 9.304 9.976l.054.004a10.12 10.12 0 0 0 1.155.007h.002a10.024 10.024 0 0 0 1.5-.19 9.925 9.925 0 0 0 2.259-.754 10.041 10.041 0 0 0 4.987-5.263A9.917 9.917 0 0 0 22 12a10.025 10.025 0 0 0-.315-2.5A10.001 10.001 0 0 0 12 2a9.964 9.964 0 0 0-6 2Zm13.372 11.113a2.575 2.575 0 0 0-.75-.112h-.217A3.405 3.405 0 0 0 15 18.405v1.014a8.027 8.027 0 0 0 4.372-4.307ZM12.114 20H12A8 8 0 0 1 5.1 7.95c.95.541 1.421 1.537 1.835 2.415.209.441.403.853.637 1.162.54.712 1.063 1.019 1.591 1.328.52.305 1.047.613 1.6 1.316 1.44 1.825 1.419 4.366 1.35 5.828Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <p class="text-black">No cuenta con redes sociales</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-AppLayout>
