<div class="col-6 col-md-4 col-lg-4 col-xl-3 animate__animated animate__zoomIn animate__faster">
    <div class="d-flex justify-content-center">
        <div
            @if ($opcion['ruta'] === '#modal-link-clase' || $opcion['ruta'] === '#modal-orientaciones')
                data-bs-toggle="modal" data-bs-target="{{ $opcion['ruta'] }}"
            @else
                wire:target="redirigir_opcion_curso"
                wire:loading.class="opacity-50 cursor-progress"
                wire:loading.class.remove="image-button-hover image-button-alumno-hover image-button-docente-hover"
            @endif
            wire:click="redirigir_opcion_curso('{{ $opcion['ruta'] }}')"
            class="text-dark image-button image-button-hover border border-2 border-{{ $tipo_vista ==='cursos' ? 'teal' : 'orange' }} rounded-3
            {{ $tipo_vista ==='cursos' ? 'image-button-alumno-hover' : 'image-button-docente-hover'}}
            d-flex justify-content-center align-items-center {{ $opcion['notificacion'] ? 'position-relative' : '' }}"
            style="width: 140px; height: 160px;">
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <img src="{{ $opcion['icono'] }}" alt="Info"
                        class="p-0"
                        style="width: 80px; height: 80px;">
                </div>
                <div class="col-12 mt-2">
                    <div class="text-content text-center fw-semibold fs-3 d-flex justify-content-center align-items-center">
                        {{ $opcion['nombre'] }}
                    </div>
                </div>
            </div>
            @if ($opcion['notificacion'])
                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
            @endif
        </div>
    </div>

    @if ($opcion['ruta'] !== '#modal-link-clase' && $opcion['ruta'] !== '#modal-orientaciones')
        <!-- Spinner de carga que aparece inmediatamente antes de redirigir -->
        <div class="position-absolute top-50 start-50 translate-middle"
            wire:loading wire:target="redirigir_opcion_curso">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
    @endif
</div>
