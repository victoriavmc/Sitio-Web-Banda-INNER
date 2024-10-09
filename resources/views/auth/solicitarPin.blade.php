<x-AppLayout title="Login" :login=true>
    <div class="
    bg-cover bg-center flex items-center justify-center"
        style="background-image: url(' {{ asset('img/logeo/restablecer_fondo_agus.png') }} ');">
        <div x-data="{ email: '', password: '', name: '' }"
            class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl w-full max-w-md transform hover:scale-105 transition-all duration-300"
            x-init="gsap.from($el, { opacity: 0, y: 50, duration: 1, ease: 'back' });
            gsap.from('.input-field', { opacity: 0, x: -50, stagger: 0.2, duration: 0.8, ease: 'power2.out' });
            gsap.from('.btn', { opacity: 0, scale: 0.5, duration: 0.5, delay: 1, ease: 'elastic.out(1, 0.5)' });">
            <h3 class="text-4xl font-extrabold deepshadow text-white mb-6 text-center hover:animate-pulse">RESTABLECER
            </h3>
            <form class="space-y-6" method="POST" action="{{ route('solicitar-pin') }}">
                @csrf
                <p class="text-white font-urbanist text-center mt-6">
                    Ingresa tu correo para que podamos enviarte el pin de recuperacion
                </p>
                <div class="input-field relative">
                    <input x-model="email" name="email" type="text" id="email"
                        class="w-full font-urbanist px-4 py-3 rounded-lg bg-white bg-opacity-20 focus:bg-opacity-30 focus:ring-2 focus:ring-orange-500 text-white placeholder-gray-200 transition duration-200"
                        placeholder="Correo">
                    <i class="fas fa-envelope absolute right-3 top-3 text-white"></i>
                    @error('email')
                        <span class="font-bold text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full bn632-hover bn19">
                    Solicitar Pin
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</x-AppLayout>
