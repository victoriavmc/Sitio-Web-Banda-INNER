<x-AppLayout>
    <div class="bg-cover bg-center w-full p-10" style="background-image: url('{{ asset('img/noticias_fondo.png') }}')">
        <ul class="grid grid-cols-1 xl:grid-cols-3 gap-y-10 gap-x-6 items-start p-8">
            @auth
                @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                    <a href="{{ route('verFormularioNoticia') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Noticia</a>
                @endif
            @endauth
            @foreach ($recuperoNoticias as $noticia)
                <div class='bg-white opacity-95 rounded-lg p-4 flex'>
                    <div class="flex flex-col sm:flex-row xl:flex-col items-start">
                        <div class="order-1 sm:ml-6 xl:ml-0 flex flex-col">
                            <div class="flex justify-center">
                                <!-- Enlace en la imagen -->
                                <a href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                    @if ($noticia->imagenes && count($noticia->imagenes) > 0)
                                        <img src="{{ asset(Storage::url($noticia->imagenes[0])) }}"
                                            alt="ImagenPrincipal"
                                            class="mb-6 shadow-md rounded-lg bg-slate-50 max-w-96 max-h-96">
                                    @else
                                        <img src="{{ asset('img/logo_inner_negro.png') }}" alt="ImagenPrincipal"
                                            class="mb-6 shadow-md rounded-lg bg-slate-50">
                                    @endif
                                </a>
                            </div>
                            <div>
                                <p class="text-black text-sm mb-4">Publicado el: {{ $noticia->fechaSubida }}</p>

                                <!-- Enlace en el título -->
                                <a href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                    <h1 class="mb-1 text-slate-900 font-semibold">
                                        <span
                                            class="mb-1 block text-lg leading-6 text-red-500">{{ $noticia->titulo }}</span>
                                    </h1>
                                </a>
                                <div class="mt-3 prose prose-slate prose-sm text-base text-slate-600">
                                    <p>{{ $noticia->descripcion }}</p>
                                </div>
                                <!-- Botón "Leer Más" -->
                                <a class="group inline-flex items-center h-9 rounded-full text-sm font-semibold whitespace-nowrap px-3 focus:outline-none focus:ring-2 bg-red-500 text-white hover:bg-red-400 hover:text-white focus:ring-slate-700 mt-6"
                                    href="{{ route('noticiaUnica', $noticia->idcontenidos) }}">
                                    Leer Más
                                    <svg class="overflow-visible ml-3 text-slate-300 group-hover:text-slate-400"
                                        width="3" height="6" viewBox="0 0 3 6" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M0 0L3 3L0 6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
</x-AppLayout>
