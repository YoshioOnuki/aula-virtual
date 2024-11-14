<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            @if ($es_docente_invitado)
                <livewire:components.navegacion.alert-docente-invitado />
            @endif

            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-2 d-none d-lg-block">
                    <livewire:components.navegacion.navegacion-curso :tipo_vista=$tipo_vista
                        :id_usuario=$id_usuario_hash :id_curso=$id_gestion_aula_hash />
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12">
                    @if($modo_admin)
                        <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
                    @endif

                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="card card-md card-stacked animate__animated animate__fadeIn  ">
                                <div class="card-stamp card-stamp-lg">
                                    @if ($tipo_vista === 'cursos')
                                        <div class="card-stamp-icon bg-teal">
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
                                        </div>
                                    @elseif($tipo_vista === 'carga-academica')
                                        <div class="card-stamp-icon bg-orange">
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
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    {{-- Titulo de la tarea --}}
                                    <h4 class="card-title">
                                        {{ $trabajo_academico->titulo_trabajo_academico }}
                                    </h4>

                                    {{-- Fecha de inicio y fin --}}
                                    <p class="card-text">
                                        <small class="text-muted
                                            d-none d-sm-block">
                                            Fecha de inicio: {{
                                            format_fecha($trabajo_academico->fecha_inicio_trabajo_academico)
                                            }}
                                            - {{ format_hora($trabajo_academico->fecha_inicio_trabajo_academico) }}
                                        </small>
                                        <small class="text-muted
                                            d-none d-sm-block mt-2">
                                            Fecha de fin: {{
                                            format_fecha($trabajo_academico->fecha_fin_trabajo_academico) }} -
                                            {{
                                            format_hora($trabajo_academico->fecha_fin_trabajo_academico) }}
                                        </small>
                                    </p>

                                    {{-- Descripcion de la tarea --}}
                                    <div>

                                        <div class="hr-text hr-text-center ">
                                            <span>
                                                Descripción
                                            </span>
                                        </div>

                                        <p class="card-text">
                                            {{ $trabajo_academico->descripcion_trabajo_academico }}
                                        </p>
                                    </div>

                                    @if($trabajo_academico->archivoDocente->count() > 0)
                                        {{-- Archivos adjuntos --}}
                                        <div class="">

                                            <div class="hr-text hr-text-center ">
                                                <span>
                                                    Archivos adjuntos
                                                </span>
                                            </div>

                                            <div class="row g-3">
                                                @foreach ($trabajo_academico->archivoDocente as $archivo)
                                                    @if (file_exists($archivo->archivo_docente))
                                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6" wire:key="archivo-{{ $archivo->id_archivo_docente }}">
                                                            <button class="card p-3 card-link card-link-pop w-100"
                                                                wire:click="descargar_archivo({{ $archivo->id_archivo_docente }})">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ obtener_icono_archivo($archivo->archivo_docente) }}"
                                                                        alt="icono-recurso" class="me-2" width="40">
                                                                    <div>
                                                                        <h5 class="mb-0">
                                                                            {{ Str::limit($archivo->nombre_archivo_docente, 25) }}
                                                                        </h5>
                                                                        <small class="text-muted d-block mt-1 fw-light d-flex align-items-start">
                                                                            {{ formato_tamano_archivo(filesize($archivo->archivo_docente)) }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6" wire:key="archivo-{{ $archivo->id_archivo_docente }}">
                                                            <div class="card p-3 background-gray">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="/media/icons/icon-archivo-generico2.webp"
                                                                        alt="icono-recurso" class="me-2" width="40">
                                                                    <div>
                                                                        <h5 class="mb-0 text-danger">
                                                                            {{ Str::limit("Archivo no disponible", 25) }}
                                                                        </h5>
                                                                        <small class="text-muted d-block mt-1 fw-light">
                                                                            No disponible
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($usuario->esAlumno($id_gestion_aula) && $tipo_vista === 'cursos')
                                        @if($entrega_trabajo === false)
                                            <div class="card-footer d-flex justify-content-end align-items-center mt-4">
                                                <a class="btn btn-primary
                                                    {{ verificar_fecha_trabajo($trabajo_academico->fecha_inicio_trabajo_academico, $trabajo_academico->fecha_fin_trabajo_academico) ? '' : 'disabled' }}"
                                                    wire:click="abrir_modal_entrega_trabajo" data-bs-toggle="modal"
                                                    data-bs-target="#modal-entrega">
                                                    Registrar entrega
                                                </a>
                                            </div>
                                        @else
                                            <div
                                                class="card-footer d-flex justify-content-end align-items-center mt-4 bg-white">
                                                {{-- <button class="btn btn-primary" wire:click="abrir_modal_entrega_trabajo"
                                                    data-bs-toggle="modal" data-bs-target="#modal-entrega">
                                                    Editar entrega
                                                </button> --}}

                                                <span class="status px-3 py-2 h-100
                                                    status-{{ color_estado_trabajo_academico($trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico ?? 'No entregado') }}">
                                                    {{ $trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico ?? 'No entregado' }}
                                                </span>

                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <livewire:components.trabajo-academico.card-estado-trabajo :id_usuario_hash=$id_usuario_hash
                                :tipo_vista=$tipo_vista :id_curso=$id_gestion_aula :trabajo_academico=$trabajo_academico
                                :lista_alumnos=true lazy />
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal para entrega de trabajo academico --}}
    <div wire:ignore.self class="modal fade" id="modal-entrega" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_entrega_trabajo">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="descripcion_trabajo_academico_alumno" class="form-label">
                                    Descripción del trabajo académico
                                </label>
                                <div wire:ignore>
                                    <textarea
                                        class="form-control @error('descripcion_trabajo_academico_alumno') is-invalid @enderror"
                                        wire:model.lazy="descripcion_trabajo_academico_alumno"
                                        id="descripcion_trabajo_academico_alumno"
                                        placeholder="Ingrese la descripción del trabajo académico a entregar">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="archivos_trabajo_alumno" class="form-label">
                                    Archivos del trabajo académico
                                </label>
                                <input type="file" class="form-control @error('archivos_trabajo_alumno') is-invalid @enderror
                                    @if(count($archivos_trabajo_alumno) > 0 && $errors->has('archivos_trabajo_alumno.*')) is-invalid
                                    @elseif(count($archivos_trabajo_alumno) > 0) is-valid @endif"
                                    wire:model.live="archivos_trabajo_alumno" id="upload{{ $iteration }}"
                                    accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png" multiple>
                                @error('archivos_trabajo_alumno.*')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal">
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
                            <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled"
                                wire:target="guardar_entrega_trabajo, archivos_trabajo_alumno, descripcion_trabajo_academico_alumno">
                                <span wire:loading.remove
                                    wire:target="guardar_entrega_trabajo, archivos_trabajo_alumno, descripcion_trabajo_academico_alumno">
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
                                    {{ $accion_modal }}
                                </span>
                                <span wire:loading
                                    wire:target="archivos_trabajo_alumno, descripcion_trabajo_academico_alumno">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando Contenido
                                </span>
                                <span wire:loading wire:target="guardar_entrega_trabajo">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Guardando Trabajo
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal para mostrar comentarios --}}
    <div wire:ignore.self class="modal fade" id="modal-comentarios" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Comentarios de la entrega
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @forelse($comentarios ?? [] as $comentario)
                            <div class="col-lg-12" wire:key="comentario-{{ $comentario->id_comentario_trabajo_academico }}">
                                <div class="hr-text hr-text-center">
                                    <span>
                                        {{ $comentario->gestionAulaDocente->usuario->nombre_completo }} -
                                        <small class="text-muted">
                                            {{ format_fecha_completa($comentario->created_at) }}
                                        </small>
                                    </span>
                                </div>
                                {!! $comentario->descripcion_comentario_trabajo_academico !!}
                            </div>
                        @empty
                            <div class="alert alert-info">
                                No se encontraron comentarios
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M5.7 5.7l12.6 12.6" />
                        </svg>
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@script
<script>
    $(function() {
        $('#descripcion_trabajo_academico_alumno').summernote({
            placeholder: 'Ingrese la descripción del trabajo académico a entregar',
            height: 200,
            tabsize: 2,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    var maxSize = 2 * 1024 * 1024; // 2MB
                    if (files[0].size > maxSize) {
                        // Mostrar toast de error
                        window.dispatchEvent(new CustomEvent('toast-basico', {
                            detail: {
                                type: 'error',
                                mensaje: 'El archivo supera el tamaño máximo permitido de 2MB.'
                            }
                        }));
                        console.log('El archivo supera el tamaño máximo permitido de 2MB.');
                        return;
                    }else{
                        let editor = $(this);
                        let reader = new FileReader();
                        reader.onloadend = function () {
                            editor.summernote('insertImage', reader.result);
                        };
                        reader.readAsDataURL(files[0]);
                    }
                },
                onChange: function(contents, $editable) {
                    @this.set('descripcion_trabajo_academico_alumno', contents);
                }
            },
        });
    })
</script>
@endscript
