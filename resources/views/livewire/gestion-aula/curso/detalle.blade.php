<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows
                        " aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inicio') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                @if(session('tipo_vista') == 'alumno')
                                    <a href="{{ route('cursos') }}">Mis Cursos</a>
                                @else
                                    <a href="{{ route('carga-academica') }}">Carga Académica</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Detalle
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        {{ $nombre_curso }} - GRUPO "{{ $grupo_gestion_aula }}"
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if (session('tipo_vista') === 'alumno')
                        <a href="{{ route('cursos')}}" class="btn btn-secondary d-none d-md-inline-block">
                        @else
                        <a href="{{ route('carga-academica') }}" class="btn btn-secondary d-none d-md-inline-block">
                        @endif
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            Regresar
                        </a>
                        <a href="" class="btn btn-secondary d-md-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">

                <div class="col-lg-8">
                    <div class="row g-3">
                        @if(session('tipo_vista') == 'alumno')
                            <div class="col-12" wire:init="load_orientaciones">
                                @if($cargando_orientaciones)
                                    <div class="card card-stacked placeholder-glow">
                                        <div class="card-header bg-teal-lt">
                                            <div class="placeholder col-5 bg-teal" style="height: 1.5rem; width: 217.16px;"></div>
                                        </div>
                                        <div class="card-body px-5">
                                            <div class="placeholder col-12"></div>
                                            <div class="placeholder col-10"></div>
                                            <div class="placeholder col-12"></div>
                                            <div class="placeholder col-11"></div>
                                            <div class="placeholder col-7"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                        <div class="card-header bg-teal-lt">
                                            <span class="text-teal me-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                                    <path d="M9 7l4 0" />
                                                    <path d="M9 11l4 0" />
                                                </svg>
                                            </span>
                                            <h3 class="card-title fw-semibold">Orientaciones Generales</h3>
                                        </div>
                                        <div class="card-body px-5">
                                            @if($orientaciones_generales)
                                                <span style="text-align: justify;">
                                                    {{ $orientaciones_generales }}
                                                </span>
                                            @else
                                                <span class="text-muted" style="text-align: justify;">
                                                    Actualmente no hay orientaciones generales disponibles para este curso.
                                                    Por favor, revisa más tarde o consulta con el <strong>docente</strong>  del curso para más información.
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                                <div class="card-stamp card-stamp-lg">
                                    @if (session('tipo_vista') == 'docente')
                                        <div class="card-stamp-icon bg-orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-align-box-left-middle">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                <path d="M9 15h-2" />
                                                <path d="M13 12h-6" />
                                                <path d="M11 9h-4" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="card-stamp-icon bg-teal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-vocabulary">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z" />
                                                <path d="M12 5v16" />
                                                <path d="M7 7h1" />
                                                <path d="M7 11h1" />
                                                <path d="M16 7h1" />
                                                <path d="M16 11h1" />
                                                <path d="M16 15h1" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex justify-content-center">
                                    <div class="row g-3">
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="" wire:click='mostrar_silabus({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro-info.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Silabus
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode" wire:click='mostrar_silabus({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro-info.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Silabus
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="" wire:click='mostrar_recursos({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-carpeta.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Recursos
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode" wire:click='mostrar_recursos({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-carpeta.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Recursos
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="" wire:click='mostrar_foro({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-foro-discusion.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Foro
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode" wire:click='mostrar_foro({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-foro-discusion.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Foro
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>


                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="" wire:click='mostrar_asistencia({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-matricula.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Asistencia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode" wire:click='mostrar_asistencia({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-matricula.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Asistencia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="" wire:click='mostrar_trabajo_academico({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-curso-por-internet.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Trabajos Académicos
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode" wire:click='mostrar_trabajo_academico({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-curso-por-internet.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Trabajos Académicos
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="" wire:click='mostrar_webgrafia({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-ubicacion-ip.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Webgrafía
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode" wire:click='mostrar_webgrafia({{ $id_gestion_aula_usuario }})'>
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-ubicacion-ip.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Webgrafía
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        @if(session('tipo_vista') == 'docente')
                                            <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                                <span class="hide-theme-dark">
                                                    <div class="">
                                                        <div class="image-button image-button-docente position-relative">
                                                            <img src="/media/icons/icon-link-hipervinculo.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Subir Link de Clases
                                                            </div>
                                                            @if(!$link_clase)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="hide-theme-light">
                                                    <div class="dark-mode">
                                                        <div class="image-button image-button-docente position-relative">
                                                            <img src="/media/icons/icon-link-hipervinculo.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Subir Link de Clases
                                                            </div>
                                                            @if(!$link_clase)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>

                                            <div class="col-6 col-md-2 col-lg-4 col-xl-3" wire:init="load_orientaciones">
                                                <span class="hide-theme-dark">
                                                    <div class="">
                                                        <div class="image-button image-button-docente position-relative" style="z-index: 1;">
                                                            <img src="/media/icons/icon-orien-presentacion2.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Orientaciones Generales
                                                            </div>
                                                            @if(!$orientaciones_generales)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="hide-theme-light">
                                                    <div class="dark-mode">
                                                        <div class="image-button image-button-docente position-relative">
                                                            <img src="/media/icons/icon-orien-presentacion2.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Orientaciones Generales
                                                            </div>
                                                            @if(!$orientaciones_generales)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>

                                            <div class="col-6 col-md-2 col-lg-4 col-xl-3" wire:init="load_orientaciones">
                                                <span class="hide-theme-dark">
                                                    <div class="">
                                                        <div class="image-button image-button-docente" style="z-index: 1;">
                                                            <img src="/media/icons/icon-registro.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Estudiantes
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="hide-theme-light">
                                                    <div class="dark-mode">
                                                        <div class="image-button image-button-docente">
                                                            <img src="/media/icons/icon-registro.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Estudiantes
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-3" wire:init="load_datos_docente">
                        @if($cargando_docente)
                            <div class="col-12">
                                <a class="card card-link card-stacked placeholder-glow">
                                    <div class="card-cover card-cover-blurred text-center">
                                        <div class="avatar avatar-xl placeholder {{ session('tipo_vista') == 'alumno' ? 'bg-teal' : 'bg-orange' }}"></div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="card-title mb-1">
                                            <div class="placeholder col-6" style="height: 19.5px"></div>
                                        </div>
                                        <div class="placeholder bg-secondary col-5" style="height: 17px;"></div>
                                        <div class="mt-2">
                                            <div class="placeholder {{ session('tipo_vista') == 'alumno' ? 'bg-teal' : 'bg-orange' }} col-3" style="height: 17px;"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            @forelse ($docente as $item)
                                <div class="col-12">
                                    <a class="card card-link card-stacked animate__animated animate__fadeIn animate__faster">
                                        <div class="card-cover card-cover-blurred text-center"
                                            style="background-image: url({{ session('tipo_vista') == 'docente' ? config('settings.fondo_detalle_doncente') : config('settings.fondo_detalle_alumno') }})">
                                            @if (session('tipo_vista') == 'docente')
                                                <img src="{{ asset($item->usuario->mostrarFoto('docente')) }}"
                                                    alt="avatar" class="avatar avatar-xl avatar-thumb rounded">
                                            @else
                                                <img src="{{ asset($item->usuario->mostrarFoto('alumno')) }}" alt="avatar"
                                                    class="avatar avatar-xl avatar-thumb rounded">
                                            @endif
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="card-title mb-1">
                                                <span>
                                                    {{ $item->usuario->nombre_completo }}
                                                </span>
                                            </div>
                                            <div class="text-muted">
                                                <span>
                                                    {{ $item->usuario->persona->correo_persona }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <span
                                                    class="badge {{ session('tipo_vista') == 'alumno' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                                                    {{ $item->rol->nombre_rol }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                        <div
                                            class="card-body d-flex flex-column align-items-center text-center text-muted fw-bold">
                                            Sin docente asignado
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        @endif
                    </div>

                    <div class="mt-3" wire:init="load_datos_curso">
                        @if($cargando_datos_curso)
                            <div class="card card-stacked placeholder-glow">
                                <div class="card-header {{ session('tipo_vista') === 'alumno' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                                    <div class="placeholder col-5 {{ session('tipo_vista') === 'alumno' ? 'bg-teal' : 'bg-orange' }}"
                                    style="height: 1.5rem; width: 170.56px;"></div>
                                </div>
                                <div class="card-body row g-3 mb-0">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 148.94px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder bg-secondary" style="height: 17px; width: 148.94px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 117.06px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder bg-secondary" style="height: 17px; width: 43.3px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 122.21px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder col-12 bg-secondary" style="height: 17px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-start">
                                                <div class="row g-2">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder" style="height: 17px; width: 34.20px;"></div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder" style="height: 17px; width: 57.86px;"></div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-end">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder" style="height: 17px; width: 40.07px;"></div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 104.33px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder bg-secondary" style="height: 17px; width: 64.44px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-12 mt-1 mb-2" aria-hidden="true" style="height: 36px;"></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card card-link card-stacked animate__animated animate__fadeIn animate__faster">
                                <div
                                    class="card-header {{ session('tipo_vista') === 'alumno' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                                    <h3 class="card-title fw-semibold">
                                        Información del Curso
                                    </h3>
                                </div>
                                <div class="card-body row g-3 mb-0">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <strong>Programa de
                                                            {{ $curso->programa->tipoPrograma->nombre_tipo_programa }}
                                                        </strong>
                                                    </div>
                                                    <div class="col-12">
                                                        {{ $curso->programa->nombre_programa }}
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($curso->programa->mencion_programa)
                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <strong>Mención:</strong>
                                                    </div>
                                                    <div class="col-12">
                                                        {{ $curso->programa->mencion->nombre_mencion }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <strong>Código del Curso</strong>
                                                    </div>
                                                    <div class="col-12">
                                                        {{ $curso->codigo_curso }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <strong>Nombre del Curso</strong>
                                                    </div>
                                                    <div class="col-12">
                                                        {{ $curso->nombre_curso }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-start">
                                                <div class="row g-2">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <strong>Ciclo</strong>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        {{ numero_a_romano($curso->ciclo->numero_ciclo) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <strong>Créditos</strong>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        {{ $curso->creditos_curso }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-end">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <strong>Horas</strong>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        {{ $curso->horas_lectivas_curso }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <strong>Plan de Estudio</strong>
                                                    </div>
                                                    <div class="col-12">
                                                        {{ $curso->planEstudio->nombre_plan_estudio }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <a class="btn btn-primary w-100 mt-1
                                                    {{ !$gestion_aula_usuario->gestionAula->linkClase ? 'disabled' : '' }}"
                                                    style="cursor: pointer;" wire:click="mostrar_link_clase">
                                                    Link de Clase
                                                </a>
                                                @if(!$gestion_aula_usuario->gestionAula->linkClase)
                                                    <div class="alert alert-azure bg-azure-lt mt-2 fw-bold animate__animated animate__fadeIn animate__faster">
                                                        @if(session('tipo_vista') == 'docente')
                                                            Por favor, cargue el link de la clase para que esté disponible para los estudiantes.
                                                        @else
                                                            Link de la clase pendiente. Consulte con el docente.
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
