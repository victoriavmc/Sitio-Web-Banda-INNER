<div id="alert-1"
    {{ $attributes->merge(['class' => 'alert-fixed flex items-center justify-between border p-4 rounded-lg fixed top-5 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-xl opacity-100 transition-opacity duration-500 ' . $class]) }}
    role="alert">
    <div class="flex items-center">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">{{ $title ?? 'Info Alert' }}</span>
        <div class="ml-3 text-sm font-medium">
            {{ $type }}! {{ $slot }}
        </div>
    </div>
    <button type="button"
        class="{{ $class2 }} ms-auto -mx-1.5 -my-1.5 p-1.5 rounded-lg inline-flex items-center justify-center h-8 w-8"
        data-dismiss-target="#alert-1" aria-label="Close">
        <span class="sr-only">Cerrar</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
