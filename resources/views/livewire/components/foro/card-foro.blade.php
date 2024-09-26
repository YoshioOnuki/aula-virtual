<div>
    <div class="col-lg-12 mb-3 animate__animated animate__zoomIn animate__faster">
        <a class="card d-block card-trabajo-academico" href=""
            {{-- href="{{ $tipo_vista === 'cursos' ?
            route('cursos.detalle.trabajo-academico.detalle', [
            'id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista,
            'id_curso' => Hashids::encode($id_gestion_aula_usuario),
            'id_trabajo_academico' => Hashids::encode($trabajo_academico->id_trabajo_academico)]) :
            route('carga-academica.detalle.trabajo-academico.detalle', [
            'id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista,
            'id_curso' => Hashids::encode($id_gestion_aula_usuario),
            'id_trabajo_academico' => Hashids::encode($trabajo_academico->id_trabajo_academico)]) }}" --}}
            >

            <div class="modal-status bg-{{ config('settings.color-border-card-foro') }}"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h5 class="card-title d-flex align-items-center">
                            <img src="{{ asset('/media/icons/icon-foro.webp') }}"
                                alt="icono-foro" class="w-6 h-6 me-2">
                            <span class="fw-bold card-titulo">
                                {{ $foro->titulo_foro }}
                            </span>
                        </h5>
                        <p class="card-text">
                            <small class="text-muted d-none d-sm-block">
                                Fecha de inicio: {{ format_fecha($foro->fecha_inicio_foro) }}
                                - {{ format_hora($foro->fecha_inicio_foro) }}
                            </small>
                            <small class="text-muted d-none d-sm-block mt-2">
                                Fecha de fin: {{ format_fecha($foro->fecha_fin_foro) }} - {{
                                format_hora($foro->fecha_fin_foro) }}
                            </small>
                        </p>
                    </div>
                    <div>
                        @if ($tipo_vista === 'carga-academica' && $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                        <button class="btn btn-secondary d-none d-md-inline-block"
                            wire:click.prevent="abrir_modal({{ $foro->id_foro }})"
                            data-bs-toggle="modal" data-bs-target="#modal-foro">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Editar
                        </button>
                        <button class="btn btn-secondary d-md-none btn-icon"
                            wire:click.prevent="abrir_modal({{ $foro->id_foro }})"
                            data-bs-toggle="modal" data-bs-target="#modal-foro">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                        </button>
                        @endif
                        @if ($usuario->esRolGestionAula('ALUMNO', $id_gestion_aula_usuario) && $tipo_vista === 'cursos')
                        <span class="status status-{{ $foro->foroRespuesta ? 'primary' : 'red' }} px-3 py-2 h-100">
                            {{ $foro->foroRespuesta ? 'Respondido' : 'Sin responder' }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
