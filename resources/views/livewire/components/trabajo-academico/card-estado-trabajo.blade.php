<div>
    <div class="card card-link card-stacked animate__animated animate__fadeIn ">
        <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
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
                                            {{
                                            $trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico
                                            }}
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
                                        <div
                                            class="{{ $trabajo_academico_alumno->nota_trabajo_academico_alumno == -1 ? 'text-muted' : '' }}">
                                            {{ $trabajo_academico_alumno->nota_trabajo_academico_alumno == -1 ? 'Sin calificar'
                                            : $trabajo_academico_alumno->nota_trabajo_academico_alumno }}
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
                {{-- Si en la ruta existe 'alumnos' aparesca esto --}}
                @if($tipo_vista === 'carga-academica' && $lista_alumnos === true)
                    <a href="{{ route('carga-academica.detalle.trabajo-academico.alumnos', [
                        'id_usuario' => $id_usuario_hash, 
                        'tipo_vista' => $tipo_vista, 
                        'id_curso' => Hashids::encode($id_gestion_aula), 
                        'id_trabajo_academico' => Hashids::encode($trabajo_academico->id_trabajo_academico)]) }}"
                        class="btn btn-primary col-12 mt-4 mb-2">
                        Ver trabajos académicos
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
