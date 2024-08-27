{{-- <div wire:init="load_datos_curso"> --}}
<div>
    {{-- @if($cargando_datos_curso)
        <div class="card card-stacked placeholder-glow animate__animated animate__fadeIn animate__faster">
            <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                <div class="placeholder col-5 {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }}"
                style="height: 1.5rem; width: 170.56px;"></div>
            </div>
            <div class="card-body row g-3 mb-0">
                <div class="d-flex flex-column gap-2">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 148.94px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 148.94px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 117.06px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 43.3px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 122.21px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder col-12 bg-secondary" style="height: 17px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-start">
                            <div class="row g-2">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 34.20px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 57.86px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-end">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 40.07px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 104.33px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 64.44px;"></div>
                                </div>
                            </div>
                        </div>

                        @if($datos)
                            <div class="col-12">
                                <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-12 mt-1 mb-2" aria-hidden="true" style="height: 36px;"></a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @else --}}
        <div class="card card-link card-stacked">
            <div
                class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                <h3 class="card-title fw-semibold">
                    Estado del Trabajo Académico
                </h3>
            </div>
            <div class="card-body row g-3">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <tbody>
                            <tr>
                                <th scope="row">Estado de Entrega</th>
                                <td>
                                    @if($tipo_vista === 'cursos')
                                        @if($trabajo_academico_alumno)
                                            <div class="">
                                                {{ $trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico }}
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                Sin entregar
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-muted">
                                            {{ $cantidad_alumnos_entregados }} de {{ $cantidad_alumnos }} entregas
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Calificación</th>
                                <td>
                                    @if($tipo_vista === 'cursos')
                                        @if($trabajo_academico_alumno)
                                            <div class="{{ $trabajo_academico_alumno->nota_trabajo_academico_alumno == -1 ? 'text-muted' : '' }}">
                                                {{ $trabajo_academico_alumno->nota_trabajo_academico_alumno == -1 ? 'Sin calificar' : $trabajo_academico_alumno->nota_trabajo_academico_alumno }}
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                Sin calificar
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-muted mb-1">
                                            {{ $cantidad_alumnos_revisados }} de {{ $cantidad_alumnos_entregados }} revisados
                                        </div>
                                        <div class="text-muted">
                                            {{ $cantidad_alumnos_observados }} de {{ $cantidad_alumnos_entregados }} observados
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Tiempo restante</th>
                                <td>
                                    @if($trabajo_academico->fecha_fin_trabajo_academico->isFuture())
                                        <div class="text-muted">
                                            {{ ucfirst($trabajo_academico->fecha_fin_trabajo_academico->diffForHumans()) }}
                                        </div>
                                    @else
                                        <span class="text-danger">Plazo vencido</span>
                                    @endif
                                </td>
                            </tr>
                            @if($tipo_vista === 'cursos')
                                <tr>
                                    <th scope="row">Última modificación</th>
                                    <td>
                                        @if($trabajo_academico_alumno)
                                            <div class="text-muted">
                                                {{ ucfirst($trabajo_academico_alumno->updated_at->diffForHumans()) }}
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                Sin entregar
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Comentarios de la entrega</th>
                                    <td><a href="#">Comentarios (0)</a></td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    @if($tipo_vista === 'carga-academica')
                        {{-- Boton para ingresar a la lista de alumnos y ver sus trabajos academicos --}}
                        <a href="{{ route('carga-academica.detalle.trabajo-academico.alumnos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' => $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario), 'id_trabajo_academico' => Hashids::encode($trabajo_academico->id_trabajo_academico)]) }}"
                            class="btn btn-primary col-12 mt-4 mb-2">
                            Ver trabajos académicos
                        </a>
                    @endif
                </div>
            </div>
        </div>
    {{-- @endif --}}
</div>

