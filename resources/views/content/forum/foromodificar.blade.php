<x-AppLayout>
    <div class="flex flex-col gap-7 justify-center bg-white min-h-screen text-black">
        <h1 class="text-center text-4xl">Modificar Publicación del Foro</h1>
        <x-modificar-publicacion :action="$contenido->idcontenidos" :contenido="$contenido" :imagenes="$imagenes">
        </x-modificar-publicacion>
    </div>
</x-AppLayout>
