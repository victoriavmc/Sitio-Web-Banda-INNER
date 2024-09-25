<x-AppLayout>
    <div class="container mx-auto py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Columna 1 -->
            <div class="bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-xl font-bold mb-4">
                    <a class="hover:animate-pulse" href="#album-imagenes">Imágenes Exclusivas</a>
                </h2>
                <p>Contenido de la primera columna.</p>
            </div>
            <!-- Columna 2 -->
            <div class="bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-xl font-bold mb-4">
                    <a class="hover:animate-pulse" href="#album-videos-exclusivos">Videos Exclusivos</a>
                </h2>
                <p>Contenido de la segunda columna.</p>
            </div>
            <!-- Columna 3 -->
            <div class="bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-xl font-bold mb-4">
                    <a class="hover:animate-pulse" href="#album-videos-oficiales">Videos Oficiales</a>
                </h2>
                <p>Contenido de la tercera columna.</p>
            </div>
        </div>
    </div>

    {{-- Album de Imagenes --}}
    <section id="album-imagenes">
        <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
            <h2 class="text-center text-3xl font-bold md:text-5xl">Álbum de Imágenes</h2>
            <div class="mx-auto grid justify-items-stretch gap-4 md:grid-cols-2 lg:gap-10">
                <a href="#" class="relative flex h-[300px] items-end">
                    <img src="https://firebasestorage.googleapis.com/v0/b/flowspark-1f3e0.appspot.com/o/Tailspark%20Images%2FPlaceholder%20Image.svg?alt=media&token=375a1ea3-a8b6-4d63-b975-aac8d0174074"
                        alt="" class="inline-block h-full w-full rounded-lg object-cover" />
                    <div class="absolute bottom-5 left-5 flex flex-col justify-center rounded-lg bg-white px-8 py-4">
                        <p class="text-sm font-medium sm:text-xl">Project Name</p>
                        <p class="text-sm sm:text-base">Microsoft</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Album de Videos Exclusivos --}}
    <section id="album-videos-exclusivos">
        <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
            <h2 class="text-center text-3xl font-bold md:text-5xl">Álbum de Videos Exclusivos</h2>
            <div class="mx-auto grid justify-items-stretch gap-4 md:grid-cols-2 lg:gap-10">
                <a href="#" class="relative flex h-[300px] items-end">
                    <img src="https://firebasestorage.googleapis.com/v0/b/flowspark-1f3e0.appspot.com/o/Tailspark%20Images%2FPlaceholder%20Image.svg?alt=media&token=375a1ea3-a8b6-4d63-b975-aac8d0174074"
                        alt="" class="inline-block h-full w-full rounded-lg object-cover" />
                    <div class="absolute bottom-5 left-5 flex flex-col justify-center rounded-lg bg-white px-8 py-4">
                        <p class="text-sm font-medium sm:text-xl">Project Name</p>
                        <p class="text-sm sm:text-base">Microsoft</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Album Videos Oficiales --}}
    <section id="album-videos-oficiales">
        <div class="p-5 sm:p-8">
            <div class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                <img
                    src="https://images.unsplash.com/photo-1472491235688-bdc81a63246e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHwwfHx8MTcyMTgyMjE3OXww&ixlib=rb-4.0.3&q=80&w=1080" />
            </div>
        </div>
    </section>
</x-AppLayout>
