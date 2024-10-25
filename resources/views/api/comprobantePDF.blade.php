<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recibo de Pago</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
            /* bg-gray-100 */
            margin: 0;
        }

        .receipt-container {
            border: 2px dashed #cbd5e0;
            /* border-gray-400 */
            padding: 1.5rem;
            /* p-6 */
            width: 650px;
            background-color: white;
            /* bg-white */
        }

        .header {
            display: flex;
            justify-content: space-between;
            /* Distribuye el espacio entre los elementos */
            align-items: center;
            /* Alinea verticalmente */
            margin-bottom: 1rem;
            /* mb-4 */
            gap: 0.75rem;
            /* gap-3 */
        }

        .header-title {
            color: #dd6b20;
            /* text-orange-500 */
            font-size: 1.5rem;
            /* text-2xl */
            font-weight: bold;
        }

        .header-info {
            text-align: right;
            font-size: 0.875rem;
            /* text-sm */
        }

        .header-info p {
            font-weight: 600;
            /* font-semibold */
            margin: 0;
            /* Elimina márgenes para una mejor alineación */
        }

        .header-info .date,
        .header-info .number,
        .header-info .amount {
            color: #a0aec0;
            /* text-gray-500 */
        }

        .divider {
            border-top: 1px solid #cbd5e0;
            /* border-t border-gray-400 */
            margin-bottom: 1rem;
            /* mb-4 */
        }

        .item {
            display: flex;
            justify-content: space-between;
        }

        .item-title {
            color: #3182ce;
            /* text-blue-600 */
            font-weight: bold;
            /* font-semibold */
        }

        .item-value {
            border-bottom: 1px solid #e2e8f0;
            /* border-b border-gray-300 */
            margin-left: 1rem;
            /* ml-4 */
            flex: 1;
            padding: 0.5rem 0;
            /* added padding for spacing */
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="header">
            <div class="header-title">RECIBO DE PAGO</div>
            <div class="header-info">
                <p>Fecha: <span class="date">{{ $paymentDetails['diaPago'] }}</span></p>
                <p>Número: <span class="number">{{ $paymentDetails['factura'] }}</span></p>
                <p>Cantidad: <span class="amount">${{ number_format($paymentDetails->precio['precio'], 2) }}</span></p>
            </div>
        </div>
        <div class="divider"></div>
        <div>
            <div class="item">
                <p class="item-title">Descripción de compra</p>
                <p class="item-value">
                    {{ $paymentDetails->precio['tipoServicio'] === 'Suscripcion' ? 'Suscripción Permanente a INNER!' : $paymentDetails->precio['tipoServicio'] }}
                </p>
            </div>
            <div class="item">
                <p class="item-title">Método de pago</p>
                <p class="item-value">
                    @if ($paymentDetails['metodoPago'] === 'account_money')
                        Dinero en Cuenta
                    @elseif($paymentDetails['metodoPago'] === 'credit_card')
                        Tarjeta de Crédito
                    @elseif($paymentDetails['metodoPago'] === 'debit_card')
                        Tarjeta de Débito
                    @else
                        {{ $paymentDetails['metodoPago'] }}
                    @endif
                </p>
            </div>
            <div class="item">
                <p class="item-title">Vendedor</p>
                <p class="item-value">Mercado Pago</p>
            </div>
            <div class="item">
                <p class="item-title">Comprador</p>
                <p class="item-value">{{ $paymentDetails['nombreComprador'] }}
                    {{ $paymentDetails['apellidoComprador'] }}</p>
            </div>
            <div class="item">
                <p class="item-title">Email del comprador</p>
                <p class="item-value">{{ $email }}</p>
            </div>
            <div class="item">
                <p class="item-title">Estado del Pago</p>
                <p class="item-value">
                    @if ($paymentDetails['estadoPago'] === 'approved')
                        Aprobado
                    @elseif($paymentDetails['estadoPago'] === 'pending')
                        Pendiente
                    @elseif($paymentDetails['estadoPago'] === 'rejected')
                        Rechazado
                    @else
                        {{ ucfirst($paymentDetails['estadoPago']) }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>
