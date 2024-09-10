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
                        {{-- Formulario para ingresar nota y un comentario para la observacion --}}
                        <tr>
                            <td class="text-nowrap">
                                <label class="form-label">
                                    Nota
                                </label>
                            </td>
                            <td>
                                <input type="number" class="form-control" placeholder="Nota">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-nowrap">
                                <label class="form-label">
                                    Observación
                                </label>
                            </td>
                            <td>
                                <textarea class="form-control" rows="3" placeholder="Observación"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if($tipo_vista === 'carga-academica')
                    <button class="btn btn-primary col-12 mt-4 mb-2">
                        Revisar Trabajo
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
