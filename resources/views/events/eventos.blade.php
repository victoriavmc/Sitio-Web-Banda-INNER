<x-AppLayout>
    @if (session('alertCrear'))
        <x-alerts :type="session('alertCrear')['type']">
            {{ session('alertCrear')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertModificar'))
        <x-alerts :type="session('alertModificar')['type']">
            {{ session('alertModificar')['message'] }}
        </x-alerts>
    @endif

    @if (session('alertBorrar'))
        <x-alerts :type="session('alertBorrar')['type']">
            {{ session('alertBorrar')['message'] }}
        </x-alerts>
    @endif

    <div class="p-10 min-h-screen">
        <h3 class="text-8xl font-amsterdam deepshadow text-white mb-6 text-center hover:animate-pulse">
            eventos
        </h3>
        <div class="flex mb-5">
            @auth
                @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                    <div class="flex gap-4 mt-4 absolute z-10">
                        <div class="flex items-center gap-10">
                            <a href="{{ route('crear-formulario') }}"
                                class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">Agregar</a>
                        </div>

                        <div class="flex items-center gap-10">
                            <a href="{{ route('lugares-cargados') }}"
                                class="bg-red-500 hover:bg-red-400 text-white text-base font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded w-max">
                                Lugares y ubicaciones cargadas
                            </a>
                        </div>
                    </div>
                @endif
            @endauth
            <div class="w-full flex justify-center items-center relative z-0">
                <form action="{{ route('eventos') }}" method="GET"
                    class="w-full max-w-lg bg-white rounded-lg shadow-xl">
                    <div
                        class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-red-500 focus-within:!ring-2 ring-inset focus-within:!ring-red-500 rounded-md">
                        <svg class="mr-2 h-5 w-5 text-black stroke-black" fill="none" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input
                            class="block w-full appearance-none text-base text-black placeholder:text-black focus:outline-none sm:text-sm sm:leading-6 border-none"
                            placeholder="Buscar publicacion..." name="search" aria-label="Search components"
                            type="text" aria-expanded="false" aria-autocomplete="list"
                            value="{{ request('search') }}" style="caret-color: rgb(107, 114, 128)">
                    </div>
                </form>
            </div>
        </div>

        {{-- EVENTOS --}}
        @if ($shows->isEmpty())
            <p class="text-center text-2xl text-gray-500">No se encontraron eventos</p>
        @else
            <div class="relative grid lg:grid-cols-2 gap-5">
                @foreach ($shows as $show)
                    <div class="relative items-start text-black bg-white p-3 rounded-xl shadow-xl"
                        style="display: grid; grid-template-columns:30% 35% 35%">
                        <img class="h-full rounded-xl"
                            src="{{ $show->revisionImagenes && $show->revisionImagenes->imagenes
                                ? asset(Storage::url($show->revisionImagenes->imagenes->subidaImg))
                                : asset('img\logo_inner_negro.webp') }}"
                            alt="Imagen de {{ $show->nombreLugar }}" />

                        <div class="text-sm h-full flex flex-col justify-between ml-4 gap-2">
                            <p class="event-date text-lg">
                                {{ \Carbon\Carbon::parse($show->fechashow)->format('d F Y') }}</p>
                            <p class="text-lg">
                                {{ $show->ubicacionshow->provinciaLugar . ', ' . $show->ubicacionshow->paisLugar }}</p>
                            <p class="text-4xl font-medium text-black leading-none">
                                {{ $show->lugarlocal->nombreLugar }}
                            </p>
                            <p class="text-lg">{{ $show->lugarlocal->localidad }}</p>

                            {{ $show->lugarlocal->calle . ', ' . $show->lugarlocal->numero }}</p>
                            <p class="event-date text-lg">
                                {{ \Carbon\Carbon::parse($show->fechashow)->format('H:i') }}hs</p>
                            <div class="flex flex-col gap-3">
                                @if (now() < $show->fechashow)
                                    <form id="form-{{ $show->idshow }}" class="w-max h-max" action=""
                                        method="">
                                        <h1 class="hidden product-name">Entrada para el concierto en
                                            {{ $show->lugarlocal->nombreLugar }}!</h1>

                                        <input type="hidden" id="name-{{ $show->idshow }}" name="name"
                                            value="{{ $usuario->datospersonales->nombreDP }}" required />

                                        <input type="hidden" id="surname-{{ $show->idshow }}" name="surname"
                                            value="{{ $usuario->datospersonales->apellidoDP }}" required />

                                        <input type="hidden" id="email-{{ $show->idshow }}" name="email"
                                            value="{{ $usuario->correoElectronicoUser }}" required />

                                        <input type="hidden" id="product_id-{{ $show->idshow }}"
                                            value="evento-{{ $show->idshow }}" />

                                        <input type="hidden" id="idprecioServicio-{{ $show->idshow }}"
                                            name="idprecioServicio" value="{{ $ultimoPrecio['idprecioServicio'] }}" />

                                        <input type="hidden" id="product_price-{{ $show->idshow }}"
                                            value="{{ $ultimoPrecio['precio'] }}" />

                                        @if ($ultimoPrecio['precio'] != null)
                                            <button id="checkout-btn-{{ $show->idshow }}" type="button"
                                                onclick="handleCheckout({{ $show->idshow }})"
                                                class="group max-w-max inline-flex items-center h-9 rounded-full text-sm font-semibold whitespace-nowrap px-3 focus:outline-none focus:ring-2 bg-red-500 text-white hover:bg-red-400 hover:text-white focus:ring-slate-700">
                                                <span class="icon-credit-card text-xl text-center mb-2 mr-1">💳</span>
                                                <p>Adquirir Entrada</p>
                                            </button>
                                        @endif
                                    </form>
                                @endif

                                {{-- <a href="{{ $show->linkCompraEntrada }}" target="_blank">
                                <button class="boton-vermas">
                                    <p>Ver en Google Maps</p>
                                </button>
                            </a> --}}
                            </div>
                        </div>
                        {{-- Google Maps --}}
                        {{-- <div id="mapa" class="z-0 w-full h-full"></div> --}}
                        {{-- CRUD EVENTOS --}}
                        @auth
                            @if (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)
                                <div class="z-10 absolute flex gap-3 w-full p-4 justify-end">
                                    <button type="button" id="btn-precio" data-show-id="{{ $show->idshow }}"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold p-1 rounded">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('modificar-formulario', $show->idshow) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-1 rounded">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                clip-rule="evenodd" />
                                            <path fill-rule="evenodd"
                                                d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <form class="formEliminarUsuario"
                                        action="{{ route('eliminar-evento', $show->idshow) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold p-1 rounded">
                                            <svg class="w-5 h-5 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modal para cambiar precio del evento --}}
    <div id="modal-precio" class="hidden">
        <div class="fixed inset-0 z-20 bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-md w-1/3">
                <h2 class="text-xl font-bold mb-4">Actualizar Precio</h2>
                <form action="{{ route('actualizar-precio') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                        <input type="number" name="precio" id="precio"
                            class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            placeholder="Precio" required>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="button" id="closeDeleteModalBtn"
                            class="bg-gray-500 hover:bg-gray-400 text-white text-base font-bold py-2 px-4 border-b-4 border-gray-700 hover:border-gray-500 rounded">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-400 text-white text-base font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded">
                            Actualizar Precio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("{{ env('MERCADO_PAGO_PUBLIC_KEY') }}");

        function handleCheckout(showId) {
            // Capturar datos del formulario específico usando el ID dinámico
            const nombreProducto = document.querySelector(`#form-${showId} .product-name`).textContent;
            const nombre = document.getElementById(`name-${showId}`).value;
            const apellido = document.getElementById(`surname-${showId}`).value;
            const email = document.getElementById(`email-${showId}`).value;
            const productId = document.getElementById(`product_id-${showId}`).value;
            const productPrice = parseFloat(document.getElementById(`product_price-${showId}`).value);
            const idprecioServicio = document.getElementById(`idprecioServicio-${showId}`).value;

            if (!nombre || !apellido || !email) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Por favor, completa todos los campos.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            const orderData = {
                product: [{
                    id: productId,
                    title: nombreProducto,
                    quantity: 1,
                    currency_id: "ARS",
                    unit_price: productPrice,
                }],
                name: nombre,
                surname: apellido,
                email: email,
                idprecioServicio: idprecioServicio,
            };

            console.log('Datos del pedido:', orderData);

            // Enviar los datos al backend para crear la preferencia de pago
            fetch('/create-preference', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(preference => {
                    if (preference.error) {
                        throw new Error(preference.error);
                    }
                    mp.checkout({
                        preference: {
                            id: preference.id
                        },
                        autoOpen: true
                    });
                    console.log('Respuesta de la preferencia:', preference);
                })
                .catch(error => console.error('Error al crear la preferencia:', error));
        }

        // Modal para cambiar precio del evento
        const modalPrecio = document.getElementById('modal-precio');
        const btnPrecio = document.getElementById('btn-precio');

        btnPrecio.addEventListener('click', () => {
            modalPrecio.classList.toggle('hidden');
        });

        // Cerrar modal
        const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
        closeDeleteModalBtn.addEventListener('click', () => {
            modalPrecio.classList.toggle('hidden');
        });

        // No se que hace, pero no lo toco xd
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const eventosContainer = document.getElementById('eventosContainer');

            searchInput.addEventListener('input', function() {
                const searchQuery = searchInput.value;

                if (searchQuery.length > 0) {
                    fetch(`/buscar-eventos?search=${searchQuery}`)
                        .then(response => response.json())
                        .then(data => {
                            // Limpiar el contenedor de eventos
                            eventosContainer.innerHTML = '';

                            // Renderizar los eventos filtrados
                            data.forEach(show => {
                                const eventHTML = `
                                <div class="relative items-start text-white p-3 rounded-xl border-2 border-red-500" style="background-color:#323232; display: grid; grid-template-columns:30% 35% 35%">
                                    <img class="h-full" src="${show.revision_imagenes ? '/storage/' + show.revision_imagenes.imagenes.subidaImg : '/img/logo_inner_negro.webp'}" alt="Imagen de ${show.nombreLugar}">
                                    <div class="text-sm h-full flex flex-col justify-between ml-4 gap-2">
                                        <p class="event-date text-lg">${new Date(show.fechashow).toLocaleDateString()}</p>
                                        <p class="text-lg">${show.ubicacionshow.provinciaLugar}, ${show.ubicacionshow.paisLugar}</p>
                                        <p class="text-4xl font-medium hover:text-[#e60b0b] leading-none">${show.lugarlocal.nombreLugar}</p>
                                        <p class="text-lg">${show.lugarlocal.localidad}</p>
                                        <p class="text-lg">${show.lugarlocal.calle}, ${show.lugarlocal.numero}</p>
                                        <p class="event-date text-lg">${new Date(show.fechashow).toLocaleTimeString()}hs</p>
                                    </div>
                                </div>
                            `;
                                eventosContainer.insertAdjacentHTML('beforeend', eventHTML);
                            });
                        })
                        .catch(error => console.error('Error fetching events:', error));
                }
            });
        });
    </script>
</x-AppLayout>
