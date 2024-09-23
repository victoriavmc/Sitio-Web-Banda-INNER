<x-AppLayout>
    <div class="bg-gray-600 contenedor p-10">
        <div class='grid gap-3'>
            @foreach ($shows as $show)
                <article>
                    <div class="max-w-4xl px-10 my-4 py-6 bg-white bg-opacity-70 rounded-lg shadow-md">
                        <div class="flex justify-end items-center">
                            <span class="text-base text-gray-900 font-normal">{{ $show->fechashow }}</span>
                        </div>
                        <div class="mt-2">
                            <a class="text-2xl text-gray-900 font-bold hover:text-gray-600"
                                href="#">{{ $show->lugarlocal->nombreLugar }}</a>
                            <p class="mt-2 text-base text-gray-800">
                                {{ $show->lugarlocal->calle . ' ' . $show->lugarlocal->numero }}</p>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <a class="text-green-600 text-sm font-bold"
                                href="{{ route('foroVer', $show->idshow) }}">Leer Mas</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-AppLayout>
