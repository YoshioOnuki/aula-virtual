<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn  ">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Autoridades</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Autoridades
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn  ">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary row">
                                    <div class="col-lg-7 col-9">
                                        <div class="d-inline-block">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                placeholder="Buscar">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-3 d-flex justify-content-end">
                                        <a href="" class="btn btn-primary d-none d-md-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            Crear Autoridad
                                        </a>
                                        <a href="" class="btn btn-primary d-md-none btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Autoridad</th>
                                        <th class="col-2">Estado</th>
                                        <th class="col-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = $autoridades->count() ?? 0;
                                    @endphp
                                    @forelse ($autoridades as $item)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">
                                                {{ $i-- }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="form-selectgroup-label-content d-flex align-items-start">
                                                <img src="{{ asset($item->mostrar_foto ?? '/media/avatar-none.webp') }}"
                                                    alt="avatar" class="avatar me-3 rounded avatar-static">
                                                <div>
                                                    <div class="fs-3">{{ $item->nombre_autoridad }}</div>
                                                    <div class="text-muted fs-4">
                                                        {{ $item->cargo->nombre_cargo }}
                                                        {{ $item->facultad ? 'de la ' . $item->facultad->nombre_facultad
                                                        : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->estado_autoridad == 1)
                                            <a wire:click="abrir_modal_estado({{ $item->id_autoridad }}, 0)"
                                                class="text-decoration-none cursor-pointer">
                                                <span class="badge bg-teal-lt status-teal px-3 py-2 fs-4">
                                                    <span class="status-dot status-dot-animated me-2"></span>
                                                    Activo
                                                </span>
                                            </a>
                                            @elseif ($item->estado_usuario == 0)
                                            <a wire:click="abrir_modal_estado({{ $item->id_autoridad }}, 1)"
                                                class="text-decoration-none cursor-pointer">
                                                <span class="badge bg-red-lt status-red px-3 py-2 fs-4">
                                                    <span class="status-dot status-dot-animated me-2"></span>
                                                    Inactivo
                                                </span>
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Acciones
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" style="cursor: pointer;">
                                                            Editar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    @if ($autoridades->count() == 0 && $search != '')
                                    <tr>
                                        <td colspan="9">
                                            <div class="text-center" style="padding-bottom: 2rem; padding-top: 2rem;">
                                                <span class="text-secondary">
                                                    No se encontraron resultados para
                                                    "<strong>{{ $search }}</strong>"
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="9">
                                            <div class="text-center" style="padding-bottom: 2rem; padding-top: 2rem;">
                                                <span class="text-secondary">
                                                    No hay usuarios registrados
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer {{ $autoridades->hasPages() ? 'py-0' : '' }}">
                            @if ($autoridades->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $autoridades->firstItem() }} - {{ $autoridades->lastItem() }} de
                                    {{ $autoridades->total() }} registros
                                </div>
                                <div class="mt-3">
                                    {{ $autoridades->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $autoridades->firstItem() }} - {{ $autoridades->lastItem() }} de
                                    {{ $autoridades->total() }} registros
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modal-estado-autoridad" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="cambiar_estado">
                    <div class="modal-status bg-{{ $modo === 1 ? 'teal' : 'red' }}"></div>
                    <div class="modal-body px-6">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-2 text-center">
                                @if($modo === 1)
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#0ca678" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open svg-extra-large my-6">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                    <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M8 11v-5a4 4 0 0 1 8 0" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="#d63939"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-lock svg-extra-large my-6">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 2a5 5 0 0 1 5 5v3a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3v-3a5 5 0 0 1 5 -5m0 12a2 2 0 0 0 -1.995 1.85l-.005 .15a2 2 0 1 0 2 -2m0 -10a3 3 0 0 0 -3 3v3h6v-3a3 3 0 0 0 -3 -3" />
                                </svg>
                                @endif
                            </div>
                            <div class="col-lg-12 mt-2 text-center">
                                <h4 class="text-center fs-3">
                                    ¿Estas seguro?
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-yellow bg-yellow-lt hover-shadow-sm" role="alert">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="#f59f00"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-bell-ringing">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17.451 2.344a1 1 0 0 1 1.41 -.099a12.05 12.05 0 0 1 3.048 4.064a1 1 0 1 1 -1.818 .836a10.05 10.05 0 0 0 -2.54 -3.39a1 1 0 0 1 -.1 -1.41z" />
                                                <path
                                                    d="M5.136 2.245a1 1 0 0 1 1.312 1.51a10.05 10.05 0 0 0 -2.54 3.39a1 1 0 1 1 -1.817 -.835a12.05 12.05 0 0 1 3.045 -4.065z" />
                                                <path
                                                    d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" />
                                                <path
                                                    d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title text-dark">¡Alerta!</h4>
                                            <div class="text-dark">
                                                Estás a punto de <strong>{{ $accion_estado }}</strong> a la autoridad.
                                                Esto {{ $modo === 1 ? 'permitirá' : 'restringirá' }} su visualización en
                                                el sistema.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <ul style="list-style-type: none;">
                                    <li class="mb-2">
                                        <strong>Autoridad:</strong>
                                        <span class="text-secondary">{{ $nombres_autoridad }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Cargo:</strong>
                                        <span class="text-secondary">{{ $cargo_autoridad }}</span>
                                    </li>
                                    @if($facultad_autoridad)
                                    <li class="">
                                        <strong>Facultad:</strong>
                                        <span class="text-secondary">{{ $facultad_autoridad }}</span>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal">
                            Cancelar
                        </a>

                        <div class="ms-auto">
                            <div wire:loading.remove>
                                <button type="submit" class="btn btn-{{ $modo === 1 ? 'teal' : 'red' }}">
                                    @if($modo === 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                        <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M8 11v-5a4 4 0 0 1 8 0" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="#ffffff" class="icon icon-tabler icons-tabler-filled icon-tabler-lock">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 2a5 5 0 0 1 5 5v3a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3v-3a5 5 0 0 1 5 -5m0 12a2 2 0 0 0 -1.995 1.85l-.005 .15a2 2 0 1 0 2 -2m0 -10a3 3 0 0 0 -3 3v3h6v-3a3 3 0 0 0 -3 -3" />
                                    </svg>
                                    @endif
                                    {{ $accion_estado }}
                                </button>
                            </div>
                            <div wire:loading>
                                <button type="submit" class="btn btn-{{ $modo === 1 ? 'teal' : 'red' }}" disabled>
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
