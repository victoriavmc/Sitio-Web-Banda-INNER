<x-AppLayout>
    <div class=" contenedor p-10" style="background-color: #1c1b1b">
        <div class='grid grid-cols-2 gap-3'>
            {{-- EVENTOS --}}
            @foreach ($shows as $show)
                <div class="flex gap-5 items-start text-white p-3 rounded-xl border-2 border-red-500"
                    style="background-color:#323232">
                    <img src="{{ asset(Storage::url($show->revisionImagenes->imagenes->subidaImg)) }}"alt="Imagen de {{ $show->nombreLugar }}"
                        class="w-60" />
                    <div class="text-sm w-full flex flex-col gap-2">
                        <p class="event-date text-xl">
                            {{ \Carbon\Carbon::parse($show->fechashow)->format('d F Y') }}</p>

                        <a href="{{ route('evento', $show->idshow) }}" target="_blank"
                            class="text-4xl font-medium hover:text-[#e60b0b] leading-none">
                            {{ $show->lugarlocal->nombreLugar }}
                        </a>
                        <p class="text-lg">{{ $show->lugarlocal->localidad }}</p>
                        <p class="text-lg">
                            {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}</p>
                        <p class="text-lg">
                            {{ $show->lugarlocal->calle . ', ' . $show->lugarlocal->numero }}</p>
                        <p class="event-date text-xl">
                            {{ \Carbon\Carbon::parse($show->fechashow)->format('H:i') }}hs</p>
                    </div>
                    <div class="h-full w-1/2 flex justify-end items-end gap-4">
                        <a href="{{ route('evento', $show->idshow) }}">
                            <button class="boton-vermas">
                                <p>Ver mas</p>
                            </button>
                        </a>
                        <a href="{{ $show->linkCompraEntrada }}" target="_blank">
                            <button class="boton-vermas">
                                <p>Adquirir Entrada</p>
                            </button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-AppLayout>
