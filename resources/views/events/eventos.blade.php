<x-AppLayout>
    @if (session('alertCrear'))
        <x-alerts :type="session('alertCrear')['type']">
            {{ session('alertCrear')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertModificar'))
        <x-alerts :type="session('alertModificar')['type']">
            {{ session('alertModificar')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertBorrar'))
        <x-alerts :type="session('alertBorrar')['type']">
            {{ session('alertBorrar')['message'] }}
        </x-alerts>
    @endif

    <div class="p-10 min-h-screen" style="background-color: #121212">
        <h3 class="text-8xl font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
            eventos
        </h3>
        <div class="relative flex mb-5">
            @auth
                @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                    <div class="flex gap-4 mt-4 absolute z-30">
                        <div class="flex items-center gap-10">
                            <a href="{{ route('crear-formulario') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Agregar</a>
                        </div>

                        <div class="flex items-center gap-10">
                            <a href="{{ route('lugares-cargados') }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Lugares cargados
                            </a>
                        </div>
                    </div>
                @endif
            @endauth

            <div class="w-full flex justify-center items-center z-0">
                <form action="{{ route('eventos') }}" method="GET"
                    class="w-full max-w-lg bg-gray-700 bg-opacity-70 rounded-lg shadow-xl">
                    <div
                        class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-blue-500 focus-within:!ring-2 ring-inset focus-within:!ring-blue-500 rounded-md">
                        <svg class="mr-2 h-5 w-5 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input
                            class="block w-full appearance-none bg-transparent text-base text-white placeholder:text-white focus:outline-none sm:text-sm sm:leading-6"
                            placeholder="Buscar publicacion..." name="search" aria-label="Search components"
                            type="text" aria-expanded="false" aria-autocomplete="list"
                            value="{{ request('search') }}" style="caret-color: rgb(107, 114, 128)">
                    </div>
                </form>
            </div>
        </div>

        {{-- EVENTOS --}}
        <div class="relative grid grid-cols-2 gap-5">
            @foreach ($shows as $show)
                <div class="relative items-start text-white p-3 rounded-xl border-2 border-red-500"
                    style="background-color:#323232; display: grid; grid-template-columns:30% 35% 35%">
                    <img class="h-full"
                        src="{{ $show->revisionImagenes && $show->revisionImagenes->imagenes
                            ? asset(Storage::url($show->revisionImagenes->imagenes->subidaImg))
                            : asset('img\logo_inner.png') }}"
                        alt="Imagen de {{ $show->nombreLugar }}" />

                    <div class="text-sm h-full flex flex-col justify-between ml-4 gap-2">
                        <p class="event-date text-lg">
                            {{ \Carbon\Carbon::parse($show->fechashow)->format('d F Y') }}</p>
                        <p class="text-lg">
                            {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}</p>
                        <p class="text-lg">
                        <p class="text-4xl font-medium hover:text-[#e60b0b] leading-none">
                            {{ $show->lugarlocal->nombreLugar }}
                        </p>
                        <p class="text-lg">{{ $show->lugarlocal->localidad }}</p>

                        {{ $show->lugarlocal->calle . ', ' . $show->lugarlocal->numero }}</p>
                        <p class="event-date text-lg">
                            {{ \Carbon\Carbon::parse($show->fechashow)->format('H:i') }}hs</p>
                        <div class="flex flex-col gap-3">
                            @if (now() < $show->fechashow)
                                <a href="https://www.instagram.com/direct/t/117977966259675/" target="_blank">
                                    <button class="boton-vermas">
                                        <p>Adquirir Entrada</p>
                                    </button>
                                </a>
                            @endif

                            {{-- <a href="{{ $show->linkCompraEntrada }}" target="_blank">
                                <button class="boton-vermas">
                                    <p>Ver en Google Maps</p>
                                </button>
                            </a> --}}
                        </div>
                    </div>
                    {{-- Google Maps --}}
                    <div id="mapa" class="z-0 w-full h-full"></div>
                    {{-- CRUD EVENTOS --}}
                    @auth
                        @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                            <div class="z-30 absolute flex gap-3 w-full p-2 justify-end">
                                <a href="{{ route('modificar-formulario', $show->idshow) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-1 rounded">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <form class="formEliminarUsuario" action="{{ route('eliminar-evento', $show->idshow) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold p-1 rounded">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.formEliminarUsuario').forEach(element => {
                element.addEventListener('submit', async function(event) {
                    event.preventDefault(); // Evita que se envíe el formulario inmediatamente
                    const result = await Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡No puedes revertir los cambios!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, borrarlo!"
                    });
                    if (result.isConfirmed) {
                        this.submit(); // Solo envía el formulario si se confirma
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const eventosContainer = document.getElementById('eventosContainer');

            searchInput.addEventListener('input', function() {
                const searchQuery = searchInput.value;

                if (searchQuery.length > 0) {
                    fetch(`/buscar-eventos?search=${searchQuery}`)
                        .then(response => response.json())
                        .then(data => {
                            // Limpiar el contenedor de eventos
                            eventosContainer.innerHTML = '';

                            // Renderizar los eventos filtrados
                            data.forEach(show => {
                                const eventHTML = `
                                <div class="relative items-start text-white p-3 rounded-xl border-2 border-red-500" style="background-color:#323232; display: grid; grid-template-columns:30% 35% 35%">
                                    <img class="h-full" src="${show.revision_imagenes ? '/storage/' + show.revision_imagenes.imagenes.subidaImg : '/img/logo_inner.png'}" alt="Imagen de ${show.nombreLugar}">
                                    <div class="text-sm h-full flex flex-col justify-between ml-4 gap-2">
                                        <p class="event-date text-lg">${new Date(show.fechashow).toLocaleDateString()}</p>
                                        <p class="text-lg">${show.ubicacionshow.provinciaLugar}, ${show.ubicacionshow.paisLugar}</p>
                                        <p class="text-4xl font-medium hover:text-[#e60b0b] leading-none">${show.lugarlocal.nombreLugar}</p>
                                        <p class="text-lg">${show.lugarlocal.localidad}</p>
                                        <p class="text-lg">${show.lugarlocal.calle}, ${show.lugarlocal.numero}</p>
                                        <p class="event-date text-lg">${new Date(show.fechashow).toLocaleTimeString()}hs</p>
                                    </div>
                                </div>
                            `;
                                eventosContainer.insertAdjacentHTML('beforeend', eventHTML);
                            });
                        })
                        .catch(error => console.error('Error fetching events:', error));
                }
            });
        });
    </script>
</x-AppLayout>
