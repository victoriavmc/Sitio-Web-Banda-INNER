<x-AppLayout>
    <div class="flex flex-col gap-7 justify-center bg-white min-h-[86vh] text-black">
        <h1 class="text-center text-4xl">Modificar Noticia</h1>
        <x-modificar-publicacion :action="$contenido->idcontenidos" :contenido="$contenido" :imagenes="$imagenes">
        </x-modificar-publicacion>
    </div>
</x-AppLayout>
