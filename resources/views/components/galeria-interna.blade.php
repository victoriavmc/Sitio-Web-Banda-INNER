<x-AppLayout>
    <div class='min-h-screen'>
        <div class="justify-center items-center">
            <div class="items-center">
                <h2 class="flex justify-center text-2xl font-bold text-gray-800 lg:text-3xl dark:text-white">Albúm:
                    {{ $titulo }}</h2>
            </div>
            <h2 class="justify-end text-end text-base mr-4">Fecha: {{ $fecha }}</h2>
        </div>
        @if (session('alertAlbum'))
            <x-alerts :type="session('alertAlbum')['type']">
                {{ session('alertAlbum')['message'] }}
            </x-alerts>
        @endif

        @if (session('success'))
            <x-alerts :type="session('success')['type']">
                {{ session('success')['message'] }} <!-- Cambiado aquí -->
            </x-alerts>
        @endif


        <div class="flex justify-center items-center">
            {{-- Agregar más videos o imágenes --}}
            <form action="{{ route('agregarVideoAlbum') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idAlbumEspecifico" value="{{ $idDato }}">
                <input type="hidden" name="tipo" value="{{ $tipo }}">

                <div class="rounded-md border border-red-500 bg-gray-50 p-4 shadow-md w-36">
                    <label for="upload" class="flex flex-col items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 fill-white stroke-red-500"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-bold text-center text-red-500">
                            {{ $tipo == 1 ? 'Agrega videos' : 'Agrega imágenes' }}
                        </span>
                    </label>
                    <input id="upload"
                        class="hidden mt-2 w-full border-none placeholder:text-base pl-0 text-black bg-black bg-opacity-0"
                        type="file" name="{{ $tipo == 1 ? 'videos[]' : 'imagenes[]' }}" multiple
                        accept="{{ $tipo == 1 ? 'video/*' : 'image/*' }}" required />
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 rounded">
                        Subir Contenido
                    </button>
                </div>
            </form>
        </div>

        {{-- Imagenes o Videos --}}
        <div class="p-5 sm:p-8">
            <div class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                {{-- ForEach para relacionar, imagen/video con id --}}
                @foreach ($medios as $idMuestra => $media)
                    <div class=''>
                        @if ($tipo == 2)
                            <img id="imagen" src="{{ asset(Storage::url($media['rutaEspecifica'])) }}"
                                alt="{{ $media['idEspecificoObjeto'] }}" class="imagen-modal cursor-pointer">
                        @else
                            <video width="320" height="240" controls>
                                <source src="{{ asset(Storage::url($media['rutaEspecifica'])) }}" type="video/mp4"
                                    alt="{{ $media['idEspecificoObjeto'] }}">
                                Tu navegador no soporta el elemento de video.
                            </video>
                        @endif
                        {{-- Condición para no mostrar el botón de eliminar para la primera imagen --}}
                        @if ($idMuestra !== array_key_first($medios))
                            {{-- Botón de borrar contenido --}}
                            <form action="{{ route('eliminar.objeto') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="tipo" value="{{ $tipo }}">
                                <input type="hidden" name="idAlbumEspecifico" value="{{ $idMuestra }}">
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
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
