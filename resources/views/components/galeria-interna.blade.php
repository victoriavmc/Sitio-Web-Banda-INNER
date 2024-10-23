<x-AppLayout>
    <div class='flex min-h-screen'>
        <div>
            <h1 class="flex text-center text-xl">Albúm: {{ $titulo }}</h1>
            <div class="flex text-end text-base">Fecha: {{ $fecha }}</div>
        </div>
        {{-- Imagenes o Videos --}}
        <div class="p-5 sm:p-8">
            <div class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                {{-- ForEach para relacionar, imagen/video con id --}}
                @foreach ($medias as $media)
                    <img
                        src="https://images.unsplash.com/photo-1472491235688-bdc81a63246e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHwwfHx8MTcyMTgyMjE3OXww&ixlib=rb-4.0.3&q=80&w=1080" />
                @endforeach

            </div>
        </div>
    </div>
</x-AppLayout>
