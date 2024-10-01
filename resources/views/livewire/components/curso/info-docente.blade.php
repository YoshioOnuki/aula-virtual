<div class="row g-3 mb-3">

    @forelse ($docente as $item)
        <div class="col-12 animate__animated animate__fadeIn">
            <a class="card card-link card-stacked">
                <div class="card-cover card-cover-blurred text-center"
                    style="background-image: url({{ $tipo_vista === 'carga-academica' ? config('settings.fondo_detalle_doncente') : config('settings.fondo_detalle_alumno') }})">
                    @if ($tipo_vista === 'carga-academica')
                    <img src="{{ asset($item->usuario->mostrarFoto('docente')) }}" alt="avatar"
                        class="avatar avatar-xl avatar-thumb rounded">
                    @else
                    <img src="{{ asset($item->usuario->mostrarFoto('alumno')) }}" alt="avatar"
                        class="avatar avatar-xl avatar-thumb rounded">
                    @endif
                </div>
                <div class="card-body text-center">
                    <div class="card-title mb-1">
                        <span>
                            {{ $item->usuario->nombre_completo }}
                        </span>
                    </div>
                    <div class="text-muted">
                        <span>
                            {{ $item->usuario->persona->correo_persona }}
                        </span>
                    </div>
                    <div class="mt-2">
                        <span class="badge {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                            {{ $item->es_invitado ? 'Docente Invitado' : 'Docente' }}
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="card card-stacked animate__animated animate__fadeIn  ">
                <div class="card-body d-flex flex-column align-items-center text-center text-muted fw-bold">
                    Sin docente asignado
                </div>
            </div>
        </div>
    @endforelse

</div>
