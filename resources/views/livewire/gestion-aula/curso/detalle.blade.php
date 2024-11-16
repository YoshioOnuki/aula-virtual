<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            @if ($es_docente_invitado)
                <livewire:components.navegacion.alert-docente-invitado />
            @endif

            @if($modo_admin)
                <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="row g-3">

                <div class="col-lg-8">
                    <div class="row g-3">
                        @if($tipo_vista ==='cursos')
                            <div class="col-12">
                                <livewire:components.curso.card-presentacion :id_gestion_aula=$id_gestion_aula lazy />
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="card card-md card-stacked animate__animated animate__fadeIn">
                                <div class="card-stamp card-stamp-lg">
                                    @if ($tipo_vista ==='carga-academica')
                                    <div class="card-stamp-icon bg-orange">
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
                                    <div class="row g-4">
                                        @foreach ($opciones_curso as $item)
                                            <livewire:components.curso.opcion-curso :tipo_vista=$tipo_vista :opcion=$item
                                                wire:key="opcion-{{ Str::slug($item['nombre']) }}" lazy />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">

                    <livewire:components.curso.info-docente :id_gestion_aula=$id_gestion_aula
                        :tipo_vista=$tipo_vista lazy />

                    <livewire:components.curso.datos-curso :id_gestion_aula=$id_gestion_aula
                        :ruta_pagina=$ruta_pagina :tipo_vista=$tipo_vista lazy />

                </div>

            </div>
        </div>
    </div>


    {{-- Modal Link de Clase --}}
    <div wire:ignore.self class="modal fade" id="modal-link-clase" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_link_clase }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_link_clase">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="nombre_link_clase" class="form-label required">
                                    Link de Clase
                                </label>
                                <input type="text" name="nombre_link_clase"
                                    class="form-control @error('nombre_link_clase') is-invalid @elseif(strlen($nombre_link_clase) > 0) is-valid @enderror"
                                    id="nombre_link_clase" wire:model.live="nombre_link_clase"
                                    placeholder="Ingrese el link" />
                                @error('nombre_link_clase')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="limpiar_modal">
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
                            <button type="submit" class="btn btn-primary"
                                wire:loading.attr="disabled" wire:target="guardar_link_clase">
                                <span wire:loading.remove wire:target="guardar_link_clase">
                                    @if ($modo_link_clase === 1)
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
                                    {{ $accion_estado_link_clase }}
                                </span>
                                <span wire:loading wire:target="guardar_link_clase">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Orientaciones --}}
    <div wire:ignore.self class="modal fade" id="modal-orientaciones" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_orientaciones }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_orientaciones">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="descripcion_orientaciones" class="form-label required">
                                    Orientaciones Generales
                                </label>
                                <div wire:ignore>
                                    <textarea class="form-control required" wire:model.lazy="descripcion_orientaciones"
                                        id="descripcion_orientaciones">
                                        {{ $descripcion_orientaciones }}
                                    </textarea>
                                </div>
                                @error('descripcion_orientaciones')
                                    <span class="error text-danger fs-5">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="limpiar_modal">
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
                            <button type="submit" class="btn btn-primary"
                                wire:loading.attr="disabled" wire:target="guardar_orientaciones">
                                <span wire:loading.remove wire:target="guardar_orientaciones">
                                    @if ($modo_orientaciones === 1)
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
                                    {{ $accion_estado_orientaciones }}
                                </span>
                                <span wire:loading wire:target="guardar_orientaciones">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@script
<script>
    $(function() {
            $('#descripcion_orientaciones').summernote({
                placeholder: 'Ingrese la descripcion de las orientaciones',
                height: 300,
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
                        @this.set('descripcion_orientaciones', contents);
                    }
                },
            });
        })
</script>
@endscript
