<x-EmailLayout>
    @if ($notificacionesMarcadas != null && $accion != 0)
        <h1>¡Te suscribiste al tablero de Notificaciones!</h1>
        <p>¡Te has suscrito a las notificaciones de tipo:</p>
        @foreach ($nombreNotificacion as $notification)
            <p style="margin: 0">{{ $notification }}</p>
        @endforeach
        <p>No te pierdas nuestras últimas novedades y mantente al tanto de todo lo que tenemos para ofrecer.</p>
        <p>Visita nuestro sitio web para más detalles.</p>
    @else
        <h1>Te has desuscrito del tablero de Notificaciones</h1>
        <p>Si cambias de opinión, siempre puedes volver a suscribirte y estar al tanto de nuestras últimas novedades.
        </p>
        <p>Visita nuestro sitio web para gestionar tus preferencias.</p>
    @endif
</x-EmailLayout>
