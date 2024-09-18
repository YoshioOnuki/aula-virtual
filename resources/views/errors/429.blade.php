<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'Aula Virtual' }}</title>

    <link rel="shortcut icon" href="{{ asset('/media/logo-unu.webp') }}" type="image/x-icon">

    <link href="{{ asset('assets/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .full-height {
            height: 100vh;
        }

        .empty {
            text-align: center;
        }

    </style>
    <script src="{{ asset('assets/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1684106062') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

</head>

<body class=" border-top-wide border-teal d-flex flex-column">
    <script src="{{ asset('assets/dist/js/demo-theme.min.js?1684106062') }}"></script>

    <div class="d-flex justify-content-center align-items-center full-height">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="animate__animated animate__zoomInDown animate__faster">
                    <div class="empty-header text-teal">
                        429
                    </div>
                    <p class="empty-title">
                        Demasiadas solicitudes
                    </p>
                    <p class="empty-subtitle text-secondary">
                        Lo sentimos, pero has hecho demasiadas solicitudes a nuestros servidores recientemente. Por favor, inténtalo de nuevo más tarde.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/dist/js/tabler.min.js?1720208459') }}" defer=""></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1720208459') }}" defer=""></script>

    <script>
        document.getElementById('backButton').addEventListener('click', function(event) {
            event.preventDefault();
            var url = this.href;

            fetch('/validate-url?url=' + encodeURIComponent(url))
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        window.location.href = url;
                    } else {
                        console.error('Error:', data.message);
                        window.location.href = '/';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = '/';
                });
        });
    </script>

</body>
</html>
