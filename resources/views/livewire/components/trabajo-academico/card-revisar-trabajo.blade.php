<div>
    <div class="card card-link card-stacked animate__animated animate__fadeIn ">
        <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
            <h3 class="card-title fw-semibold">
                Revisión del Trabajo Académico
            </h3>
        </div>
        <div class="card-body row g-3">
            <form autocomplete="off" wire:submit="revisar_trabajo_academico">
                <tbody>
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="nota_trabajo_academico" class="form-label">
                                Nota
                            </label>
                            @if ($trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico !== 'Entregado')
                                <input type="number" class="form-control {{ $nota_trabajo_academico === null || $nota_trabajo_academico === '' ? 'bg-gray-400' : '' }}
                                    {{ $nota_trabajo_academico >= 11 ? 'border-success' : 'border-danger' }}"
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
                            @if ($trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico !== 'Entregado')
                                @if ($descripcion_comentario_trabajo_academico === null || $descripcion_comentario_trabajo_academico === '')
                                    <textarea class="form-control" disabled>Sin observaciones</textarea>
                                @else
                                    <span class="form-control text-muted bg-gray-400">
                                        {!! $descripcion_comentario_trabajo_academico !!}
                                    </span>
                                @endif
                            @else
                                <div wire:ignore>
                                    <textarea class="form-control"
                                        wire:model.live="descripcion_comentario_trabajo_academico"
                                        id="descripcion_comentario_trabajo_academico">
                                    </textarea>
                                </div>
                                @error('descripcion_comentario_trabajo_academico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
                        </div>
                    </div>
                </tbody>
                <div class="form-footer">
                    <button class="btn btn-primary w-100" type="submit"
                        wire:loading.attr="disabled" wire:target="revisar_trabajo_academico">
                        <span wire:loading.remove wire:target="revisar_trabajo_academico">Revisar Trabajo Académico</span>
                        <span wire:loading wire:target="revisar_trabajo_academico">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </span>
                    </button>
                </div>

            </form>
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
                    ['view', ['codeview']]
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
