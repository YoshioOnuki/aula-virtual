<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header lazy />

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
            <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card animate__animated animate__fadeIn  ">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary">
                                    <div class="">
                                        <div class="d-inline-block">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                placeholder="Buscar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th class="col-1">Código</th>
                                        <th>Alumno</th>
                                        <th>Hora de entrega</th>
                                        <th>Nota</th>
                                        <th class="col-2">Entrega</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($entregas_academicas as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->usuario->persona->codigo_alumno_persona }}</td>
                                            <td>{{ $item->usuario->nombre_completo }}</td>
                                            <td>
                                                @forelse ($item->trabajoAcademicoAlumno as $trabajo)
                                                    @if($trabajo->created_at > $trabajo_academico->fecha_fin_trabajo_academico)
                                                        <span class="text-danger">
                                                            {{ $trabajo->created_at->diff($trabajo_academico->fecha_fin_trabajo_academico) }} tarde
                                                        </span>
                                                    @else
                                                        {{ format_hora($trabajo->created_at) }}
                                                    @endif
                                                @empty
                                                    <span class="text-secondary">Sin entrega</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                @forelse ($item->trabajoAcademicoAlumno as $trabajo)
                                                    @if($trabajo->nota_trabajo_academico_alumno >= 0)
                                                        <span class="{{ $trabajo->nota_trabajo_academico_alumno >= 11 ? 'text-teal' : 'text-danger' }}">
                                                            {{ $trabajo->nota_trabajo_academico_alumno }}
                                                        </span>
                                                    @else
                                                        <span class="text-secondary">Sin calificar</span>
                                                    @endif
                                                @empty
                                                    <span class="text-secondary">Sin entrega</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                @if(count($item->trabajoAcademicoAlumno) > 0)
                                                    <a href="{{ route('carga-academica.detalle.trabajo-academico.alumnos.entrega',
                                                        ['id_usuario' => $id_usuario_hash, 'tipo_vista' => $tipo_vista,
                                                        'id_curso' => Hashids::encode($id_gestion_aula_usuario),
                                                        'id_trabajo_academico' => Hashids::encode($trabajo_academico->id_trabajo_academico),
                                                        'id_trabajo_academico_alumno' => Hashids::encode($item->trabajoAcademicoAlumno[0]->id_trabajo_academico_alumno)
                                                        ]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        @if($item->trabajoAcademicoAlumno[0]->estadoTrabajoAcademico->nombre_estado_trabajo_academico === 'Entregado')
                                                            Revisar entrega
                                                        @else
                                                            Ver entrega
                                                        @endif
                                                    </a>
                                                @else
                                                    <span class="text-secondary">Sin entrega</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($entregas_academicas->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center" style="padding-bottom: 2rem; padding-top: 2rem;">
                                                        <span class="text-secondary">
                                                            No se encontraron resultados para
                                                            "<strong>{{ $search }}</strong>"
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center" style="padding-bottom: 2rem; padding-top: 2rem;">
                                                        <span class="text-secondary">
                                                            No hay alumnos matriculados
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer {{ $entregas_academicas->hasPages() ? 'py-0' : '' }}">
                            @if ($entregas_academicas->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $entregas_academicas->firstItem() }} - {{
                                    $entregas_academicas->lastItem() }} de
                                    {{ $entregas_academicas->total() }} registros
                                </div>
                                <div class="mt-3">
                                    {{ $entregas_academicas->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $entregas_academicas->firstItem() }} - {{
                                    $entregas_academicas->lastItem() }} de
                                    {{ $entregas_academicas->total() }} registros
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <livewire:components.trabajo-academico.card-estado-trabajo :id_usuario_hash=$id_usuario_hash
                        :tipo_vista=$tipo_vista :id_gestion_aula_usuario=$id_gestion_aula_usuario
                        :trabajo_academico=$trabajo_academico :id_gestion_aula=$id_gestion_aula :lista_alumnos=false
                        lazy />
                </div>
            </div>
        </div>
    </div>

</div>
