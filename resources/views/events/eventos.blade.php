<x-AppLayout>
    <div class="p-10" style="background-color: #1c1b1b">
        <h3 class="text-8xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
            eventos
        </h3>
        {{-- EVENTOS --}}
        <div class="grid grid-cols-2 gap-5">
            @foreach ($shows as $show)
                <div class="items-start text-white p-3 rounded-xl border-2 border-red-500"
                    style="background-color:#323232; display: grid; grid-template-columns:30% 35% 35%">
                    <img class="h-full"
                        src="{{ asset(Storage::url($show->revisionImagenes->imagenes->subidaImg)) }}"alt="Imagen de {{ $show->nombreLugar }}" />
                    <div class="text-sm h-full flex flex-col justify-between ml-4 gap-2">
                        <p class="event-date text-lg">
                            {{ \Carbon\Carbon::parse($show->fechashow)->format('d F Y') }}</p>
                        <p class="text-4xl font-medium hover:text-[#e60b0b] leading-none">
                            {{ $show->lugarlocal->nombreLugar }}
                        </p>
                        <p class="text-lg">{{ $show->lugarlocal->localidad }}</p>
                        <p class="text-lg">
                            {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}</p>
                        <p class="text-lg">
                            {{ $show->lugarlocal->calle . ', ' . $show->lugarlocal->numero }}</p>
                        <p class="event-date text-lg">
                            {{ \Carbon\Carbon::parse($show->fechashow)->format('H:i') }}hs</p>
                        <div class="flex flex-col gap-3">
                            @if (now() < $show->fechashow)
                                <a href="{{ $show->linkCompraEntrada }}" target="_blank">
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
                    <div id="mapa" class="w-full h-full"></div>
                </div>
            @endforeach
        </div>
    </div>
</x-AppLayout>
