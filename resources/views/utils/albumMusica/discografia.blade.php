<x-AppLayout>
    <div class="flex justify-center">
        <img class="h-[86.5vh] w-full object-cover" src="{{ asset('/img/albums/musica/musica_fondo.jpg') }}"
            alt="Fondo Musica">
    </div>
    <h1>DISCOGRAFÍA</h1>
    <!-- component -->
    <div class="flex justify-center items-center min-h-screen">
        <div class="max-w-[720px] mx-auto">
            <!-- Centering wrapper -->
            @foreach ($listaAlbum as $album)
                <div class="container">
                    <div class="card">
                        <figure class="card__thumb">
                            <img src="{{ asset(Storage::url($album['imagen'])) }}" alt="{{ $album['titulo'] }}"
                                alt="{{ $album['titulo'] }}">
                            <figcaption class="card__caption">
                                <h2 class="card__title">{{ $album['titulo'] }}</h2>
                                <p class="card__snippet">{{ $album['fecha'] }}</p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-AppLayout>
