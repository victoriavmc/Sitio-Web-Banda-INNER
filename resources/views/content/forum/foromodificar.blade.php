<x-AppLayout>
    <div class="container bg-white text-black">
        <h1>Modificar Publicación del Foro</h1>
        <x-modificar-publicacion :action="$contenido->idcontenidos" :contenido="$contenido" :imagenes="$imagenes"></x-modificar-publicacion>
    </div>
</x-AppLayout>
