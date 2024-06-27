<div class="card card-stacked animate__animated animate__fadeIn animate__faster mb-3">
    <div class="card-body text-center">
        <div class="mb-3">
            @if (session('tipo_vista') === 'alumno')
                <img src="{{ asset($usuario->mostrarFoto('alumno')) }}"
                        alt="avatar" class="avatar avatar-lg avatar-thumb rounded">
            @elseif(session('tipo_vista') === 'docente')
                <img src="{{ asset($usuario->mostrarFoto('docente')) }}"
                        alt="avatar" class="avatar avatar-lg avatar-thumb rounded">
            @endif
        </div>
        <div class="card-title mb-1">
            {{ $usuario->nombre_completo }}
        </div>
        <div class="text-secondary">
            {{ $usuario->correo_usuario }}
        </div>
    </div>
    <div class="progress card-progress">
        <div class="progress-bar bg-{{ session('tipo_vista') === 'alumno' ? 'teal' : 'orange' }}" style="width: 100%" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
</div>
