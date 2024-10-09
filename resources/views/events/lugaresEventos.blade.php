<x-AppLayout>
    <div class="min-h-screen p-10">
        <div class="mb-10">
            <h1 class="text-center text-4xl">Lugares cargados</h1>
        </div>

        <div class="text-center flex flex-col gap-5">
            @foreach ($lugares as $lugar)
                <p class="text-xl font-semibold">
                    {{ $lugar->nombreLugar . ', ' . $lugar->localidad . ', ' . $lugar->calle . ' ' . $lugar->numero }}
                </p>
            @endforeach
        </div>
    </div>
</x-AppLayout>
