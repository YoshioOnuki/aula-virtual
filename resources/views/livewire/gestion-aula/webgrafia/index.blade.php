<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header lazy />

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
            <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn  ">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary row">
                                    @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) && $tipo_vista
                                    === 'carga-academica')
                                    <div class="col-lg-7 col-9">
                                        <div class="d-inline-block">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                placeholder="Buscar">
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-12">
                                        <div class="d-inline-block">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                placeholder="Buscar">
                                        </div>
                                    </div>
                                    @endif

                                    @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) && $tipo_vista
                                    === 'carga-academica')
                                    <div class="col-lg-5 col-3 d-flex justify-content-end">
                                        <a class="btn btn-primary d-none d-md-inline-block"
                                            wire:click="abrir_modal_webgrafia_agregar()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            Agregar Webgrafía
                                        </a>
                                        <a class="btn btn-primary d-md-none btn-icon"
                                            wire:click="abrir_modal_webgrafia_agregar()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Descripción</th>
                                        <th>Link</th>
                                        <th class="col-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($webgrafias as $item)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">{{ $i++ }}</span>
                                        </td>
                                        <td>
                                            {{ $item->descripcion_webgrafia }}
                                        </td>
                                        <td>
                                            {{ $item->link_webgrafia }}
                                        </td>
                                        <td>
                                            @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) &&
                                            $tipo_vista === 'carga-academica')
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Acciones
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" style="cursor: pointer;"
                                                            wire:click="redirect_link({{ $item->id_webgrafia }})">
                                                            Ir al link
                                                        </a>
                                                        <a class="dropdown-item" style="cursor: pointer;"
                                                            wire:click="abrir_modal_webgrafia_editar({{ $item->id_webgrafia }})">
                                                            Editar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @else

                                            <div x-data="{ link: '{{ $item->link_webgrafia }}' }">
                                                <div x-data="{
                                                link: '{{ $item->link_webgrafia ? $item->link_webgrafia : '' }}',
                                                handleClick() {
                                                    if (!this.link) {
                                                        this.$dispatch('toast-basico', {
                                                            mensaje: 'El link de la webgrafía no está disponible',
                                                            type: 'error'
                                                        });
                                                    } else {
                                                        window.open(this.link, '_blank');
                                                    }
                                                }
                                            }">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        @click="handleClick">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M9 15l6 -6" />
                                                            <path
                                                                d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                                            <path
                                                                d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                                        </svg>
                                                        Ir al link
                                                    </button>
                                                </div>

                                                @endif
                                        </td>
                                    </tr>
                                    @empty
                                    @if ($webgrafias->count() == 0 && $search != '')
                                    <tr>
                                        <td colspan="4">
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
                                        <td colspan="4">
                                            <div class="text-center" style="padding-bottom: 2rem; padding-top: 2rem;">
                                                <span class="text-secondary">
                                                    No hay webgrafias registradas
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer {{ $webgrafias->hasPages() ? 'py-0' : '' }}">
                            @if ($webgrafias->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $webgrafias->firstItem() }} - {{ $webgrafias->lastItem() }} de
                                    {{ $webgrafias->total() }} registros
                                </div>
                                <div class="mt-3">
                                    {{ $webgrafias->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $webgrafias->firstItem() }} - {{ $webgrafias->lastItem() }} de
                                    {{ $webgrafias->total() }} registros
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal-webgrafia" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_webgrafia">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="descripcion_webgrafia" class="form-label">
                                    Descripcion de Webgrafia
                                </label>
                                <input type="text" name="descripcion_webgrafia"
                                    class="form-control @error('descripcion_webgrafia') is-invalid @elseif(strlen($descripcion_webgrafia) > 0) is-valid @enderror"
                                    id="descripcion_webgrafia" wire:model.live="descripcion_webgrafia"
                                    placeholder="Ingrese la descripción" />
                                @error('descripcion_webgrafia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="link_webgrafia" class="form-label required">
                                    Link de Webgrafía
                                </label>
                                <input type="text" name="link_webgrafia"
                                    class="form-control @error('link_webgrafia') is-invalid @elseif(strlen($link_webgrafia) > 0) is-valid @enderror"
                                    id="link_webgrafia" wire:model.live="link_webgrafia"
                                    placeholder="Ingrese el link" />
                                @error('link_webgrafia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="cerrar_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M5.7 5.7l12.6 12.6" />
                            </svg>
                            Cancelar
                        </a>

                        <div class="ms-auto">
                            <div wire:loading.remove>
                                <button type="submit" class="btn btn-primary">
                                    @if ($modo === 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path
                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                    @endif
                                    {{ $accion_estado }}
                                </button>
                            </div>
                            <div wire:loading>
                                <button type="submit" class="btn btn-primary" disabled>
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
