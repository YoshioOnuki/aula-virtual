<div class="card card-stacked animate__animated animate__fadeIn">
    <div class="card-header bg-blue-lt">
        <h4 class="card-title fw-semibold">Navegación</h4>
    </div>
    <div class="list-group list-group-flush fs-4">

        <a href="{{ $tipo_vista === 'cursos' ?
                route('cursos.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' => $tipo_vista, 'id_curso' => $id_gestion_aula_hash] ) :
                route('carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' => $tipo_vista, 'id_curso' => $id_gestion_aula_hash] ) }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('cursos.detalle') ? 'active' : '' }}"
            aria-current="{{ request()->routeIs('cursos.show') ? 'true' : 'false' }}">
            Detalle del curso
        </a>

        @foreach ($links_array as $item)
            <a href="{{ route($item['route'], $item['params']) }}"
                class="list-group-item list-group-item-action {{ request()->routeIs($item['route'] . '*') ? 'active' : '' }}"
                aria-current="{{ request()->routeIs($item['route'] . '*') ? 'true' : 'false' }}">
                {{ $item['name'] }}
            </a>
        @endforeach

    </div>
</div>
