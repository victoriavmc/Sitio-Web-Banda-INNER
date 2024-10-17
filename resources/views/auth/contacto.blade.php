{{-- Vista de contacto --}}
<x-AppLayout>
    @if (session('alertBaneo'))
        {{-- Componente de alerta para el Baneo exitoso o fallido --}}
        <x-alerts :type="session('alertBaneo')['type']">
            {{ session('alertBaneo')['message'] }}
        </x-alerts>
    @endif

    <div class="min-h-screen bg-red-600 p-5 flex items-center">

        <div class=" container  mx-auto flex text-white items-center justify-center h-full ">
            <h1 class="text-7xl font-bold mb-4">USTED ESTÁ BANEADO</h1>
            <p class="text-4xl mb-4">NO PUEDE INGRESAR</p>
            <h1 class="text-3xl mb-4">
                @if ($fechaFinal === null)
                    Por tiempo indefinido.
                @else
                    Hasta la fecha: {{ $fechaFinal }}
                @endif
            </h1>

            <a href="{{ route('inicio') }}"
                class="bg-white hover:bg-gray-400 hover:text-white text-black
                text-2xl font-bold p-2 border-b-4 border-gray-700 hover:border-gray-500 rounded flex
                items-center">Regresar</a>
        </div>
    </div>


</x-AppLayout>
