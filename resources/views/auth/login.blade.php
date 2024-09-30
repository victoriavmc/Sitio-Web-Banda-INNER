<x-AppLayout title="Login" :login=true>
    {{-- Comprueba si hay mensajes de alerta en la sesión para restablecer la contraseña --}}
    @if (session('alertRestablecer'))
        {{-- Componente personalizado para mostrar alertas, utilizando los datos almacenados en la sesión --}}
        <x-alerts :type="session('alertRestablecer')['type']">
            {{ session('alertRestablecer')['message'] }}
        </x-alerts>
    @endif

    {{-- Comprueba si hay mensajes de alerta en la sesión para el registro --}}
    @if (session('alertRegistro'))
        {{-- Componente de alerta para el registro exitoso o fallido --}}
        <x-alerts :type="session('alertRegistro')['type']">
            {{ session('alertRegistro')['message'] }}
        </x-alerts>
    @endif

    {{-- Contenedor del formulario de inicio de sesión con un fondo de imagen --}}
    <div class="loginLargo bg-cover bg-center flex items-center justify-center"
        style="background-image: url(' {{ asset('img/logeo/login_fondo.jpg') }} ');">

        {{-- Se inicializan datos reactivos con Alpine.js: email, password, name --}}
        <div x-data="{ email: '', password: '', name: '' }"
            class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl w-full max-w-md transform hover:scale-105 transition-all duration-300"
            {{-- GSAP anima la entrada de este div y los campos del formulario --}} x-init="gsap.from($el, { opacity: 0, y: 50, duration: 1, ease: 'back' });
            gsap.from('.input-field', { opacity: 0, x: -50, stagger: 0.2, duration: 0.8, ease: 'power2.out' });
            gsap.from('.btn', { opacity: 0, scale: 0.5, duration: 0.5, delay: 1, ease: 'elastic.out(1, 0.5)' });">

            {{-- Título de la página de inicio de sesión con animación de pulso --}}
            <h3 class="text-4xl font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">INICIAR SESION
            </h3>

            {{-- Formulario de inicio de sesión --}}
            <form class="space-y-6" method="POST" action="{{ route('inicia-sesion') }}">
                {{-- Token CSRF para proteger el formulario de ataques --}}
                @csrf

                {{-- Campo de entrada para el email con binding a Alpine.js --}}
                <div class="input-field relative">
                    <input x-model="email" name="email" type="text" id="email"
                        class="w-full font-urbanist px-4 py-3 rounded-lg bg-white bg-opacity-20 focus:bg-opacity-30 focus:ring-2 focus:ring-orange-500 text-white placeholder-gray-200 transition duration-200"
                        placeholder="Usuario / Correo Electronico">
                    {{-- Ícono de correo electrónico --}}
                    <i class="fas fa-envelope absolute right-3 top-3 text-white"></i>
                    {{-- Mensaje de error si hay problemas con el email --}}
                    @error('email')
                        <span class="font-bold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo de entrada para la contraseña con binding a Alpine.js --}}
                <div class="input-field relative">
                    <input x-model="password" name="password" type="password" id="password"
                        class="w-full font-urbanist px-4 py-3 rounded-lg bg-white bg-opacity-20 focus:bg-opacity-30 focus:ring-2 focus:ring-orange-500 text-white placeholder-gray-200 transition duration-200"
                        placeholder="Contraseña">
                    {{-- Ícono de candado --}}
                    <i class="fas fa-lock absolute right-3 top-3 text-white"></i>
                    {{-- Mensaje de error si hay problemas con la contraseña --}}
                    @error('password')
                        <span class="font-bold text-red-500">{{ $message }}</span>
                    @enderror
                    {{-- Mensaje de error general en caso de fallo de inicio de sesión --}}
                    @error('loginError')
                        <span class="font-bold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botón para enviar el formulario de inicio de sesión --}}
                <button type="submit" class="w-full bn632-hover bn19">
                    Iniciar Sesion
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            {{-- <div class="registroRedes mt-8 flex justify-center space-x-4">
                {{-- <a href="{{ route('auth.redirect') }}"
                    class="fab text-white hover:text-purple-300 transition-colors duration-200">
                    <img src="{{ asset('img/logo_face.svg') }}" alt="Logo Facebook">
                </a> --}}
            {{-- <a href="#" class="fab text-white hover:text-purple-300 transition-colors duration-200">
                    <img src="{{ asset('img/logo_microsoft.svg') }}" alt="Logo Microsoft">
                </a>
                <a href="#" class="fab text-white hover:text-purple-300 transition-colors duration-200">
                    <img src="{{ asset('img/logo_google.svg') }}" alt="Logo Google">
                </a>

                <a href="#" class="fab text-white hover:text-purple-300 transition-colors duration-200">
                    <img src="{{ asset('img/logo_spotify.svg') }}" alt="Logo Spotify">
                </a> --}}
            {{-- </div> --}}
            {{-- Enlaces para registro y restablecimiento de contraseña --}}
            <p class="text-white font-urbanist text-center mt-6">
                No tienes una cuenta?
                <a href="{{ route('registro') }}" class="bn-32 bn32">Registrate</a>
            </p>

            <p class="text-white font-urbanist text-center mt-6">
                Olvidaste tu contraseña?
                <a href="{{ route('solicitarPin') }}" class="bn-32 bn32">Restablecer</a>
            </p>
        </div>
    </div>

    {{-- Animación de GSAP para los íconos flotantes de redes sociales (comentado en el HTML) --}}
    <script>
        gsap.to('.fab', {
            y: -10,
            stagger: 0.1,
            duration: 0.8,
            repeat: -1,
            yoyo: true,
            ease: 'power1.inOut'
        });
    </script>
</x-AppLayout>
