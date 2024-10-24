<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        .section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .info p {
            font-size: 1.1rem;
            margin: 5px 0;
        }

        .info strong {
            color: #4A4A4A;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: gray;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <h1>Comprobante de Pago</h1>

    <div class="section">
        <h2>Detalles de la Operación</h2>
        <div class="info">
            <p><strong>Número de Factura:</strong> {{ $paymentDetails['factura'] }}</p>
            <p><strong>Monto:</strong> ${{ number_format($paymentDetails['monto'], 2) }}</p>
            <p><strong>Estado del Pago:</strong> {{ ucfirst($paymentDetails['estadoPago']) }}</p>
            <p><strong>Método de Pago:</strong> {{ $paymentDetails['metodoPago'] }}</p>
            <p><strong>Fecha de Aprobación:</strong>
                {{ \Carbon\Carbon::parse($paymentDetails['diaPago'])->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="section">
        <h2>Información del Comprador</h2>
        <div class="info">
            <p><strong>Nombre:</strong> {{ $paymentDetails['nombreComprador'] }}
                {{ $paymentDetails['apellidoComprador'] }}</p>
            <p><strong>Email del Comprador:</strong> {{ $paymentDetails['email_comprador'] }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por su compra.</p>
    </div>
</body>

</html>
