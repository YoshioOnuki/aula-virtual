<div class="card card-stacked animate__animated animate__fadeIn">
    <div class="card-header bg-blue-lt">
        <h4 class="card-title fw-semibold">Navegación</h4>
    </div>
    <div class="list-group list-group-flush fs-4">
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">
            Detalle del Curso
        </a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">
            Silabus
        </a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">
            Recursos
        </a>
        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            Foro
        </a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">
            Asistencia
        </a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">
            Trabajos Académicos
        </a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">
            Webgrafía
        </a>
        {{-- @if ($tipo_vista === 'carga-academica' &&
            ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) ||
            $usuario->esRolGestionAula('DOCENTE INVITADO', $id_gestion_aula_usuario))) --}}
            <a href="#" class="list-group-item list-group-item-action" aria-current="false">
                Alumnos
            </a>
        {{-- @endif --}}

    </div>
</div>
