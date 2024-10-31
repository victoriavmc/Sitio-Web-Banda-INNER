<x-AppLayout>
    @if (session('alerta'))
        <x-alerts :type="session('alerta')['type']">
            {{ session('alerta')['message'] }}
        </x-alerts>
    @endif
    <div class="min-h-screen">
        <div style="background-image: url({{ asset('/img/albums/musica/musica_fondo.webp') }})"
            class="bg-cover bg-center flex justify-center items-center h-96">
            <div class="absolute bg-black bg-opacity-30 h-96 w-full"></div>
            <h3
                class="relative text-7xl text-uppercas font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
                Preferencia de Notificaciones
            </h3>
        </div>

        <form action="{{ route('notificaciones.guardar') }}" method="POST">
            @csrf
            <div class="container my-10 lg:grid lg:grid-cols-2 p-8 rounded-lg bg-white shadow-lg mx-auto text-black">
                @foreach ($tipoNotificaciones as $notificacion)
                    <div class="grid grid-cols-[40%_60%] w-full gap-5">
                        {{-- <div class="w-full h-48 border">
                            <img src="" alt="">
                        </div> --}}

                        <div class="flex flex-col justify-between py-2 max-w-max">
                            <h1 class="text-2xl lg:text-2xl">{{ $notificacion->nombreNotificacion }}</h1>
                            <p class="text-sm lg:text-sm">{{ $notificacion->descripcionNotificacion }}</p>
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="activo[]" value="0">
                                <input type="checkbox" name="activo[]" id="{{ $notificacion->idtipoNotificación }}"
                                    value="{{ $notificacion->idtipoNotificación }}"
                                    @if (in_array($notificacion->idtipoNotificación, $preferenciasUsuario)) checked @endif>
                                <label class="text-lg" for="{{ $notificacion->idtipoNotificación }}">Activar</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-10 text-center ">
                <button type="submit"
                    class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                    Guardar Preferencias
                </button>
            </div>
        </form>
        <form action="{{ route('notificaciones.cancelar') }}" method="POST">
            @csrf
            <button type="submit" class="underline flex justify-center mb-4 italic text-base">
                Cancelar la suscripción a todos los correos electrónicos
            </button>
        </form>
    </div>
</x-AppLayout>
