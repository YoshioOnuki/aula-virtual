<div class="col-12">
    <div class="card card-stacked animate__animated animate__fadeIn">
        {{-- <div class="card-status-start bg-primary"></div> --}}

        <div class="card-stamp card-stamp-lg">
            {{-- Icono --}}
            @if ($tipo_vista === 'cursos')
                <div class="card-stamp-icon bg-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                    </svg>
                </div>
            @elseif($tipo_vista === 'carga-academica')
                <div class="card-stamp-icon bg-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                    </svg>
                </div>
            @endif
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start">
                    <img src="{{ asset($foro->gestionAulaDocente->usuario->mostrarFoto('docente')) }}" alt="avatar"
                        class="avatar me-2 rounded avatar-static">
                    <div class="flex-fill">
                        <div class="fw-bold fs-3">
                            {{ $foro->titulo_foro }}
                        </div>

                        <div class="text-secondary">
                                De
                                <a class="cursor-pointer">
                                    {{ $foro->gestionAulaDocente->usuario->nombre_completo }}
                                </a> - {{ format_fecha_completa($foro->created_at) }}
                        </div>

                        <p class="mt-4">
                            {!! $foro->descripcion_foro !!}
                        </p>

                        @if (!$modo_respuesta)
                            <div class="mt-4 mb-1">
                                <a class="btn btn-primary cursor-pointer"
                                    href="{{ $tipo_vista === 'cursos' ? 
                                    route('cursos.detalle.foro.respuesta.formulario', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($foro->id_foro)]) : 
                                    route('carga-academica.detalle.foro.respuesta.formulario', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($foro->id_foro)]) }}">
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
                    @if ($es_docente)
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
                                <a class="dropdown-item cursor-pointer"
                                    href="{{ route('carga-academica.detalle.foro.editar', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($foro->id_foro)]) }}">
                                    Editar
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


