<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inner</title>

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
            <img src="https://drive.google.com/uc?export=view&id=10gZANlyf6bae4Fs055t5hPnnYliAzFFA" alt="Inner"
                style="width: 250px; height: auto;">
        </div>

        <div class="body-content">
            {{ $slot }}
        </div>

        <div class="footer">
            <p>Síguenos en nuestras redes sociales:</p>
            <div class="social-media">
                <a href="{{ $linkSpotify }}">Spotify
                </a> |
                <a href="{{ $linkYoutube }}">YouTube
                </a> |
                <a href="{{ $linkItunes }}">Apple Music
                </a> |
                <a href="{{ $linkInstagram }}">Instagram
                </a>
            </div>
        </div>
    </div>
</body>

</html>
