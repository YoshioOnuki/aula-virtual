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

                            @if ($tipo_vista === 'cursos')
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">
                                        Alumnos
                                    </a>
                                </li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">
                                        Docentes
                                    </a>
                                </li>
                            @endif
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        @if ($tipo_vista === 'cursos')
                            Alumnos
                        @else
                            Docentes
                        @endif
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body border-bottom py-3">
                            <div class="alert alert-azure bg-azure-lt" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                            <path d="M12 9h.01"></path>
                                            <path d="M11 12h1v4h1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="alert-title">¡Guía rápida para buscar {{ $tipo_vista === 'cursos' ? 'Alumnos' : 'Docentes' }}!</h4>
                                        <div class="text-secondary">
                                            <strong>
                                                Puede buscar un {{ $tipo_vista === 'cursos' ? 'Alumnos' : 'Docentes' }} por los siguientes criterios:
                                            </strong>
                                        </div>
                                        <div class="text-secondary">
                                            <ul>
                                                <li>Nombre completo</li>
                                                <li>Número de documento</li>
                                                @if ($tipo_vista === 'cursos')
                                                    <li>Código de alumno</li>
                                                @endif
                                                <li>Usuario</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                    <div class="w-100">
                                        <input type="text" class="form-control"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                            placeholder="Buscar {{ $tipo_vista === 'cursos' ? 'Alumnos' : 'Docentes' }}">
                                    </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        @if($tipo_vista === 'cursos')
                                            <th class="col-1">Código</th>
                                            <th>Alumno</th>
                                        @else
                                            <th>Docente</th>
                                        @endif
                                        <th>Usuario</th>
                                        <th>Última acción</th>
                                        <th class="col-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($usuarios as $item)
                                        <tr>
                                            @if($tipo_vista === 'cursos')
                                                <td>
                                                    {{ $item->persona->codigo_alumno_persona ?? 'N/A'}}
                                                </td>
                                            @endif
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    @if($tipo_vista === 'cursos')
                                                        <img src="{{ asset($item->mostrarFoto('alumno')) }}" alt="avatar" class="avatar me-2">
                                                    @else
                                                        <img src="{{ asset($item->mostrarFoto('docente')) }}" alt="avatar" class="avatar me-2">
                                                    @endif
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">
                                                            {{ $item->nombre_completo }}
                                                        </div>
                                                        <div>
                                                            <a href="#" class="text-reset">
                                                                {{ $item->persona->documento_persona }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->correo_usuario }}
                                            </td>
                                            <td>
                                                @if($item->id_accion_usuario === null && $item->ultima_accion_usuario === null)
                                                    <span class="text-red">
                                                        Nunca inició sesión
                                                    </span>
                                                @else
                                                    "{{ $item->accionUsuario->nombre_accion }}" <br>
                                                    {{ ultima_conexion($item->ultima_accion_usuario) }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Acciones
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @if($tipo_vista === 'carga-academica')
                                                                <a class="dropdown-item" style="cursor: pointer;"
                                                                    href="{{ route('carga-academica', ['id_usuario' => Hashids::encode($item->id_usuario), 'tipo_vista' => $tipo_vista]) }}">
                                                                    Carga académica
                                                                </a>
                                                            @elseif($tipo_vista === 'cursos')
                                                                <a class="dropdown-item" style="cursor: pointer;"
                                                                    href="{{ route('carga-academica', ['id_usuario' => Hashids::encode($item->id_usuario), 'tipo_vista' => $tipo_vista]) }}">
                                                                    Cursos
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($usuarios->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="6">
                                                    <div class="text-center"
                                                        style="padding-bottom: 2rem; padding-top: 2rem;">
                                                        <span class="text-secondary">
                                                            No se encontraron resultados para
                                                            "<strong>{{ $search }}</strong>"
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <div class="text-center"
                                                        style="padding-bottom: 2rem; padding-top: 2rem;">
                                                        <span class="text-secondary">
                                                            Busca un {{ $tipo_vista === 'cursos' ? 'Alumno' : 'Docente' }}...
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
