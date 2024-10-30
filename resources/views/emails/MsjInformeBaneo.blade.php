<x-EmailLayout>
    <h1>Notificación de Reporte en tu Cuenta</h1>
    <p>Estimado usuario {{ $usuario }},</p>
    <p>Hemos recibido un reporte sobre tu cuenta. Tras una revisión exhaustiva, hemos determinado que se han incumplido
        las normas de nuestra comunidad.</p>
    <p>Los motivos por los que hemos decidido suspenderte son: </p>
    @foreach ($motivosNombres as $motivo)
        <p style="color: red">{{ $motivo }}</p>
    @endforeach
    <p>Como resultado de esta situación, hemos decidido eliminar la actividad relacionada y <strong>bloquear tu
            cuenta</strong>.</p>
    <p>La suspensión será efectiva desde el <strong>{{ $fechaInicia }}</strong> hasta el
        <strong>{{ $fechaFinal }}</strong>. Durante este período, no podrás acceder a tu cuenta.
    </p>
    <p>Agradecemos tu comprensión y te animamos a revisar nuestras normas comunitarias para evitar futuros
        inconvenientes.</p>
</x-EmailLayout>
