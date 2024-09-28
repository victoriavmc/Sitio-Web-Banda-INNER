<x-AppLayout>
    <div class="container bg-white text-black">
        <h1>Modificar Noticia</h1>
        <x-modificar-publicacion :action="$contenido->idcontenidos" :contenido="$contenido" :imagenes="$imagenes">
        </x-modificar-publicacion>
    </div>
</x-AppLayout>
