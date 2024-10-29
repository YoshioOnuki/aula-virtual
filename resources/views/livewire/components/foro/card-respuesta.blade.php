<div class="col-12">
    <div class="card animate__animated animate__fadeIn">
        <div class="card-status-start bg-{{ config('settings.color-border-card-foro') }}"></div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start">
                    <img src="{{ asset($foro_respuesta->gestionAulaAlumno->usuario->mostrarFoto('alumno')) }}" alt="avatar"
                        class="avatar me-2 rounded avatar-static">
                    <div class="flex-fill">
                        <div class="fw-bold fs-3">
                            {{ $foro_respuesta->gestionAulaAlumno->usuario->nombre_completo }}
                        </div>

                        <div class="text-secondary">
                            {{ format_fecha_completa($foro_respuesta->created_at) }}
                        </div>

                        <p class="mt-4">
                            {!! $foro_respuesta->descripcion_foro_respuesta !!}
                        </p>

                        @if (config('settings.responder_respuesta_foro') && !$modo_respuesta)
                            <div class="mt-4">
                                <a class="text-primary cursor-pointer"
                                href="{{ $tipo_vista === 'cursos' ? 
                                route('cursos.detalle.foro.respuesta.formulario.respuesta', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($foro_respuesta->id_foro), 'id_foro_respuesta' => Hashids::encode($foro_respuesta->id_foro_respuesta)]) :
                                route('carga-academica.detalle.foro.respuesta.formulario.respuesta', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($foro_respuesta->id_foro), 'id_foro_respuesta' => Hashids::encode($foro_respuesta->id_foro_respuesta)]) }}">
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
                                    Responder
                                </a>
                            </div>
                        @endif
                    </div>
                    </h3>
                </div>
                <div>
                    @if ($es_propietario)
                        <div class="dropdown">
                            <a href="#" class=" text-dark" data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                </svg>
                            </a>
                            <div class="dropdown-menu">
                                {{-- <a class="dropdown-item cursor-pointer"
                                    data-bs-toggle="modal" data-bs-target="#modal-foro">
                                    Editar
                                </a> --}}
                                <a class="dropdown-item cursor-pointer" wire:click="eliminar_respuesta"
                                    data-bs-toggle="modal" data-bs-target="#modal-eliminar">
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
