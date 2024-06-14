<aside class="navbar navbar-vertical navbar-expand-lg">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand">
            <a href="{{ route('inicio') }}" class="d-flex align-items-center justify-content-center gap-2">
                <img src="{{ asset('/media/logo-pg.webp') }}" height="45" alt="Logo Posgrado"
                    class="rounded hide-theme-dark">
                <img src="{{ asset('/media/logo-pg.webp') }}" height="45" alt="Logo Posgrado"
                    class="rounded hide-theme-light">
                <span class="text-uppercase 
                " style="font-weight: 800; font-size: 1.2rem;">
                    POSGRADO
                </span>
            </a>
            <span class="badge bg-blue-lt fs-6">v1.0</span>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a style="cursor: pointer;" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <img src="{{ asset($usuario->mostrarFoto('usuario') ?? '/media/avatar-none.webp') }}" alt="avatar"
                        class="avatar avatar-sm">
                    <div class="d-none d-xl-block ps-2">
                        {{ $nombre }}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" wire:click="logout" style="cursor: pointer;">
                        Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse w-100" id="sidebar-menu">
            <div class="d-flex justify-content-center mt-3 flex-column align-items-center">
                <img src="{{ asset($usuario->mostrarFoto('usuario') ?? '/media/avatar-none.webp') }}" alt="avatar"
                    class="avatar avatar-lg ms-3">
                <span class="fw-bold fs-3 mt-3 text-center ms-3 hide-theme-dark">
                    {{ $nombre }}
                </span>
                <span class="fw-bold fs-3 mt-3 text-center ms-3 text-white hide-theme-light">
                    {{ $nombre }}
                </span>
                <div class="mt-3 w-full ps-3">
                    <span class="badge bg-teal-lt px-3 py-2 w-100">
                        {{ $usuario->mostrarRol() }}
                    </span>
                </div>
            </div>
            <ul class="navbar-nav pt-lg-3">

                <hr class="ms-lg-3 mt-2 mb-3 hide-theme-dark">
                <hr class="ms-lg-3 mt-2 mb-3 hide-theme-light text-white">

                <li class="nav-item {{ request()->routeIs('inicio*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('inicio*') ? 'text-primary fw-medium' : '' }}" href="{{ route('inicio') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="{{ request()->routeIs('inicio*') ? '#206bc4' : 'currentColor' }}" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title hide-theme-dark">
                            Inicio
                        </span>
                        <span class="nav-link-title hide-theme-light text-white">
                            Inicio
                        </span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('perfil*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('perfil*') ? 'text-primary fw-medium' : '' }}" style="cursor: pointer;" wire:click="mostrar_perfil">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon " width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="{{ request()->routeIs('perfil*') ? '#206bc4' : 'currentColor' }}" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                                <path d="M10 16h6" />
                                <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M4 8h3" />
                                <path d="M4 12h3" />
                                <path d="M4 16h3" />
                            </svg>
                        </span>
                        <span class="nav-link-title hide-theme-dark">
                            Perfil
                        </span>
                        <span class="nav-link-title hide-theme-light text-white">
                            Perfil
                        </span>
                    </a>
                </li>

                @if ($usuario->esRol('ADMINISTRADOR'))
                    <li
                        class="nav-item {{ request()->routeIs('usuarios*') || request()->routeIs('proceso*') || request()->routeIs('registro-alumnos*') || request()->routeIs('autoridades*') ? 'active' : '' }} dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('usuarios*') || request()->routeIs('proceso*') || request()->routeIs('registro-alumnos*') || request()->routeIs('autoridades*') ? 'text-primary fw-medium' : '' }}" href="#navbar-layout" data-bs-toggle="dropdown"
                            data-bs-auto-close="false" role="button" aria-expanded="true">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="{{ request()->routeIs('usuarios*') || request()->routeIs('proceso*') || request()->routeIs('registro-alumnos*') || request()->routeIs('autoridades*') ? '#206bc4' : 'currentColor' }}" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                    </path>
                                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Configuración
                            </span>
                        </a>
                        <div
                            class="dropdown-menu {{ request()->routeIs('usuarios*') || request()->routeIs('proceso*') || request()->routeIs('registro-alumnos*') || request()->routeIs('autoridades*') ? 'show' : '' }}">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item {{ request()->routeIs('usuarios') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_usuarios">
                                        Usuarios
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('registro-alumnos') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_registro_alumnos">
                                        Registrar Alumnos
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('autoridades') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_autoridades">
                                        Autoridades
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <hr class="ms-lg-3 mt-3 mb-3 hide-theme-dark">
                    <hr class="ms-lg-3 mt-3 mb-3 hide-theme-light text-white">

                    <li
                        class="nav-item {{ request()->routeIs('estructura-academica*') ? 'active' : '' }} dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('estructura-academica*') ? 'text-primary fw-medium' : '' }}" href="#navbar-layout" data-bs-toggle="dropdown"
                            data-bs-auto-close="false" role="button" aria-expanded="true">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('estructura-academica*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-topology-star-ring-3">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 19a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M18 5a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M10 5a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M6 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M18 19a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M14 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M22 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z" />
                                    <path d="M6 12h4" />
                                    <path d="M14 12h4" />
                                    <path d="M15 7l-2 3" />
                                    <path d="M9 7l2 3" />
                                    <path d="M11 14l-2 3" />
                                    <path d="M13 14l2 3" />
                                    <path d="M10 5h4" />
                                    <path d="M10 19h4" />
                                    <path d="M17 17l2 -3" />
                                    <path d="M19 10l-2 -3" />
                                    <path d="M7 7l-2 3" />
                                    <path d="M5 14l2 3" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Estructura Académica
                            </span>
                        </a>
                        <div
                            class="dropdown-menu {{ request()->routeIs('estructura-academica*') ? 'show' : '' }}">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item {{ request()->routeIs('estructura-academica.nivel-academico') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_nivel_academico">
                                        Nivel Académico
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('estructura-academica.tipo-programa') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_tipo_programa">
                                        Tipo de Programa
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('estructura-academica.facultad') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_facultad">
                                        Facultad
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('estructura-academica.programa') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_programa">
                                        Programa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('gestion-curso*') ? 'active' : '' }} dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('gestion-curso*') ? 'text-primary fw-medium' : '' }}" href="#navbar-layout" data-bs-toggle="dropdown"
                            data-bs-auto-close="false" role="button" aria-expanded="true">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('gestion-curso*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-books">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                    <path d="M5 8h4" />
                                    <path d="M9 16h4" />
                                    <path
                                        d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                                    <path d="M14 9l4 -1" />
                                    <path d="M16 16l3.923 -.98" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Gestión del curso
                            </span>
                        </a>
                        <div
                            class="dropdown-menu {{ request()->routeIs('gestion-curso.*') ? 'show' : '' }}">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item {{ request()->routeIs('gestion-curso.plan-estudio') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_plan_estudio">
                                        Plan de estudios
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('gestion-curso.ciclo') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_ciclo">
                                        Ciclo
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('gestion-curso.proceso') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_proceso">
                                        Proceso
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('gestion-curso.curso') ? 'active fw-medium' : '' }}"
                                        style="cursor: pointer;" wire:click="mostrar_curso">
                                        Curso
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif

                @if ($usuario->esRol('ALUMNO') || $usuario->esRol('DOCENTE') || $usuario->esRol('DOCENTE INVITADO'))
                    <hr class="ms-lg-3 mt-3 mb-3 hide-theme-dark">
                    <hr class="ms-lg-3 mt-3 mb-3 hide-theme-light text-white">


                    @if ($usuario->esRol('ALUMNO'))
                        <li class="nav-item {{ request()->routeIs('cursos*') ? 'active' : '' }}">
                            <a class="nav-link {{ request()->routeIs('cursos*') ? 'text-primary fw-medium' : '' }}" style="cursor: pointer;" wire:click="mostrar_cursos">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('cursos*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-books">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                        <path
                                            d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                        <path d="M5 8h4" />
                                        <path d="M9 16h4" />
                                        <path
                                            d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                                        <path d="M14 9l4 -1" />
                                        <path d="M16 16l3.923 -.98" />
                                    </svg>
                                </span>
                                <span class="nav-link-title hide-theme-dark">
                                    Mis cursos
                                </span>
                                <span class="nav-link-title hide-theme-light text-white">
                                    Mis cursos
                                </span>
                            </a>
                        </li>
                    @endif

                    @if ($usuario->esRol('DOCENTE') || $usuario->esRol('DOCENTE INVITADO'))
                        <li class="nav-item {{ request()->routeIs('carga-academica*') ? 'active' : '' }}">
                            <a class="nav-link {{ request()->routeIs('carga-academica*') ? 'text-primary fw-medium' : '' }}" style="cursor: pointer;" wire:click="mostrar_carga_academica">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('carga-academica*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-chalkboard">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1" />
                                        <path
                                            d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title hide-theme-dark">
                                    Carga académica
                                </span>
                                <span class="nav-link-title hide-theme-light text-white">
                                    Carga académica
                                </span>
                            </a>
                        </li>
                    @endif
                @endif

                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-dark">
                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-light text-white">

                @if ($usuario->esRol('ALUMNO'))
                    <li class="nav-item {{ request()->routeIs('calificaciones*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('calificaciones*') ? 'text-primary fw-medium' : '' }}" style="cursor: pointer;" wire:click="mostrar_calificaciones">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('calificaciones*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                    <path d="M14 19l2 2l4 -4" />
                                    <path d="M9 8h4" />
                                    <path d="M9 12h2" />
                                </svg>
                            </span>
                            <span class="nav-link-title hide-theme-dark">
                                Calificaciones
                            </span>
                            <span class="nav-link-title hide-theme-light text-white">
                                Calificaciones
                            </span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('plan-estudio*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('plan-estudio*') ? 'text-primary fw-medium' : '' }}" style="cursor: pointer;" wire:click="mostrar_plan_estudio">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('plan-estudio*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 5h8" />
                                    <path d="M13 9h5" />
                                    <path d="M13 15h8" />
                                    <path d="M13 19h5" />
                                    <path
                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                </svg>
                            </span>
                            <span class="nav-link-title hide-theme-dark">
                                Plan de estudios
                            </span>
                            <span class="nav-link-title hide-theme-light text-white">
                                Plan de estudios
                            </span>
                        </a>
                    </li>
                @endif

                <li class="nav-item {{ request()->routeIs('manuales*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('manuales*') ? 'text-primary fw-medium' : '' }}" style="cursor: pointer;" wire:click="mostrar_manuales">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('manuales*') ? '#206bc4' : 'currentColor' }}" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M9 9l1 0" />
                                <path d="M9 13l6 0" />
                                <path d="M9 17l6 0" />
                            </svg>
                        </span>
                        <span class="nav-link-title hide-theme-dark">
                            Manuales
                        </span>
                        <span class="nav-link-title hide-theme-light text-white">
                            Manuales
                        </span>
                    </a>
                </li>

                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-dark">
                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-light text-white">

            </ul>
            <div class="mt-2 mb-4 mb-lg-0 w-full ps-3">
                <button type="button" class="btn btn-outline-red w-100 mt-2 mb-lg-5" wire:click="logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-left"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 12l10 0"></path>
                        <path d="M10 12l4 4"></path>
                        <path d="M10 12l4 -4"></path>
                        <path d="M4 4l0 16"></path>
                    </svg>
                    Cerrar sesión
                </button>
            </div>
        </div>
    </div>
</aside>
