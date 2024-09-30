<x-AppLayout>
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 h-[86.5vh]">
        <div class="grid grid-cols-1 md:grid-cols-4 sm:grid-cols-2 gap-20">
            @foreach ($listaArtistas as $artista)
                <a href="{{ $artista['link'] }}" class="flex" target="_blank">
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

                    <img src="{{ asset(Storage::url($artista['imagen'])) }}" alt="{{ $artista['nombre'] }}"
                        class="w-full h-[690px] object-cover" />
                </a>
            @endforeach
        </div>
    </div>
</x-AppLayout>
