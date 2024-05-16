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
                <span class="text-uppercase text-teal
                " style="font-weight: 800; font-size: 1.2rem;">
                    AULA VIRTUAL
                </span>
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a style="cursor: pointer;" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <img src="{{ asset($usuario->foto ?? 'media/avatar-none.webp') }}" alt="avatar"
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
                <img src="{{ asset($usuario->foto ?? 'media/avatar-none.webp') }}" alt="avatar"
                    class="avatar avatar-lg ms-3">
                <span class="fw-bold fs-3 mt-3 text-center ms-3 hide-theme-dark">
                    {{ $nombre }}
                </span>
                <span class="fw-bold fs-3 mt-3 text-center ms-3 text-white hide-theme-light">
                    {{ $nombre }}
                </span>
                <div class="mt-3 w-full ps-3">
                    <span class="badge bg-teal-lt px-3 py-2 w-100">
                        {{ $usuario->rol->nombre_rol }}
                    </span>
                </div>
            </div>
            <ul class="navbar-nav pt-lg-3">

                <hr class="ms-lg-3 mt-2 mb-3 hide-theme-dark">
                <hr class="ms-lg-3 mt-2 mb-3 hide-theme-light text-white">

                <li class="nav-item {{ request()->routeIs('inicio') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('inicio') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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

                {{-- <li class="nav-item {{ request()->routeIs('perfil*') ? 'active' : '' }}"> --}}
                <li class="nav-item">
                    {{-- <a class="nav-link" href="{{ route('perfil', ['usuario_id' => auth()->user()->usuario_id]) }}"> --}}
                    <a class="nav-link" href="">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon " width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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

                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-dark">
                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-light text-white">

                {{-- <li class="nav-item {{ request()->routeIs('empleados*') ? 'active' : '' }}"> --}}
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('inicio') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-books">
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

                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-dark">
                <hr class="ms-lg-3 mt-3 mb-3 hide-theme-light text-white">

                {{-- <li class="nav-item {{ request()->routeIs('modalidades*') ? 'active' : '' }}"> --}}
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('inicio') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
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
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('inicio') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
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
                <button type="button" class="btn btn-danger w-100 mt-2 mb-lg-5" wire:click="logout">
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
