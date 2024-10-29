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

                    <div class="card animate__animated animate__fadeIn">

                        <div class="card-header d-flex justify-content-start align-items-center">
                            <h3 class="card-title">
                                {{ $modo === 1 ? 'Registrar' : 'Editar' }} Foro
                            </h3>
                        </div>

                        <form autocomplete="off" wire:submit="guardar_foro" novalidate>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <label for="titulo_foro" class="form-label required">
                                            Título del Foro
                                        </label>
                                        <input type="text" name="titulo_foro"
                                            class="form-control @error('titulo_foro') is-invalid @elseif(strlen($titulo_foro) > 0) is-valid @enderror"
                                            id="titulo_foro" wire:model.live="titulo_foro"
                                            placeholder="Ingrese su correo electrónico" />
                                        @error('titulo_foro')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="descripcion_foro" class="form-label required">
                                            Descripción del Foro
                                        </label>
                                        <div wire:ignore>
                                            <textarea class="form-control @error('descripcion_foro') is-invalid @enderror" wire:model.lazy="descripcion_foro"
                                                id="descripcion_foro">
                                                {{ $descripcion_foro }}
                                            </textarea>
                                        </div>
                                        @error('descripcion_foro')
                                            <span class="error text-danger fs-5">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="fecha_inicio_foro" class="form-label required">
                                            Fecha de inicio
                                        </label>
                                        <input type="date" name="fecha_inicio_foro"
                                            class="form-control @error('fecha_inicio_foro') is-invalid @elseif(strlen($fecha_inicio_foro) > 0) is-valid @enderror"
                                            id="fecha_inicio_foro" wire:model.live="fecha_inicio_foro" />
                                        @error('fecha_inicio_foro')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="hora_inicio_foro" class="form-label required">
                                            Hora de inicio
                                        </label>
                                        <input type="time" name="hora_inicio_foro"
                                            class="form-control @error('hora_inicio_foro') is-invalid @elseif(strlen($hora_inicio_foro) > 0) is-valid @enderror"
                                            id="hora_inicio_foro" wire:model.live="hora_inicio_foro" />
                                        @error('hora_inicio_foro')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="fecha_fin_foro" class="form-label required">
                                            Fecha de fin
                                        </label>
                                        <input type="date" name="fecha_fin_foro"
                                            class="form-control @error('fecha_fin_foro') is-invalid @elseif(strlen($fecha_fin_foro) > 0) is-valid @enderror"
                                            id="fecha_fin_foro" wire:model.live="fecha_fin_foro" />
                                        @error('fecha_fin_foro')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="hora_fin_foro" class="form-label required">
                                            Hora de fin
                                        </label>
                                        <input type="time" name="hora_fin_foro"
                                            class="form-control @error('hora_fin_foro') is-invalid @elseif(strlen($hora_fin_foro) > 0) is-valid @enderror"
                                            id="hora_fin_foro" wire:model.live="hora_fin_foro" />
                                        @error('hora_fin_foro')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-between">



                                <div class="ms-auto">
                                    <button class="btn btn-primary w-100" type="submit" wire:loading.attr="disabled"
                                        wire:target="guardar_foro">
                                        <span wire:loading.remove wire:target="guardar_foro">
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
                                            {{ $modo === 1 ? 'Registrar' : 'Editar' }}
                                        </span>
                                        <span wire:loading wire:target="guardar_foro">
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
    </div>

</div>


@script
<script>
    $(function() {
            $('#descripcion_foro').summernote({
                placeholder: 'Ingrese la descripcion del foro',
                height: 300,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']]
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
                        @this.set('descripcion_foro', contents);
                    }
                },
            });
        })
</script>
@endscript
