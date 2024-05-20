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
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Detalle
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        {{ $curso->nombre_curso }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="row g-3">
                        @forelse ($docente as $item)
                            <div class="col-12">
                                <a class="card card-link" href="#">
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
                                            {{ $item->usuario->nombre_completo }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $item->usuario->persona->correo_persona }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge {{ session('tipo_vista') == 'alumno' ? 'bg-teal-lt' : 'bg-yellow-lt' }}">
                                                {{ $item->rol->nombre_rol }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                    <div class="card-body d-flex flex-column align-items-center text-center text-muted fw-bold">
                                        Sin docente asignado
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-stamp card-stamp-lg">
                            @if (session('tipo_vista') == 'docente')
                                <div class="card-stamp-icon bg-yellow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
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
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
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
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-12  ms-md-8 ms-lg-8 ms-xl-6">
                                    opciones
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
