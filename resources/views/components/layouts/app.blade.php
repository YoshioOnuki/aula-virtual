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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    @livewireStyles

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

        /* Para fondo claro */
        .page-wrapper.light-mode {
            background-image: url('{{ asset('/media/fondo-aula-virtual.webp') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Para fondo oscuro */
        .page-wrapper.dark-mode {
            background-image: url('{{ asset('/media/fondo-aula-virtual-dark.webp') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>

    <script>
        window.addEventListener('load', () => {
            const loadingScreen = document.querySelector('.loading-screen');
            if (loadingScreen) {
                loadingScreen.classList.add('hidden'); // Añadir clase `hidden` para transición (si tienes alguna animación)
                setTimeout(() => {
                    loadingScreen.remove(); // Eliminar completamente el elemento del DOM
                }, 500); // Ajusta el tiempo si tienes animación en `.hidden`
            }
        });
    </script>


    <!-- Tabler Core -->
    <script src="{{ asset('assets/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1684106062') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="{{ asset('assets/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('js/mobile-detect/mobile-detect.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

</head>

<body class="layout-fluid">
    <script src="{{ asset('assets/dist/js/demo-theme.min.js?1684106062') }}"></script>

    @if (request()->routeIs('inicio') || request()->routeIs('dashboard'))
        <div class="page page-center cursor-progress loading-screen">
            <div class="container container-slim py-4 d-flex justify-content-center align-items-center">
                <div class="text-center" style="width: 256px;">
                    <div class="mb-3">
                        <div class="navbar-brand navbar-brand-autodark">
                            <img src="{{ asset('/media/logo-pg.webp') }}"
                                height="150" alt="Logo Posgrado">
                        </div>
                    </div>
                    <div class="text-muted mb-3">Preparando la aplicación</div>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate bg-teal"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="page">

        <livewire:components.navegacion.sidebar />

        <livewire:components.navegacion.navbar />

        <div class="page-wrapper"
            style="
                background-image: url('{{ asset('/media/fondo-aula-virtual.webp') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            ">

            {{ $slot }}

            <footer class="footer border-top d-print-none py-3">
                <div class="container-xl">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="#" class="footer-link">
                                Aula Virtual
                            </a>
                            <span class="ms-1">
                                &copy; {{ date('Y') }} - Todos los derechos reservados
                            </span>
                        </div>
                        <div>
                            Universidad Nacional de Ucayali - Escuela de Postgrado
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            // Configuración inicial de Notyf
            var notyf = new Notyf({
                duration: 6000, // Duración predeterminada de la notificación
                position: {x: 'center', y: 'top'}, // Posición predeterminada
                dismissible: true, // Hacer todas las notificaciones descartables
                types: [
                {
                    type: 'info',
                    background: '#4299e1', // Color personalizado para info
                    icon: {
                        tagName: 'i',
                        text: ''
                    }
                },
                {
                    type: 'warning',
                    background: '#f59f00', // Color personalizado para warning
                    icon: {
                        tagName: 'i',
                        text: ''
                    }
                }
            ]
            });

            // Función para mostrar notificaciones
            function mostrarNotificacion(tipo, mensaje) {
                if (tipo === 'success') {
                    notyf.success({message: mensaje});
                } else if (tipo === 'error') {
                    notyf.error({message: mensaje});
                } else if (tipo === 'info') {
                    notyf.open({type: 'info', message: mensaje});
                } else if (tipo === 'warning') {
                    notyf.open({type: 'warning', message: mensaje});
                }
            }

            // Listener para eventos de notificación
            window.addEventListener('toast-basico', event => {
                notyf.dismissAll();
                mostrarNotificacion(event.detail.type, event.detail.mensaje);
            });

            window.addEventListener('modal', event => {
                $(event.detail.modal).modal(event.detail.action)
            })

        });
    </script>

    @livewireScripts

</body>

</html>
