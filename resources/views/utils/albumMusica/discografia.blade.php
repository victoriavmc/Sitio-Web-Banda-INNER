<x-AppLayout>
    @if (session('alertAlbum'))
        {{-- Componente de alerta para el album --}}
        <x-alerts :type="session('alertAlbum')['type']">
            {{ session('alertAlbum')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertCancion'))
        {{-- Componente de alerta para la cancion --}}
        <x-alerts :type="session('alertCancion')['type']">
            {{ session('alertCancion')['message'] }}
        </x-alerts>
    @endif
    <div class=" min-h-screen">


        <div style="background-image: url({{ asset('/img/albums/musica/musica_fondo.jpg') }})"
            class="bg-cover bg-center flex justify-center items-center h-96">
            <div class="absolute bg-black bg-opacity-30 h-96 w-full"></div>
            <h3
                class="relative text-7xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                Discografia
            </h3>
        </div>
        <div class="container mx-auto max-w-4xl mt-10  pb-3">
            <!-- Centering wrapper -->
            <h2 class="text-4xl font-bold text-center mb-5">ALBUMS</h2>
            @auth
                @if (Auth::user()->rol->idrol === 1)
                    <a href="{{ route('formulario-crear-album') }}" type="submit"
                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                        Crear Album
                    </a>
                @endif
            @endauth

            @if (!$listaAlbum)
                <p class="text-center mt-5 text-2xl text-gray-500">No hay albums disponibles</p>
            @else
                @foreach ($listaAlbum as $album)
                    <div class="flex w-full justify-center gap-12 border-b border-gray-300 pb-3">
                        <div class="border w-[300px] max-h-72 border-gray-300 flex">
                            @auth
                                @if (Auth::user()->rol->idrol === 1)
                                    <div class="flex gap-3 absolute pl-3 pt-3">
                                        <form action="{{ route('eliminar-album', $album['id']) }}" id="btnEliminarAlbum"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                                <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </form>
                                        <a class="bg-blue-500 hover:bg-blue-400 text-white text-xs font-bold p-1 border-b-4 border-blue-700 hover:border-blue-500 rounded w-max"
                                            href="{{ route('formulario-modificar-album', $album['id']) }}">
                                            <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            @endauth
                            {{-- @dd($album['imagen']) --}}
                            @if ($album['imagen'] == 'imagen_por_defecto.jpg')
                                <img src="{{ asset('img/logo_inner_negro.png') }}" alt="{{ $album['titulo'] }}">
                            @else
                                <img src="{{ asset(Storage::url($album['imagen'])) }}" alt="{{ $album['titulo'] }}">
                            @endif
                        </div>

                        <div class=" flex justify-start" id="songs-{{ $album['titulo'] }}">
                            <div class="flex flex-col h-full">
                                <div class="flex gap-2 items-center">
                                    <h2 class="text-3xl font-bold text-center">{{ $album['titulo'] }}</h2>
                                    <p class="text-center">({{ $album['fecha'] }})</p>
                                </div>
                                <a href="{{ route('formulario-crear-cancion', $album['id']) }}" type="submit"
                                    class="bg-red-500 mb-4 hover:bg-red-400 mt-4 text-white text-xs font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                    Agregar Canción
                                </a>

                                @if (!$album['canciones'])
                                    <p class="text-center mt-5 text-2xl text-gray-500">No hay canciones disponibles</p>
                                @else
                                    {{-- EN CASO QUE EXISTE LAS CANCIONES --}}
                                    @foreach ($album['canciones'] as $titulos)
                                        <div class="relative">
                                            <nav class="flex min-w-[240px] flex-col gap-1 py-1.5">
                                                <div role="button"
                                                    class="text-black flex w-full justify-between items-center gap-10">
                                                    <div class="text-black flex w-full items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                            height="1em" viewBox="0 0 24 24">
                                                            <g fill="none" stroke="black" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M8 18V5.716a2 2 0 0 1 1.696-1.977l9-1.385A2 2 0 0 1 21 4.331V16" />
                                                                <path d="m8 9l13-2" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M8 18a3 3 0 1 1-6 0c0-1.657 1.343-2 3-2s3 .343 3 2m13-2a3 3 0 1 1-6 0c0-1.657 1.343-2 3-2s3 .343 3 2" />
                                                            </g>
                                                        </svg>
                                                        <strong>{{ $titulos['titulo'] }}</strong>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                            height="1em" viewBox="0 0 16 16">
                                                            <path fill="black"
                                                                d="m3.878.282l.348 1.071A2.2 2.2 0 0 0 5.624 2.75l1.072.348l.022.006a.423.423 0 0 1 0 .798l-1.072.348a2.2 2.2 0 0 0-1.399 1.397L3.9 6.717a.423.423 0 0 1-.798 0l-.348-1.07a2.2 2.2 0 0 0-1.399-1.403L.282 3.896a.423.423 0 0 1 0-.798l1.072-.348a2.2 2.2 0 0 0 1.377-1.397L3.08.283a.423.423 0 0 1 .799 0m4.905 7.931l-.766-.248a1.58 1.58 0 0 1-.998-.999l-.25-.764a.302.302 0 0 0-.57 0l-.248.764a1.58 1.58 0 0 1-.984.999l-.765.248a.302.302 0 0 0 0 .57l.765.249a1.58 1.58 0 0 1 1 1.002l.248.764a.302.302 0 0 0 .57 0l.249-.764a1.58 1.58 0 0 1 .999-.999l.765-.248a.302.302 0 0 0 0-.57zM5.276 11.15q.04.1.092.19l-.323.323a.65.65 0 0 0-.156.253L4.29 13.71l1.794-.598a.65.65 0 0 0 .253-.156l6.294-6.294l.03-.03l1.071-1.07a.914.914 0 1 0-1.293-1.294L9.322 7.385a1.5 1.5 0 0 0-.233-.103l-.76-.25l-.049-.019l3.453-3.453a1.914 1.914 0 0 1 2.707 2.708L13.707 7l.263.263a1.75 1.75 0 0 1 0 2.474l-1.116 1.117a.5.5 0 1 1-.707-.708l1.116-1.116a.75.75 0 0 0 0-1.06L13 7.707l-5.955 5.955a1.65 1.65 0 0 1-.644.398l-2.743.914a.5.5 0 0 1-.632-.632l.914-2.743c.08-.243.217-.463.398-.644l.657-.657l.02.05z" />
                                                        </svg>
                                                    </div>

                                                    @auth
                                                        @if (Auth::user()->rol->idrol === 1)
                                                            <div class="flex gap-2">
                                                                <a class="bg-blue-500 hover:bg-blue-400 text-white text-xs font-bold p-1 border-b-4 border-blue-700 hover:border-blue-500 rounded w-max"
                                                                    href="{{ route('formulario-modificar-cancion', $titulos['id']) }}">
                                                                    <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                    </svg>
                                                                </a>
                                                                <form
                                                                    action="{{ route('eliminar-cancion', $titulos['id']) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="bg-red-500 hover:bg-red-400 text-white text-xs font-bold p-1 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" fill="none"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </nav>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-AppLayout>
