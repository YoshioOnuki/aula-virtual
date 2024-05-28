<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Usuarios</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Usuarios
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            {{-- <div wire:init="mostrar_toast"></div> --}}
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            Crear usuario
                                        </a>
                                        <a href="" class="btn btn-primary d-md-none btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
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
                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Persona</th>
                                        <th>Usuario</th>
                                        <th class="col-2">Roles</th>
                                        <th class="col-2">Estado</th>
                                        <th class="col-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse ($usuarios as $item)
                                        <tr>
                                            <td>
                                                <span class="text-secondary">{{ $i++ }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <img src="{{ asset($item->mostrarFoto('alumno')) }}" alt="avatar"
                                                        class="avatar me-2">
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">{{ $item->nombre_completo }}
                                                        </div>
                                                        <div class="text-secondary"><a href="#"
                                                                class="text-reset">{{ $item->persona->documento_persona }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->correo_usuario }}
                                            </td>
                                            <td>
                                                {{ $item->mostrarRol() }}
                                            </td>
                                            <td>
                                                @if ($item->estado_usuario == 1)
                                                    <a style="cursor: pointer;" wire:click="abrir_modal">
                                                        <span class="badge bg-teal-lt status-teal px-3 py-2 fs-4">
                                                            <span class="status-dot status-dot-animated me-2"></span>
                                                            Activo
                                                        </span>
                                                    </a>
                                                @else
                                                    <a style="cursor: pointer;">
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
                                                                Ver
                                                            </a>
                                                            <a class="dropdown-item" style="cursor: pointer;">
                                                                Editar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($usuarios->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="9">
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
                                                <td colspan="9">
                                                    <div class="text-center"
                                                        style="padding-bottom: 2rem; padding-top: 2rem;">
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
                        <div class="card-footer {{ $usuarios->hasPages() ? 'py-0' : '' }}">
                            @if ($usuarios->hasPages())
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $usuarios->firstItem() }} - {{ $usuarios->lastItem() }} de
                                        {{ $usuarios->total() }} registros
                                    </div>
                                    <div class="mt-3">
                                        {{ $usuarios->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $usuarios->firstItem() }} - {{ $usuarios->lastItem() }} de
                                        {{ $usuarios->total() }} registros
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal" id="modal-estado-usuario" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="cambiar_estado">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-2 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-lock">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 2a5 5 0 0 1 5 5v3a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3v-3a5 5 0 0 1 5 -5m0 12a2 2 0 0 0 -1.995 1.85l-.005 .15a2 2 0 1 0 2 -2m0 -10a3 3 0 0 0 -3 3v3h6v-3a3 3 0 0 0 -3 -3" />
                                </svg>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-warning" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 9v4"></path>
                                                <path
                                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                </path>
                                                <path d="M12 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">This is a custom alert box!</h4>
                                            <div class="text-secondary">
                                                <strong>Sorry!</strong> There was a
                                                problem with your request.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-yellow hover-shadow-sm" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 9v4"></path>
                                                <path
                                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                </path>
                                                <path d="M12 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">¡Alerta!</h4>
                                            <div class="text-secondary">
                                                Estás 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                sadas
                            </div>
                            <div class="col-lg-12">
                                
                        </div>
                    </div>
                    <div class="modal-footer">
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
    </div>
</div>
