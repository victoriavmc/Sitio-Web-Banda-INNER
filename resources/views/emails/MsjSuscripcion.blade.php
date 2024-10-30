<x-EmailLayout>
    <h1>¡Suscripción Confirmada!</h1>
    <p>¡Gracias por tu pago! Se ha completado la suscripción como SuperFan a nuestra página.</p>
    <p>Detalles de la suscripción:</p>
    <p>Numero de comprobante: {{ $idordenpago }}</p>
    <p>Tipo de suscripción: Suscripcion Vitalicia a INNER!</p>
    <p>Numero de transaccion: {{ $factura }}</p>
    <p>Monto: ${{ $monto }}</p>
    <p>Fecha de pago: {{ $diaPago }}</p>
    <p>Ahora puedes disfrutar de todos los beneficios y contenido exclusivo.</p>
</x-EmailLayout>
