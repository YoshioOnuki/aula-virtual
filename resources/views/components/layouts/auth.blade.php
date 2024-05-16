<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'Login - Aula Virtual' }}</title>

    <link rel="shortcut icon" href="{{ asset('/media/logo-unu.webp') }}" type="image/x-icon">

    <link href="{{ asset('assets/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
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
    </style>
    <script src="{{ asset('assets/dist/libs/jsvectormap/dist/maps/world.js?1695847769') }}" defer></script>
    <script src="{{ asset('assets/dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062') }}" defer></script>
    <script src="{{ asset('assets/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1684106062') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>

<body class="d-flex flex-column">
    <script src="{{ asset('assets/dist/js/demo-theme.min.js?1684106062') }}"></script>

    {{ $slot }}

    <script>
        document.addEventListener('livewire:navigated', () => {
            var notyf = new Notyf();
            window.addEventListener('toast-basico', event => {
                if (event.detail.type == 'success') {
                    notyf.success({
                        message: event.detail.mensaje,
                        duration: 5000,
                        position: {
                            x: 'center',
                            y: 'top',
                        },
                        dismissible: true
                    });
                } else {
                    notyf.error({
                        message: event.detail.mensaje,
                        duration: 5000,
                        position: {
                            x: 'center',
                            y: 'top',
                        },
                        dismissible: true
                    });
                }
            })

            window.addEventListener('modal', event => {
                $(event.detail.modal).modal(event.detail.action)
            })
        })
    </script>
</body>

</html>
