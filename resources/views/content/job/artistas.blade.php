<x-AppLayout>
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 h-[86.5vh]">
        <div class="grid grid-cols-1 md:grid-cols-4 sm:grid-cols-2 gap-5">
            @foreach ($listaArtistas as $artista)
                <a href="{{ $artista['link'] }}" target="_blank">
                    <div class="rounded-lg shadow-md p-5">
                        <h1 class="text-lg font-bold mb-2">
                            @foreach (str_split($artista['nombre']) as $letra)
                                {{ $letra }}<br>
                            @endforeach
                            <br>
                            @foreach (str_split($artista['apellido']) as $letra)
                                {{ $letra }}<br>
                            @endforeach
                        </h1>
                        <br>
                        @foreach (str_split($artista['rol']) as $letra)
                            {{ $letra }}<br>
                        @endforeach
                    </div>



                    <img src="{{ asset(Storage::url($artista['imagen'])) }}" alt="{{ $artista['nombre'] }}"
                        class="w-full h-[690px] object-cover" />
                </a>
            @endforeach
        </div>
    </div>
</x-AppLayout>
