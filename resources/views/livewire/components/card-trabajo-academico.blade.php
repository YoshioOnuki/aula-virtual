<div>
    <div class="col-12">
        <a class="card d-block card-trabajo-academico" href="">
            <div class="modal-status bg-{{ config('settings.color-border-card-trabajo-academico') }}"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h5 class="card-title d-flex align-items-center">
                            <img src="{{ asset('/media/icons/icon-trabajo-academico-3.webp') }}" alt="icono-trabajo-academico"
                                class="w-6 h-6 me-2">
                            <span class="fw-bold card-titulo">
                                {{ $trabajo_academico->titulo_trabajo_academico }}
                            </span>
                        </h5>
                        <p class="card-text">
                            <small class="text-muted d-none d-sm-block">
                                Fecha de inicio: {{ format_fecha($trabajo_academico->fecha_inicio_trabajo_academico) }} - {{ format_hora($trabajo_academico->fecha_inicio_trabajo_academico) }}
                            </small>
                            <small class="text-muted d-none d-sm-block mt-2">
                                Fecha de fin: {{ format_fecha($trabajo_academico->fecha_fin_trabajo_academico) }} - {{ format_hora($trabajo_academico->fecha_fin_trabajo_academico) }}
                            </small>
                        </p>
                    </div>
                    <div>
                        @if ($usuario->esRolGestionAula('ALUMNO', $id_gestion_aula_usuario))
                            <span class="status status-{{ color_estado_trabajo_academico($trabajo_academico->trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico ?? 'No entregado') }} 
                                px-3 py-2 h-100">
                                {{ $trabajo_academico->trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico ?? 'No entregado' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
