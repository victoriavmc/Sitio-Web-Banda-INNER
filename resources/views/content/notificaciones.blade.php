<x-AppLayout>
    <div class="min-h-screen">
        <div style="background-image: url({{ asset('/img/albums/musica/musica_fondo.webp') }})"
            class="bg-cover bg-center flex justify-center items-center h-96">
            <div class="absolute bg-black bg-opacity-30 h-96 w-full"></div>
            <h3
                class="relative text-7xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                Preferencia de Notificaciones
            </h3>
        </div>

        <form action="" method="POST">
            <div class="container my-10 lg:grid lg:grid-cols-2 p-8 rounded-lg bg-white shadow-lg mx-auto text-black">
                @foreach ($tipoNotificaciones as $notificaciones)
                    <div class="grid grid-cols-[40%_60%] w-full gap-5">
                        <div class="w-full h-48 border">
                            <img src="" alt="">
                        </div>

                        <div class="flex flex-col justify-between py-2 max-w-max">
                            <h1 class="text-2xl lg:text-2xl">{{ $notificaciones->nombreNotificacion }}</h1>
                            <p class="text-sm lg:text-sm">{{ $notificaciones->descripcionNotificacion }}</p>
                            <div class="flex items-center gap-2">
                                {{-- Qu el color del check sea rojo --}}
                                <input type="hidden" name="activo[]" value="0">
                                <input type="checkbox" name="activo[]" id="{{ $notificaciones->idtipoNotificación }}">
                                <label class="text-lg" for="{{ $notificaciones->idtipoNotificación }}">Activar</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-10 text-center ">
                <button type="submit"
                    class="mx-auto border border-black border- bg-white  py-5 px-8 text-xl hover:bg-red-500 hover:shadow-xl hover:text-white hover:rounded-md transition-all duration-300">
                    Guardar Preferencias
                </button>
            </div>
        </form>
    </div>
</x-AppLayout>
