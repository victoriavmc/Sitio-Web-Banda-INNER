<x-AppLayout>
    <!-- Styles -->
    <style>
        .product-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .product-image {
            flex: 1;
            position: relative;
            aspect-ratio: 16 / 9;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 1rem;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 2rem;
            font-weight: bold;
            color: #1a202c;
            /* Gray-900 */
        }

        .product-price {
            font-size: 1.5rem;
            color: #1a202c;
            /* Gray-900 */
        }

        .product-specs {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .spec-label {
            font-weight: 600;
        }

        .color-box {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border: 1px solid #4a5568;
            /* Gray-600 */
            border-radius: 50%;
        }

        .order-form {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 500;
            color: #4a5568;
            /* Gray-700 */
        }

        input {
            padding: 0.5rem;
            border: 1px solid #cbd5e0;
            /* Gray-300 */
            border-radius: 0.375rem;
        }

        .btn-submit {
            padding: 0.75rem;
            background-color: #4f46e5;
            /* Indigo-600 */
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #4338ca;
            /* Indigo-700 */
        }

        .btn-pay {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background-color: #38a169;
            /* Green-400 */
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 1rem;
        }

        .btn-pay:hover {
            background-color: #2f855a;
            /* Green-700 */
        }

        .icon-credit-card {
            margin-right: 0.5rem;
        }
    </style>
    </head>
    <div class="product-container px-36">
        <div class="product-details">
            <div class="product-image">
                <img src="{{ asset('img/index_fondo_ng.webp') }}" alt="Producto Ejemplo" />
            </div>
            <div class="product-info">
                <h1 class="product-name">Suscripción Permanente a INNER!</h1>
                <div class="product-price" id="product-price">$1000 <span class="text-sm">(Solo efectivo o
                        transferencia)</span></div>
                <hr />
                <form action="#" method="POST" class="order-form">
                    @csrf
                    <div class="form-group">
                        <label class="mb-1" for="name">Nombre del Comprador</label>
                        <input type="tel" id="name" name="name" required />
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="surname">Apellido del Comprador</label>
                        <input type="text" id="surname" name="surname" required />
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="email">Email</label>
                        <input type="email" id="email" name="email" required />
                    </div>
                    <input type="hidden" id="product_id" value="1234567890" />
                    <input type="hidden" id="product_price" value="1" />

                    <button class="btn-submit" id="checkout-btn" type="button">
                        <span class="icon-credit-card text-center">💳</span>Pagar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("{{ env('MERCADO_PAGO_PUBLIC_KEY') }}");

        document.getElementById('checkout-btn').addEventListener('click', function() {
            // Capturar datos del formulario
            const nombre = document.getElementById('name').value;
            const apellido = document.getElementById('surname').value;
            const email = document.getElementById('email').value;
            const productId = document.getElementById('product_id').value;
            const productPrice = parseFloat(document.getElementById('product_price').value);

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
                    title: 'Suscripción',
                    quantity: 1,
                    currency_id: "ARS",
                    unit_price: productPrice,
                }],
                name: nombre,
                surname: apellido,
                email: email,
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
        });
    </script>
</x-AppLayout>
