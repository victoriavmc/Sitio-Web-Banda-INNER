<x-AppLayout title="Contruyendo" :inicio=true>
    <div class="relative flex flex-col min-h-screen">
        <video class="absolute top-0 left-0 w-full h-full object-cover -z-10" autoplay muted loop>
            <source src="{{ asset('img/construccion_Fondo.webm') }}" type="video/mp4">
            Tu navegador no soporta el formato de video. <br>
            ¡La página está en construcción!
        </video>
    </div>

</x-AppLayout>
