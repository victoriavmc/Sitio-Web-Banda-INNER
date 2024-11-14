<x-AppLayout>
    <div class="flex flex-col gap-7 justify-center bg-white min-h-screen text-black">
        <h1 class="text-center text-4xl">Modificar Noticia</h1>
        <x-Modificar-publicacion :action="$contenido->idcontenidos" :contenido="$contenido" :imagenes="$imagenes">
        </x-Modificar-publicacion>
    </div>
</x-AppLayout>
