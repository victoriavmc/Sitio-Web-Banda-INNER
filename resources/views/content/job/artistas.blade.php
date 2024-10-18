<x-AppLayout>
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 min-h-screen">
        <div class="grid grid-cols-1 md:grid-cols-4 sm:grid-cols-2 gap-20">
            {{--    SI TRAE DATO --}}
            @if (!$listaArtistas)
                <section class="bg-white flex">
                    <div
                        class="max-w-screen-xl 2xl:max-w-screen-2xl px-8 md:px-12 mx-auto py-12 lg:py-24 space-y-24 flex flex-col justify-center lg:h-screen">
                        <div class="grid grid-cols-1 gap-2 mt-12 list-none md:grid-cols-2 lg:mt-24 max-w-5xl mx-auto"
                            role="list">
                            <article
                                class="mx-auto  shadow-xl bg-cover bg-center min-h-150 relative border-8 border-black  transform duration-500 hover:-translate-y-12   group"
                                style="background-image:url('{{ asset('img/artistas/artistaA.jpg') }}');">
                                <div
                                    class="bg-black relative h-full group-hover:bg-opacity-0 min-h-150  flex flex-wrap flex-col pt-[30rem] hover:bg-opacity-75 transform duration-300">
                                    <div class=" bg-black p-8 h-full justify-end flex flex-col">
                                        <h1
                                            class="text-white mt-2 text-xl mb-5 transform  translate-y-20 uppercase group-hover:translate-y-0 duration-300 group-hover:text-orange-500">
                                            Santi </h1>
                                    </div>
                                </div>
                            </article>
                            <article
                                class="mx-auto shadow-xl bg-cover bg-center min-h-150 relative border-8 border-black transform duration-500 hover:-translate-y-12 group"
                                style="background-image:url('{{ asset('img/artistas/artistaC.jpg') }}');">
                                <div
                                    class="bg-black relative h-full group-hover:bg-opacity-0 min-h-150  flex flex-wrap flex-col pt-[30rem] hover:bg-opacity-75 transform duration-300">
                                    <div class="bg-black p-8 h-full justify-end flex flex-col">
                                        <h1
                                            class="text-white mt-2 text-xl mb-5 transform  translate-y-20 uppercase group-hover:translate-y-0 duration-300 group-hover:text-orange-500">
                                            VictoriaVMC </h1>
                                    </div>
                                </div>
                            </article>
                            <article
                                class="mx-auto  shadow-xl bg-cover bg-center min-h-150 relative border-8 border-black  transform duration-500 hover:-translate-y-12   group"
                                style="background-image:url('{{ asset('img/artistas/artistaB.jpeg') }}');">
                                <div
                                    class="bg-black relative h-full group-hover:bg-opacity-0 min-h-150  flex flex-wrap flex-col pt-[30rem] hover:bg-opacity-75 transform duration-300">
                                    <div class=" bg-black p-8 h-full justify-end flex flex-col">
                                        <h1
                                            class="text-white mt-2 text-xl mb-5 transform  translate-y-20 uppercase group-hover:translate-y-0 duration-300 group-hover:text-orange-500">
                                            Kevin </h1>
                                        <p
                                            class="opacity-0 text-white text-xl group-hover:opacity-80 transform duration-500 ">
                                            Power de Apoyo </p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
            @else
                @foreach ($listaArtistas as $artista)
                    {{-- Solo mostrar el botón de modificar imagen si el usuario tiene rol tipo 1 o 2 --}}
                    @if (Auth::check() && (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2))
                        <form action="{{ route('artistas.modificarImagen', $artista['id']) }}" method="POST"
                            enctype="multipart/form-data" class="mb-4">
                            @csrf
                            @method('PUT')
                            <label for="imagen-usuario" class="block text-sm font-medium text-black"> Cambiar
                                Imagen</label>
                            <div class="relative flex h-10 w-full min-w-[200px] max-w-[26rem]">
                                <input id="file-upload-{{ $artista['id'] }}" type="file" name="imagen"
                                    class="peer hidden" required
                                    onchange="actualizarNombreArchivo({{ $artista['id'] }})" />
                                <label for="file-upload-{{ $artista['id'] }}"
                                    class="absolute right-1 top-1 z-10 select-none rounded bg-red-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white transition-all hover:shadow-lg hover:bg-red-600 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] cursor-pointer">
                                    Subir Imagen
                                </label>
                                <div class="relative flex-1">
                                    <input type="text" id="nombre-archivo-{{ $artista['id'] }}" readonly
                                        class="relative peer h-full w-full rounded-[7px] border border-blue-gray-200 bg-transparent px-3 py-2.5 pr-20 font-sans text-sm font-normal text-black outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-red-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                        placeholder="Ningún archivo seleccionado" required />
                                    <label
                                        class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-red-500 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:!border-red-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                    </label>
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-4 bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                Confirmar Cambio
                            </button>
                        </form>
                        <a href="{{ $artista['link'] }}" class="flex gap-2" target="_blank">
                            <div class="rounded-lg shadow-md">
                                <h1 class="text-lg font-bold mb-2 uppercase">
                                    @foreach (str_split($artista['nombre']) as $letra)
                                        {{ $letra }}
                                    @endforeach

                                    @foreach (str_split($artista['apellido']) as $letra)
                                        {{ $letra }}
                                    @endforeach
                                </h1>
                                <h1>
                                    @foreach (str_split($artista['rol']) as $letra)
                                        <p>{{ $letra }}</p>
                                    @endforeach
                                </h1>
                            </div>

                            {{-- Verificar si el artista tiene imagen o usar la por defecto --}}
                            <img src="{{ $artista['imagen'] ? asset(Storage::url($artista['imagen'])) : asset('img/artistas/imagenBloqueado.jpg') }}"
                                alt="{{ $artista['nombre'] }}" class="w-full h-[690px] object-cover" />
                        </a>
                    @else
                        <a href="{{ $artista['link'] }}" class="flex gap-2" target="_blank">
                            <div class="rounded-lg shadow-md">
                                <h1 class="text-lg font-bold mb-2 uppercase">
                                    @foreach (str_split($artista['nombre']) as $letra)
                                        {{ $letra }}
                                    @endforeach

                                    @foreach (str_split($artista['apellido']) as $letra)
                                        {{ $letra }}
                                    @endforeach
                                </h1>
                                <h1>
                                    @foreach (str_split($artista['rol']) as $letra)
                                        <p>{{ $letra }}</p>
                                    @endforeach
                                </h1>
                            </div>

                            {{-- Verificar si el artista tiene imagen o usar la por defecto --}}
                            <img src="{{ $artista['imagen'] ? asset(Storage::url($artista['imagen'])) : asset('img/artistas/imagenBloqueado.jpg') }}"
                                alt="{{ $artista['nombre'] }}" class="w-full h-[690px] object-cover" />
                        </a>
                    @endif
                @endforeach
            @endif

        </div>
    </div>

    <script>
        function actualizarNombreArchivo(id) {
            const fileInput = document.getElementById(`file-upload-${id}`);
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'Ningún archivo seleccionado';
            document.getElementById(`nombre-archivo-${id}`).value = fileName;
        }
    </script>

</x-AppLayout>
