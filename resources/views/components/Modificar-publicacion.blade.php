<form action="{{ route('modificarP', $contenido->idcontenidos) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" value="{{ old('titulo', $contenido->titulo) }}" required>
    </div>
    <div>
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" required>{{ old('descripcion', $contenido->descripcion) }}</textarea>
    </div>
    <div>
        <label for="imagen">Imágenes actuales:</label>
        <div class="current-images">
            @if ($imagenes->isEmpty())
                <p>No hay imágenes disponibles.</p>
            @else
                @foreach ($imagenes as $imagen)
                    <div class="image-container">
                        <img src="{{ asset($imagen->subidaImg) }}" alt="Imagen"
                            style="max-width: 200px; max-height: 200px; margin: 5px;">
                        <p>Fecha de subida: {{ $imagen->fechaSubidaImg }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div>
        <label for="imagen">Imagen/es (*Opcional, pero la primera es portada)</label>
        <input type="file" name="imagen[]" multiple>
    </div>
    <button type="submit">Actualizar</button>
</form>
