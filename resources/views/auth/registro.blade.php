<x-AppLayout title="Registro">
    <div class="wrapper bg-center justify-center" style="background-image: url('{{ asset('img/registro_fondo.jpg') }}');">
        <div class="inner bg-black bg-opacity-20 backdrop-blur-lg rounded-3xl shadow-2xl transform z-10 flex">
            <!-- Columna de la imagen -->
            <div class="image-column flex-1 flex justify-center items-center p-4">
                <img class="pequeño" src="{{ asset('img/registro_costado.jpg') }}" alt="AgusFacha">
            </div>

            <!-- Columna del formulario -->
            <div class="form-column flex-1 flex justify-center items-center">
                <form id="form-registro" class="font-urbanist z-10 w-full max-w-md" method="POST"
                    action="{{ route('validar-registro') }}">
                    @csrf
                    <h3 class="font-bold deepshadow mb-4">Registro</h3>

                    <!-- Nombre y Apellido -->
                    <div class="form-wrapper mb-4">
                        @error('nombre')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="text" name="nombre" placeholder="Nombre"
                            class="form-control pl-0 text-white bg-black bg-opacity-0" value="{{ old('nombre') }}">
                    </div>
                    <div class="form-wrapper mb-4">
                        @error('apellido')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="text" name="apellido" placeholder="Apellido"
                            class="form-control pl-0 text-white bg-black bg-opacity-0" value="{{ old('apellido') }}">
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="form-wrapper mb-4">
                        @error('fechaNacimiento')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="date" name="fechaNacimiento"
                            class="form-control pl-0 text-white bg-black bg-opacity-0"
                            value="{{ old('fechaNacimiento') }}">
                        <i class="zmdi zmdi-calendar icon-white"></i>
                    </div>

                    <!-- Usuario -->
                    <div class="form-wrapper mb-4 font-urbanist">
                        @error('usuario')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="text" name="usuario" autocomplete="new-password" placeholder="Usuario"
                            class="form-control pl-0 text-white bg-black bg-opacity-0" value="{{ old('usuario') }}">
                        <i class="zmdi zmdi-account"></i>
                    </div>

                    <!-- Pais de nacimiento -->
                    <div class="form-wrapper font-urbanist">
                        @error('paisDeNacimiento')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <select id="country-select" name="paisDeNacimiento"
                            class="form-control pl-0 text-white bg-black bg-opacity-0">
                            <option value="" disabled selected>Pais de nacimiento</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idPaisNacimiento }}">{{ $pais->nombrePN }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="selected-country" value="{{ old('paisDeNacimiento') }}">
                        <i class="zmdi zmdi-globe"></i>

                    </div>

                    <!-- Correo Electrónico -->
                    <div class="form-wrapper mb-4 font-urbanist">
                        @error('email')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="email" name="email" autocomplete="new-password"
                            placeholder="Correo Electrónico" class="form-control pl-0 text-white bg-black bg-opacity-0"
                            value="{{ old('email') }}">
                        <i class="zmdi zmdi-email"></i>
                    </div>

                    <!-- Género -->
                    <div class="form-wrapper mb-4 font-urbanist">
                        @error('genero')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <select name="genero" id="" class="form-control text-white bg-black bg-opacity-0">
                            <option value="" disabled selected>Género</option>
                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino
                            </option>
                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino
                            </option>
                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        <i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-wrapper mb-4 font-urbanist">
                        @error('password')
                            <span class="font-bold text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="password" name="password" autocomplete="new-password" placeholder="Contraseña"
                            class="form-control pl-0 text-white bg-black bg-opacity-0">
                        <i class="zmdi zmdi-lock"></i>
                    </div>

                    <!-- Botón de Registro -->
                    <div class="m-auto w-max">
                        <button type="submit" class="bn1">Registrarse
                            <i class="zmdi zmdi-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-AppLayout>
