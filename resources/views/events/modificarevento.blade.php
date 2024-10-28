<x-AppLayout>
    <div class="flex flex-col gap-7 justify-center bg-white min-h-screen text-black p-4">
        <h1 class="text-center text-4xl">Modificar Evento</h1>

        <div class="flex justify-center">
            <form action="{{ route('modificar-evento', $show->idshow) }}" method="POST" enctype="multipart/form-data"
                class="border-2 border-black p-4 rounded-xl">
                @csrf
                @method('PUT') <!-- Método PUT para actualizar -->

                <div class="flex flex-col gap-4">
                    <!-- Lugar -->
                    <div class="flex flex-col gap-1">
                        <label id="label-lugar" class="font-semibold text-lg" for="select-lugar">Lugares</label>
                        <select id="select-lugar" class="rounded-xl p-2.5" name="lugar">
                            <option value="" disabled>Lugares cargados</option>
                            @foreach ($lugares as $lugar)
                                <option value="{{ $lugar->idlugarLocal }}"
                                    {{ $lugar->idlugarLocal == $show->lugarLocal_idlugarLocal ? 'selected' : '' }}>
                                    {{ $lugar->nombreLugar . ', ' . $lugar->localidad . ', ' . $lugar->calle . ' ' . $lugar->numero }}
                                </option>
                            @endforeach
                        </select>
                        @error('lugar')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botón para agregar un nuevo lugar -->
                    <button type="button" id="crear-nuevo-lugar-btn"
                        class="text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        Crear un nuevo lugar
                    </button>

                    <!-- Campos para ingresar un nuevo lugar -->
                    <div id="nuevos-lugar-container" class="hidden">
                        <!-- Lugar -->
                        <div class="flex flex-col gap-1 mb-2">
                            <label class="font-semibold text-lg" for="lugar-nuevo">Lugar</label>
                            <input id="lugar-nuevo" name="nuevo_lugar" type="text"
                                value="{{ old('nuevo_lugar', $show->lugarlocal->nombreLugar) }}" class="rounded-xl"
                                disabled>
                            @error('nuevo_lugar')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Calle -->
                        <div class="flex flex-col gap-1 mb-2">
                            <label class="font-semibold text-lg" for="calle">Calle</label>
                            <input id="calle" name="calle" type="text"
                                value="{{ old('calle', $show->lugarlocal->calle) }}" class="rounded-xl" disabled>
                            @error('calle')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Numero -->
                        <div class="flex flex-col gap-1 mb-2">
                            <label class="font-semibold text-lg" for="numero">Número</label>
                            <input id="numero" name="numero" type="number"
                                value="{{ old('numero', $show->lugarlocal->numero) }}" class="rounded-xl" disabled>
                            @error('numero')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Localidad -->
                        <div class="flex flex-col gap-1">
                            <label class="font-semibold text-lg" for="localidad">Localidad</label>
                            <input id="localidad" name="localidad" type="text"
                                value="{{ old('localidad', $show->lugarlocal->localidad) }}" class="rounded-xl">
                            @error('localidad')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Fecha y hora -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="fecha">Fecha y hora</label>
                        <input id="fecha" class="rounded-xl" type="datetime-local" name="fecha"
                            value="{{ old('fecha', $show->fechashow) }}">
                        @error('fecha')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Provincia -->
                    <div class="flex flex-col gap-1">
                        <label id="label-ubicacion" class="font-semibold text-lg" for="select-ubicacion">Ubicacion
                            (Provincia y Pais)</label>
                        <select id="select-ubicacion" class="rounded-xl p-2.5" name="provincia">
                            <option value="" disabled>Provincias cargadas</option>
                            @foreach ($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->idubicacionShow }}"
                                    {{ old('provincia', $show->ubicacionShow) == $ubicacion->idubicacionShow ? 'selected' : '' }}>
                                    {{ $ubicacion->provinciaLugar . ', ' . $ubicacion->paisLugar }}
                                </option>
                            @endforeach
                        </select>
                        @error('provincia')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botón para agregar una nueva ubicacion -->
                    <button type="button" id="crear-nueva-ubicacion-btn"
                        class="text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        Crear una nueva ubicacion
                    </button>

                    <!-- Campos para ingresar un nuevo Pais y Provincia -->
                    <div id="nueva-ubicacion-container" class="hidden">
                        <!-- Provincia -->
                        <div class="flex flex-col gap-1 mb-2">
                            <label class="font-semibold text-lg" for="provincia-nuevo">Provincia</label>
                            <input id="provincia" name="nuevo_provincia" type="text"
                                value="{{ old('nuevo_provincia', $ubicacion->provinciaLugar) }}" class="rounded-xl"
                                disabled>
                            @error('nuevo_provincia')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Pais -->
                        <div class="flex flex-col gap-1 mb-2">
                            <label class="font-semibold text-lg" for="pais">Pais</label>
                            <input id="pais" name="pais" type="text"
                                value="{{ old('pais', $ubicacion->paisLugar) }}" class="rounded-xl" disabled>
                            @error('pais')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Link de compra -->
                    <div class="flex flex-col gap-1 mb-2">
                        <label class="font-semibold text-lg" for="linkCompra">Link de compra</label>
                        <input id="linkCompra" name="linkCompra" type="text"
                            value="{{ old('linkCompra', $show->linkCompraEntrada) }}" class="rounded-xl">
                        @error('linkCompra')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Imagen de Portada -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-lg" for="imagen">Imagen de Portada</label>
                        <input class="rounded-xl" type="file" name="imagen" accept="image/*" multiple>
                        @error('imagen')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botón Actualizar -->
                    <button type="submit"
                        class="text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('crear-nuevo-lugar-btn').addEventListener('click', function() {
            const nuevosLugarContainer = document.getElementById('nuevos-lugar-container');
            const selectLugar = document.getElementById('select-lugar');
            const labelLugar = document.getElementById('label-lugar');
            const lugarInput = document.getElementById('lugar-nuevo');
            const calleInput = document.getElementById('calle');
            const numeroInput = document.getElementById('numero');

            // Alternar la visibilidad de los campos
            if (nuevosLugarContainer.classList.contains('hidden')) {
                // Mostrar los campos de crear un nuevo lugar
                nuevosLugarContainer.classList.remove('hidden');
                // Ocultar el select de lugares
                selectLugar.classList.add('hidden');
                labelLugar.classList.add('hidden');

                // Habilitar los inputs
                lugarInput.disabled = false;
                calleInput.disabled = false;
                numeroInput.disabled = false;

                // Cambiar el texto del botón
                this.innerText = 'Elegir lugar existente';
            } else {
                // Ocultar los campos de crear un nuevo lugar
                nuevosLugarContainer.classList.add('hidden');
                // Mostrar el select de lugares
                selectLugar.classList.remove('hidden');
                labelLugar.classList.remove('hidden');

                // Deshabilitar los inputs
                lugarInput.disabled = true;
                calleInput.disabled = true;
                numeroInput.disabled = true;

                // Cambiar el texto del botón
                this.innerText = 'Crear un nuevo lugar';
            }
        });

        document.getElementById('crear-nueva-ubicacion-btn').addEventListener('click', function() {
            const nuevaUbicacionContainer = document.getElementById('nueva-ubicacion-container');
            const labelUbicacion = document.getElementById('label-ubicacion');
            const selectUbicacion = document.getElementById('select-ubicacion');
            const provinciaInput = document.getElementById('provincia');
            const paisInput = document.getElementById('pais');

            if (nuevaUbicacionContainer.classList.contains('hidden')) {
                // Mostrar los campos de crear una nueva ubicacion
                nuevaUbicacionContainer.classList.remove('hidden');
                // Ocultar el select de ubicacion
                labelUbicacion.classList.add('hidden');
                selectUbicacion.classList.add('hidden');

                // Habilitar los inputs
                provinciaInput.disabled = false;
                paisInput.disabled = false;

                // Cambiar el texto del botón
                this.innerText = 'Elegir ubicacion existente';
            } else {
                // Ocultar los campos de crear una nueva ubicacion
                nuevaUbicacionContainer.classList.add('hidden');
                // Mostrar el select de ubicacion
                labelUbicacion.classList.remove('hidden');
                selectUbicacion.classList.remove('hidden');

                // Deshabilitar los inputs
                provinciaInput.disabled = true;
                paisInput.disabled = true;

                // Cambiar el texto del botón
                this.innerText = 'Crear una nueva ubicacion';
            }
        });
    </script>
</x-AppLayout>
