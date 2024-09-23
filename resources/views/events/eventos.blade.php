<x-AppLayout>
    <div class="bg-gray-300 contenedor p-10">
        <div class='grid grid-cols-2 gap-3'>
            {{-- EVENTOS --}}
            @foreach ($shows as $show)
                <div class="flex gap-5 items-start bg-white p-3 rounded-xl">
                    <img src="{{ asset(Storage::url($show->revisionImagenes->imagenes->subidaImg)) }}"alt="Imagen de {{ $show->nombreLugar }}"
                        class="w-60" />
                    <div class="text-sm w-full flex flex-col gap-2">
                        <p class="text-black text-lg">{{ $show->fechashow }}</p>
                        <a href="" class="text-black text-4xl font-medium hover:text-indigo-600 leading-none">
                            {{ $show->lugarlocal->nombreLugar }}
                        </a>
                        <p class="text-black text-lg">{{ $show->lugarlocal->localidad }}</p>
                        <p class="text-black text-lg">
                            {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}</p>
                        <p class="text-black text-lg">
                            {{ $show->lugarlocal->calle . ', ' . $show->lugarlocal->numero }}</p>
                    </div>
                    <div class="h-full flex items-end">
                        <a class="" href="">Adquirir Entrada</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-AppLayout>
