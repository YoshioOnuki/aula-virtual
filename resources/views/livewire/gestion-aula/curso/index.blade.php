<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    @if (session('tipo_vista') === 'alumno')
                                        Mis Cursos
                                    @elseif(session('tipo_vista') === 'docente')
                                        Carga Académica
                                    @endif
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        @if (session('tipo_vista') === 'alumno')
                            Mis Cursos
                        @elseif(session('tipo_vista') === 'docente')
                            Carga Académica
                        @endif
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-info bg-info-lt m-0 mb-3 animate__animated animate__fadeIn animate__faster">
                <strong>Nota Importante: </strong> El progreso en el curso se calcula según trabajos académicos, participación en foros y asistencias.
            </div>
            {{-- @if (session('modo') === 'create' || session('modo') === 'edit')
                <div wire:init="mostrar_toast"></div>
            @endif --}}
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select form-select-sm">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="ms-auto text-secondary">
                                    Buscar:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice" placeholder="Buscar...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="container-xl my-2">
                                <div class="row row-cards d-flex justify-content-start ">

                                    @forelse ($cursos as $item)
                                        <div class="col-sm-4 col-lg-4 col-xl-3 p-xl-2 p-lg-1 p-2">
                                            <div class="card card-sm hover-shadow custom-card">
                                                <div class="img-responsive img-responsive-16x9 card-img-top"
                                                    style="background-image: url('{{ $item->gestionAula->fondo_gestion_aula ?? '/media/fondo-cursos/fondo-infor.webp' }}'); cursor: pointer;" wire:click="curso_detalle({{ $item->id_gestion_aula_usuario }})">
                                                </div>

                                                <div class="card-avatar avatar avatar-smm rounded-circle">
                                                    <img src="{{ $foto_docente[$item->gestionAula->id_gestion_aula] }}"
                                                        alt="avatar">
                                                </div>

                                                <div class="card-body">
                                                    <div style="cursor: pointer;" wire:click="curso_detalle({{ $item->id_gestion_aula_usuario }})">
                                                        <div class="d-flex align-items-center" style="height: 75px;">
                                                            <div>
                                                                <div class="text-muted">{{ $item->gestionAula->curso->codigo_curso }}</div>
                                                                <div>{{ $item->gestionAula->curso->nombre_curso }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        @if(!empty($numero_progreso[$item->id_gestion_aula_usuario]))
                                                            <div class="d-flex mb-1 mt-2">
                                                                <div class="text-muted fs-5">
                                                                    Progreso: {{ $numero_progreso_realizados[$item->id_gestion_aula_usuario] ?? '0' }}/{{ $numero_progreso[$item->id_gestion_aula_usuario] ?? '0' }}
                                                                </div>
                                                                <div class="ms-auto fs-5">
                                                                    <span class="text-muted d-inline-flex align-items-center lh-1">
                                                                        {{ $progreso[$item->id_gestion_aula_usuario] ?? '0' }}%
                                                                    </span>
                                                                </div>
                                                            </div>
            
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-{{ colorPorcentaje($progreso[$item->id_gestion_aula_usuario] ?? 0) }}"
                                                                    style="width: {{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}%" role="progressbar" aria-valuenow="{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}"
                                                                    aria-valuemin="0" aria-valuemax="100" aria-label="{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}% Complete">
                                                                    <span class="visually-hidden">{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}% Complete</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="d-flex mb-1 mt-2">
                                                                <div class="text-muted fs-5">
                                                                </div>
                                                                <div class="ms-auto fs-5">
                                                                    <span class="text-muted d-inline-flex align-items-center lh-1">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-sm">
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="d-flex align-items-center mt-3">
                                                        <div class="ms-auto">
                                                            <a class="text-muted text-decoration-none"
                                                                data-bs-toggle="tooltip" data-bs-placement="left" 
                                                                title="informacion del cursooo">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                    <path d="M12 9h.01" />
                                                                    <path d="M11 12h1v4h1" />
                                                                </svg>
                                                            </a>
                                                            <a class="ms-2 text-muted text-decoration-none"
                                                                style="cursor: pointer;" wire:click="curso_favorito({{ $item->id_gestion_aula_usuario }})">
                                                                @if($item->favorito_gestion_aula_usuario == 0)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-star">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path
                                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                                    </svg>
                                                                @elseif($item->favorito_gestion_aula_usuario == 1)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="#f59f00"
                                                                        class="icon icon-tabler icons-tabler-filled icon-tabler-star">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path
                                                                            d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                                                                    </svg>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-muted">
                                                    @if (session('tipo_vista') === 'alumno')
                                                        No tiene cursos asignados.
                                                    @elseif(session('tipo_vista') === 'docente')
                                                        No tiene carga académica.
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div wire:ignore.self class="modal" id="modal-asignar-usuario" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-2 text-center">
                                @if ($avatar)
                                    <img src="{{ $avatar->temporaryUrl() }}" alt="avatar"
                                        class="avatar avatar-lg">
                                @elseif ($avatar_temp)
                                    <img src="{{ asset($avatar_temp) }}" alt="avatar" class="avatar avatar-lg">
                                @else
                                    @php
                                        $persona = App\Models\Persona::find($persona_id);
                                    @endphp
                                    @if ($persona)
                                        <img src="{{ asset($persona->avatar) }}" alt="avatar"
                                            class="avatar avatar-lg ">
                                    @endif
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="correo_electronico" class="form-label required">
                                    Correo electrónico
                                </label>
                                <input type="email"
                                    class="form-control @error('correo_electronico') is-invalid @enderror"
                                    id="correo_electronico" wire:model.live="correo_electronico"
                                    placeholder="Ingrese su correo electrónico" />
                                @error('correo_electronico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="contraseña"
                                    class="form-label @if ($modo == 'create') required @endif">
                                    Contraseña
                                </label>
                                <input type="password" class="form-control @error('contraseña') is-invalid @enderror"
                                    id="contraseña" wire:model.live="contraseña"
                                    placeholder="Ingrese su contraseña" />
                                @error('contraseña')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="confirmar_contraseña"
                                    class="form-label @if ($modo == 'create') required @endif">
                                    Confirmación de Contraseña
                                </label>
                                <input type="password"
                                    class="form-control @error('confirmar_contraseña') is-invalid @enderror"
                                    id="confirmar_contraseña" wire:model.live="confirmar_contraseña"
                                    placeholder="Ingrese su confirmación de contraseña" />
                                @error('confirmar_contraseña')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="rol" class="form-label required">
                                    Rol
                                </label>
                                <select type="password" class="form-select @error('rol') is-invalid @enderror"
                                    id="rol" wire:model.live="rol">
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->rol_id }}">{{ $item->rol_nombre }}</option>
                                    @endforeach
                                </select>
                                @error('rol')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="avatar" class="form-label">
                                    Avatar
                                </label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                    id="avatar" wire:model.live="avatar" accept="image/*" />
                                @error('avatar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <div class="form-label">Estado</div>
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input @error('estado') is-invalid @enderror"
                                            type="checkbox" wire:model.live="estado">
                                        <span class="form-check-label">Activo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (auth()->user()->permiso('persona-delete-usuario'))
                            @if ($modo == 'edit')
                                <div>
                                    <button type="button" wire:click="eliminar_usuario({{ $persona_id }})"
                                        wire:confirm="¿Quieres eliminar este usuario?"
                                        class="btn btn-danger">
                                        Eliminar
                                    </button>
                                </div>
                            @endif
                        @endif
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            {{ $boton_modal }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</div>
