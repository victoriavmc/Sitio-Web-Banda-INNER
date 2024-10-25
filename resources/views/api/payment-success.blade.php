<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="p-8 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold text-green-600 mb-4">¡Pago realizado con éxito!</h1>

        <p class="mb-4">Gracias por tu compra. Aquí tienes los detalles de tu pedido:</p>
        <ul class="mb-4">
            <li><strong>Número de Factura:</strong> {{ $paymentDetails['factura'] }}</li>
            <li><strong>Monto:</strong> ${{ number_format($paymentDetails['monto'], 2) }}</li>
            <li>
                <strong>Descripción:</strong>
                {{ $paymentDetails['descripcion'] === 'Suscripción' ? 'Suscripción Permanente a INNER!' : $paymentDetails['descripcion'] }}
            </li>
        </ul>

        <div class="flex justify-between">
            <a href="{{ route('mercadopago.comprobante', $paymentDetails['factura']) }}" target="blank">
                <button id="download-btn" class="btn-pay bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Descargar Comprobante
                </button>
            </a>

            <a href="{{ route('inicio') }}">
                <button id="download-btn" class="btn-pay bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Inicio
                </button>
            </a>
        </div>

    </div>
</body>

</html>
