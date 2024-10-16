<x-EmailLayout>
    <h1>REPORTARON UNA CUENTA</h1>
    <p>Hemos recibido un Reporte. <br>
        {{ $genero }}: {{ $usuarioQueReporta }}.</p>
    <p><strong>Reporto la cuenta: {{ $usuarioReportado }}</strong></p>
    <p>Verifica {{ $tipoActividad }}.</p>
</x-EmailLayout>
