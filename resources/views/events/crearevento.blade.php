<x-AppLayout>
    <div class="flex flex-col gap-7 justify-center bg-white min-h-[86vh] text-black">
        <h1 class="text-center text-4xl">Crear Evento</h1>

        <div class="flex justify-center">
            <form action="{{ route('crear-evento') }}" method="POST" enctype="multipart/form-data"
                class="border-2 border-black p-4 rounded-xl">
                @csrf

                <div class="flex flex-col gap-4">
                    <!-- Lugar -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="lugar">Lugar</label>
                        <input id="lugar" class="rounded-xl" type="text" name="lugar"
                            value="{{ old('lugar') }}">
                        @error('lugar')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Fecha y hora -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="fecha">Fecha y hora</label>
                        <input id="fecha" class="rounded-xl" type="datetime-local" name="fecha"
                            value="{{ old('fecha') }}">
                        @error('fecha')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Provincia -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="provincia">Provincia</label>
                        <select id="provincia" class="rounded-xl p-2.5" name="provincia">
                            @foreach ($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->idubicacionShow }}"
                                    {{ old('provincia') }}>
                                    {{ $ubicacion->provinciaLugar . ', ' . $ubicacion->paisLugar }}
                                </option>
                            @endforeach
                        </select>
                        @error('provincia')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Calle -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="calle">Calle</label>
                        <input id="calle" name="calle" type="text"
                            value="{{ old('calle') }}" class="rounded-xl">
                        @error('calle')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Numero -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="numero">Número</label>
                        <input id="numero" name="numero" type="number"
                            value="{{ old('numero') }}" class="rounded-xl">
                        @error('numero')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Imagen de Portada -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="imagen">Imagen de Portada</label>
                        <input class="rounded-xl" type="file" name="imagen" multiple>
                        @error('imagen')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botón Actualizar -->
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-AppLayout>
