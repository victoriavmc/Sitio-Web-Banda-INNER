<x-EmailLayout>
    <h1>¡Compra de Entradas Confirmada!</h1>
    <p>¡Gracias por tu compra! Tus entradas para el evento están confirmadas.</p>
    <p>Detalles de la compra:</p>
    <ul>
        <li>Evento: {{ $nombre_evento }}</li>
        <li>Fecha y hora: {{ $fecha_hora_evento }}</li>
        <li>Ubicación: {{ $lugar_evento }}</li>
        <li>Cantidad de entradas: {{ $cantidad_entradas }}</li>
        <li>Total pagado: {{ $monto_total }}</li>
    </ul>
    <p>Puedes presentar la orden de compra o descargar tus entradas en nuestro sitio web.</p>
</x-EmailLayout>
