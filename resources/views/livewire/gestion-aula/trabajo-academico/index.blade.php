<div>

    @livewire('components.page-header', [
        'titulo_pasos' => $titulo_page_header,
        'titulo' => $titulo_page_header,
        'links_array' => $links_page_header,
        'regresar' => $regresar_page_header
    ])

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                @livewire('components.info-alumnos-docentes', [
                    'usuario' => $usuario,
                    'tipo_vista' => $tipo_vista
                ])
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-stamp card-stamp-lg">
                            @if ($tipo_vista === 'cursos')
                                <div class="card-stamp-icon bg-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 5h8" />
                                        <path d="M13 9h5" />
                                        <path d="M13 15h8" />
                                        <path d="M13 19h5" />
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </div>
                            @elseif($tipo_vista === 'carga-academica')
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 5h8" />
                                        <path d="M13 9h5" />
                                        <path d="M13 15h8" />
                                        <path d="M13 19h5" />
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start" wire:init="load_trabajos_llamar">

                                @if ($tipo_vista === 'carga-academica' && $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                    <div class="col-lg-12">
                                        <div class="card hover-shadow-sm cursor-pointer"
                                            wire:click="abrir_modal_agregar_trabajo()">
                                            <div class="card-body text-secondary">
                                                <div class="row g-2">
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center mt-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-library-plus svg-medium">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                            <path
                                                                d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                                            <path d="M11 10h6" />
                                                            <path d="M14 7v6" />
                                                        </svg>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center">
                                                        <span class="text-muted fs-5">
                                                            Agregar trabajo académico
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($cargando_trabajos)
                                    <div class="col-12">
                                        <div class="card placeholder-glow">
                                            <div class="card-body p-4">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div class="placeholder col-6" style="height: 1.5rem;"></div>
                                                    <div class="placeholder"></div>
                                                </div>
                                                <div>
                                                    <div class="col-12"></div>
                                                    <div class="placeholder placeholder-xs col-4 bg-secondary">
                                                    </div>
                                                    <div class="col-12"></div>
                                                    <div class="placeholder placeholder-xs col-4 bg-secondary">
                                                    </div>
                                                </div>
                                                <div class=" d-flex justify-content-end">
                                                    @if ($tipo_vista === 'carga-academica' && $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                                    <a href="#" tabindex="-1"
                                                        class="btn btn-secondary disabled placeholder col-sm-2 col-lg-3 col-xl-2 d-none d-md-inline-block"
                                                        aria-hidden="true"></a>
                                                    <a href="#" tabindex="-1"
                                                        class="btn btn-secondary disabled placeholder col-1 d-md-none btn-icon"
                                                        aria-hidden="true"></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @livewire('components.card-trabajo-academico', [
                                        'trabajos_academicos' => $trabajos_academicos,
                                        'tipo_vista' => $tipo_vista,
                                        'usuario' => $usuario,
                                        'id_gestion_aula_usuario' => $id_gestion_aula_usuario
                                    ])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    @livewire('components.datos-curso', [
                        'id_gestion_aula_usuario' => $id_gestion_aula_usuario,
                        'tipo_vista' => $tipo_vista
                    ])
                </div>

            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modal-trabajo-academico" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_trabajo">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="nombre_recurso" class="form-label required">
                                    Nombre del trabajo académico
                                </label>
                                <input type="text" name="nombre_trabajo_academico"
                                    class="form-control @error('nombre_trabajo_academico') is-invalid @elseif(strlen($nombre_trabajo_academico) > 0) is-valid @enderror"
                                    id="nombre_trabajo_academico" wire:model.live="nombre_trabajo_academico"
                                    placeholder="Ingrese su correo electrónico" />
                                @error('nombre_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="descripcion_recurso" class="form-label">
                                    Descripción del trabajo académico
                                </label>
                                <textarea name="descripcion_trabajo_academico"
                                    class="form-control @error('descripcion_trabajo_academico') is-invalid @elseif(strlen($descripcion_trabajo_academico) > 0) is-valid @enderror"
                                    id="descripcion_trabajo_academico" wire:model.live="descripcion_trabajo_academico"
                                    placeholder="Ingrese la descripción del trabajo académico" rows="4"></textarea>
                                @error('descripcion_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="fecha_inicio_trabajo_academico" class="form-label required">
                                    Fecha de inicio
                                </label>
                                <input type="date" name="fecha_inicio_trabajo_academico"
                                    class="form-control @error('fecha_inicio_trabajo_academico') is-invalid @elseif(strlen($fecha_inicio_trabajo_academico) > 0) is-valid @enderror"
                                    id="fecha_inicio_trabajo_academico"
                                    wire:model.live="fecha_inicio_trabajo_academico" />
                                @error('fecha_inicio_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="hora_inicio_trabajo_academico" class="form-label required">
                                    Hora de inicio
                                </label>
                                <input type="time" name="hora_inicio_trabajo_academico"
                                    class="form-control @error('hora_inicio_trabajo_academico') is-invalid @elseif(strlen($hora_inicio_trabajo_academico) > 0) is-valid @enderror"
                                    id="hora_inicio_trabajo_academico"
                                    wire:model.live="hora_inicio_trabajo_academico" />
                                @error('hora_inicio_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="fecha_fin_trabajo_academico" class="form-label required">
                                    Fecha de fin
                                </label>
                                <input type="date" name="fecha_fin_trabajo_academico"
                                    class="form-control @error('fecha_fin_trabajo_academico') is-invalid @elseif(strlen($fecha_fin_trabajo_academico) > 0) is-valid @enderror"
                                    id="fecha_fin_trabajo_academico"
                                    wire:model.live="fecha_fin_trabajo_academico" />
                                @error('fecha_fin_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="hora_fin_trabajo_academico" class="form-label required">
                                    Hora de fin
                                </label>
                                <input type="time" name="hora_fin_trabajo_academico"
                                    class="form-control @error('hora_fin_trabajo_academico') is-invalid @elseif(strlen($hora_fin_trabajo_academico) > 0) is-valid @enderror"
                                    id="hora_fin_trabajo_academico"
                                    wire:model.live="hora_fin_trabajo_academico" />
                                @error('hora_fin_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="archivos_trabajo_academico" class="form-label">
                                    @if ($modo === 1)
                                        Archivos del trabajo académico
                                    @else
                                        Agregar archivos al trabajo académico
                                    @endif
                                </label>
                                <input type="file" class="form-control @error('archivos_trabajo_academico') is-invalid @enderror
                                    @if(count($archivos_trabajo_academico) > 0 && $errors->has('archivos_trabajo_academico.*')) is-invalid 
                                    @elseif(count($archivos_trabajo_academico) > 0) is-valid @endif"
                                    wire:model.live="archivos_trabajo_academico" id="upload{{ $iteration }}"
                                    accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.txt" multiple>
                                @error('archivos_trabajo_academico.*')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="cerrar_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M5.7 5.7l12.6 12.6" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            @if ($modo === 1)
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            @endif
                            {{ $accion_modal }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

@push('scripts')
    {{-- /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */ --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
        // document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('load_trabajos_evento', () => {
                setTimeout(() => {
                    @this.call('load_trabajos')
                }, 500);
            });
        });
    </script>
@endpush
