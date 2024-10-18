<x-AppLayout>
    {{-- Comprueba si hay mensajes de alerta en la sesión para el registro --}}
    @if (session('alertRegistro'))
        {{-- Componente de alerta para el registro exitoso o fallido --}}
        <x-alerts :type="session('alertRegistro')['type']">
            {{ session('alertRegistro')['message'] }}
        </x-alerts>
    @endif

    <div class="wrapper bg-center justify-center min-h-screen"
        style="background-image: url('{{ asset('img/logeo/reactivar_fondo.jpg') }}');">
        <div class="inner p-2 bg-white bg-opacity-20 backdrop-blur-lg rounded-3xl shadow-2xl transform z-10 flex">
            <!-- Columna de la imagen -->
            <div class="image-column flex-1 flex justify-center items-center p-4">
                <img class="pequeño w-72 rounded-md" src="{{ asset(Storage::url($fotoDePerfil)) }}" alt="AgusFacha">
            </div>

            <!-- Columna del formulario -->
            <div class="form-column flex-1 flex justify-center items-center">
                <form id="form-reactivar" class="font-urbanist z-10 w-full max-w-md" method="POST"
                    action="{{ route('solicitar-pin') }}">
                    @csrf
                    <h3 class="font-bold deepshadow mb-4">Reactivar Cuenta</h3>
                    <!-- Campo oculto para identificar el origen -->
                    <input type="hidden" name="source" value="reactivar">
                    <!-- email -->
                    <div class="form-wrapper mb-4 font-urbanist">
                        @error('email')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="email" name="email" autocomplete="new-password" placeholder="Email"
                            class="form-control pl-0 text-black bg-black bg-opacity-0" value="{{ old('email') }}">
                        <i class="zmdi zmdi-email"></i>
                    </div>

                    <!-- Boton de registro -->
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Reactivar</button>
                </form>
            </div>
        </div>
    </div>
</x-AppLayout>
