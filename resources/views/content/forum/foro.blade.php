<x-AppLayout>
    <div class="bg-cover min-h-screen bg-center w-full p-10"
        style="background-image: url('{{ asset('img/foro_fondo.jpg') }}')">
        <div class='grid gap-3 justify-center'>
            <!-- Buscador -->
            <div class='flex items-center justify-around from-teal-100'>
                <div class='w-full max-w-lg bg-white bg-opacity-70 rounded-lg shadow-xl'>
                    {{-- <div
                        class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-gray-300 focus-within:!ring-2 ring-inset focus-within:!ring-teal-500 rounded-md">
                        <svg class="mr-2 h-5 w-5 stroke-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                        <input
                            class="block w-full appearance-none bg-transparent text-base text-gray-700 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6"
                            placeholder="Buscar publicacion..." aria-label="Search components"
                            id="headlessui-combobox-input-:r5n:" role="combobox" type="text" aria-expanded="false"
                            aria-autocomplete="list" value="" style="caret-color: rgb(107, 114, 128)">
                    </div> --}}
                </div>


                @auth
                    @if (auth()->user()->rol->idrol == 4)
                        <a class="bg-green-500 hover:bg-green-400 text-white text-base font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded"
                            href="{{ route('superFan') }}">Crear Publicación</a>
                    @else
                        <a class="bg-green-500 hover:bg-green-400 text-white text-base font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded"
                            href="{{ route('verFormularioForo') }}">Crear Publicación</a>
                    @endif
                @endauth

            </div>
            @foreach ($recuperoPublicaciones as $publicacion)
                <article>
                    <div class="max-w-4xl px-10 my-4 py-6 bg-white bg-opacity-70 rounded-lg shadow-md">
                        <div class="flex justify-end items-center">
                            <span class="text-base text-gray-900 font-normal">{{ $publicacion->fechaSubida }}</span>
                        </div>
                        <div class="mt-2">
                            <a class="text-2xl text-gray-900 font-bold hover:text-gray-600"
                                href="{{ route('foroUnico', $publicacion->idcontenidos) }}">{{ $publicacion->titulo }}</a>
                            <p class="mt-2 text-base text-gray-800">{{ $publicacion->descripcion }}</p>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <a class="text-green-600 text-sm font-bold"
                                href="{{ route('foroUnico', $publicacion->idcontenidos) }}">Leer Mas</a>
                            <div class="flex items-center">
                                {{-- VEO LA CANTIDAD DE COMENTARIOS QUE TIENE --}}
                                <div class=" px-3 py-1 rounded-lg flex space-x-2 flex-row">
                                    <div
                                        class=" text-black cursor-pointer text-center text-md justify-center items-center flex">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                            viewBox="0 0 24 24" height="1em" width="1em"
                                            xmlns="http://www.w3.org/2000/svg" class="text-md">
                                            <path
                                                d="M20 2H4c-1.103 0-2 .897-2 2v18l5.333-4H20c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 14H6.667L4 18V4h16v12z">
                                            </path>
                                            <circle cx="15" cy="10" r="2"></circle>
                                            <circle cx="9" cy="10" r="2"></circle>
                                        </svg>
                                        <span
                                            class="text-md text-black mx-1">{{ $contadorComentarios[$publicacion->idcontenidos]['cuenta'] ?? 0 }}</span>
                                    </div>
                                </div>
                                <!-- Recupera la visualización de estrellas para la publicación actual -->
                                @php
                                    $estrellasVisuales = $recuperoLikes[$publicacion->idcontenidos];
                                @endphp
                                <!-- Renderización de estrellas llenas -->
                                @for ($i = 0; $i < $estrellasVisuales['estrellasLlenas']; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor

                                <!-- Renderización de media estrella (si aplica) -->
                                @if ($estrellasVisuales['estrellasMedias'])
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endif

                                <!-- Renderización de estrellas vacías -->
                                @for ($i = 0; $i < $estrellasVisuales['estrellasVacias']; $i++)
                                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                                <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $estrellasVisuales['like'] }}</p>
                                <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">de</p>
                                <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $estrellasVisuales['like'] + $estrellasVisuales['dislike'] }}</p>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-AppLayout>
