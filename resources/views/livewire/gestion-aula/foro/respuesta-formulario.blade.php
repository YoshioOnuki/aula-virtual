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

                        @if ($modo_respuesta_respuesta)
                            <livewire:components.foro.card-respuesta :usuario=$usuario
                                :tipo_vista=$tipo_vista :id_curso=$id_gestion_aula_hash
                                :id_gestion_aula_alumno=$id_gestion_aula_alumno :foro_respuesta=$foro_respuesta
                                :modo_respuesta=1 :nivel=$nivel lazy />
                        @else
                            <livewire:components.foro.card-detalle-foro :usuario=$usuario
                                :tipo_vista=$tipo_vista :id_curso=$id_gestion_aula_hash
                                :foro=$foro :modo_respuesta=1 lazy />
                        @endif

                        <div class="col-12">
                            <div class="card animate__animated animate__fadeIn">

                                <div class="card-header d-flex justify-content-start align-items-center">
                                    <h3 class="card-title">
                                        Responder Foro
                                    </h3>
                                </div>

                                <form autocomplete="off" wire:submit="guardar_respuesta" novalidate>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            <div class="col-lg-12">
                                                <label for="descripcion_foro_respuesta" class="form-label required @error('descripcion_foro_respuesta') text-danger @enderror">
                                                    Respuesta
                                                </label>
                                                <div wire:ignore>
                                                    <textarea class="form-control" wire:model.lazy="descripcion_foro_respuesta"
                                                        id="descripcion_foro_respuesta">
                                                        {{ $descripcion_foro_respuesta }}
                                                    </textarea>
                                                </div>
                                                @error('descripcion_foro_respuesta')
                                                    <span class="error text-danger fs-5">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-between">

                                        <div class="ms-auto">
                                            <button class="btn btn-primary w-100" type="submit" wire:loading.attr="disabled"
                                                wire:target="guardar_respuesta">
                                                <span wire:loading.remove wire:target="guardar_respuesta">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-message-plus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M8 9h8" />
                                                        <path d="M8 13h6" />
                                                        <path d="M12.01 18.594l-4.01 2.406v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5" />
                                                        <path d="M16 19h6" />
                                                        <path d="M19 16v6" />
                                                    </svg>
                                                    Registrar
                                                </span>
                                                <span wire:loading wire:target="guardar_respuesta">
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
    </div>

</div>

@script
<script>
    $(function() {
            $('#descripcion_foro_respuesta').summernote({
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
                        @this.set('descripcion_foro_respuesta', contents);
                    }
                },
            });
        })
</script>
@endscript
