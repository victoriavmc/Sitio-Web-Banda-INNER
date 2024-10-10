<x-AppLayout>
    @if (session('alertBorrar'))
        <x-alerts :type="session('alertBorrar')['type']">
            {{ session('alertBorrar')['message'] }}
        </x-alerts>
    @endif

    <div class="min-h-screen p-10">
        <div class="mb-10">
            <h1 class="text-center text-4xl">Lugares cargados</h1>
        </div>

        <div class="rounded-lg max-w-max mx-auto shadow-xl bg-white">
            <nav class="flex min-w-[240px] flex-col gap-1 p-1.5">
                @foreach ($lugares as $lugar)
                    <div
                        class="text-black flex justify-between gap-5 w-full items-center rounded-md p-2 pl-3 transition-all hover:bg-slate-200 focus:bg-slate-300 active:bg-slate-300">
                        <p>{{ $lugar->nombreLugar . ', ' . $lugar->localidad . ', ' . $lugar->calle . ' ' . $lugar->numero }}
                        </p> ==
                        <div class="grid grid-cols-2 place-items-center">
                            <button
                                class="rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-black hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                <svg class="w-5 h-5 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <form action="{{ route('eliminar-lugar', $lugar->idlugarLocal) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-black hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </nav>
        </div>
    </div>
</x-AppLayout>
