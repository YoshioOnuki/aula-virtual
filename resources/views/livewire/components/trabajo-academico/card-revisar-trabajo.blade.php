<div>
    <div class="card card-link card-stacked animate__animated animate__fadeIn ">
        <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
            <h3 class="card-title fw-semibold">
                Revisión del Trabajo Académico
            </h3>
        </div>
        <div class="card-body row g-3">
            @if ($estado_carga)
                <span class="text-muted text-center">
                    <div class="spinner-border spinner-border-lg text-primary" role="status"></div>
                </span>
            @else
                <form autocomplete="off" wire:submit="revisar_trabajo_academico" novalidate>
                    <tbody>
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="nota_trabajo_academico" class="form-label required">
                                    Nota
                                </label>
                                @if (!$validar_entrega)
                                    <input type="number" class="form-control {{ $nota_trabajo_academico === null || $nota_trabajo_academico === '' ? 'bg-gray-400' : '' }}
                                        {{ $nota_trabajo_academico >= 11 ? 'border-teal' : 'border-danger' }}"
                                        id="nota_trabajo_academico" disabled wire:model="nota_trabajo_academico">
                                @else
                                    <input type="number" class="form-control @error('nota_trabajo_academico') is-invalid @elseif(strlen($nota_trabajo_academico) > 0) is-valid @enderror"
                                        wire:model.lazy="nota_trabajo_academico" id="nota_trabajo_academico"
                                        placeholder="0.00">
                                    @error('nota_trabajo_academico')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="descripcion_comentario_trabajo_academico" class="form-label">
                                    Observación del Trabajo Académico
                                </label>
                                @if (!$validar_entrega)
                                    @if ($descripcion_comentario_trabajo_academico === null || $descripcion_comentario_trabajo_academico === '')
                                        <textarea class="form-control" disabled>Sin observaciones</textarea>
                                    @else
                                        <span class="form-control text-muted bg-gray-400">
                                            {!! $descripcion_comentario_trabajo_academico !!}
                                        </span>
                                    @endif
                                @else
                                    <div wire:ignore>
                                        <textarea
                                            class="form-control"
                                            wire:model.lazy="descripcion_comentario_trabajo_academico"
                                            id="descripcion_comentario_trabajo_academico"
                                        >
                                            {{ $descripcion_comentario_trabajo_academico }}
                                        </textarea>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </tbody>
                    @if ($validar_entrega || $editar_entrega === true)
                        <div class="form-footer">
                            <button
                                type="submit" class="btn btn-primary w-100"
                                wire:loading.attr="disabled"
                                wire:target="revisar_trabajo_academico, descripcion_comentario_trabajo_academico"
                            >
                                <span wire:loading.remove wire:target="revisar_trabajo_academico, descripcion_comentario_trabajo_academico">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                        <path d="M14 19l2 2l4 -4" />
                                        <path d="M9 8h4" />
                                        <path d="M9 12h2" />
                                    </svg>
                                    Revisar Trabajo
                                </span>
                                <span wire:loading wire:target="revisar_trabajo_academico, descripcion_comentario_trabajo_academico">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando Contenido
                                </span>
                            </button>
                        </div>
                    {{-- @else
                        <div class="form-footer">
                            <button class="btn btn-primary w-100" wire:click="editar_trabajo_academico" type="button">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                    Editar Revisión
                                </span>
                            </button>
                        </div> --}}
                    @endif
                </form>
            @endif
        </div>
    </div>



</div>

@script
    <script>
        $(function() {
            $('#descripcion_comentario_trabajo_academico').summernote({
                placeholder: 'Ingrese la observación del trabajo académico',
                height: 200,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol']],
                ],
                callbacks: {
                    // Evitar cualquier tipo de archivo de imagen (png, jpg, jpeg, gif, etc.)
                    onImageUpload: function(files) {
                        window.dispatchEvent(new CustomEvent('toast-basico', {
                            detail: {
                                type: 'error',
                                mensaje: 'No se permite la subida de archivos en este campo.'
                            }
                        }));
                        return;
                    },
                    // Evitar cualquier tipo de archivo
                    onFileUpload: function(files) {
                        window.dispatchEvent(new CustomEvent('toast-basico', {
                            detail: {
                                type: 'error',
                                mensaje: 'No se permite la subida de archivos en este campo.'
                            }
                        }));
                        return;
                    },
                    onChange: function(contents, $editable) {
                        @this.set('descripcion_comentario_trabajo_academico', contents);
                    }
                },
            });
        });
    </script>
@endscript
