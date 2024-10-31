<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ !$recuperoRedesSociales->isEmpty() ? 'Inner' : 'PerriPepsi' }}</title>

    <style>
        .header p {
            color: white
        }

        p {
            color: black
        }

        .container {
            border: 2px solid #000000;
            max-width: 600px;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            display: grid;
            grid-row: 1;
            background: black;
        }

        .no-click {
            pointer-events: none;
        }

        .no-click img {
            pointer-events: none;
        }

        .body-content {
            margin-bottom: 20px;
            text-align: center;
        }

        .body-content a {
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #555555;
        }

        .social-media {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header" style="text-align: center;">
            @if (!$recuperoRedesSociales->isEmpty())
                <img style="width: 250px; height: auto;"
                    src="https://drive.google.com/uc?export=view&id=10gZANlyf6bae4Fs055t5hPnnYliAzFFA" alt="Inner">
            @else
                <img style="margin-left:10px; margin-top:10px; margin-bottom:10px; width: 48px; height: auto;"
                    src='https://drive.google.com/uc?export=view&id=1YX5QmFvgIOiD0uHoUVufU0zHWW1yrqDt' alt="PerriPepsi">
            @endif
        </div>

        <div class="body-content">
            {{ $slot }}
        </div>

        @if (!$recuperoRedesSociales->isEmpty())
            <div class="footer">
                <p>Síguenos en nuestras redes sociales:</p>
                <div class="social-media">
                    @foreach ($recuperoRedesSociales as $redSocial)
                        @if ($redSocial->linkRedSocial)
                            @switch($redSocial->nombreRedSocial)
                                @case('Instagram')
                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                        rel="noopener noreferrer">{{ $redSocial->nombreRedSocial }}</a>
                                    |
                                @break

                                @case('Deezer')
                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                        rel="noopener noreferrer">{{ $redSocial->nombreRedSocial }}</a>
                                    |
                                @break

                                @case('Spotify')
                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                        rel="noopener noreferrer">{{ $redSocial->nombreRedSocial }}</a>
                                    |
                                @break

                                @case('Youtube')
                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                        rel="noopener noreferrer">{{ $redSocial->nombreRedSocial }}</a>
                                    |
                                @break

                                @case('iTunes')
                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                        rel="noopener noreferrer">{{ $redSocial->nombreRedSocial }}</a>
                                    |
                                @break

                                @case('Amazon Music')
                                    <a href="{{ $redSocial->linkRedSocial }}" target="_blank"
                                        rel="noopener noreferrer">{{ $redSocial->nombreRedSocial }}</a>
                                    |
                                @break
                            @endswitch
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>

</html>
