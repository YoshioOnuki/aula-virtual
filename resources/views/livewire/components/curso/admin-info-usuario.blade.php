<div>
    <div class="card card-stacked  mb-3 animate__animated animate__fadeIn animate__faster">
        <div class="progress card-progress h-2">
            <div class="progress-bar bg-{{ $tipo_vista === 'cursos' ? 'teal-lt' : 'orange-lt' }}" style="width: 100%"
                role="progressbar" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>

        <div class="card-body">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    @if ($tipo_vista === 'cursos')
                        <img src="{{ asset($usuario->mostrarFoto('alumno')) }}" alt="avatar"
                            class="avatar avatar-md avatar-thumb rounded">
                    @elseif($tipo_vista === 'carga-academica')
                        <img src="{{ asset($usuario->mostrarFoto('docente')) }}" alt="avatar"
                            class="avatar avatar-md avatar-thumb rounded">
                    @endif
                    {{-- <span class="avatar avatar-md" style="background-image: url(...)"></span> --}}
                </div>
                <div class="col">
                    <h2 class="page-title">
                        {{ $usuario->nombre_completo }}
                    </h2>
                    <div class="page-subtitle">
                        <div class="row">
                            <div class="col-auto">
                                <a href="mailto:{{ $usuario->correo_usuario }}" class="text-reset">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>
                                    {{ $usuario->correo_usuario }}
                                </a>
                            </div>
                            <div class="col-auto">
                                <a class="text-reset cursor-pointer copy-to-clipboard" id="copy-text"
                                    onclick="copyToClipboard('{{ $usuario->persona->documento_persona }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M15 8l2 0" />
                                        <path d="M15 12l2 0" />
                                        <path d="M7 16l10 0" />
                                    </svg>
                                    {{ $usuario->persona->documento_persona }}
                                </a>
                                <span id="copy-success" class="text-primary" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-copy-check">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                        <path
                                            d="M4.012 16.737a2 2 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                        <path d="M11 14l2 2l4 -4" />
                                    </svg>
                                    Copiado
                                </span>
                            </div>
                            <div class="col-auto text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-rosette-discount-check">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                                </svg>
                                Verificado
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-azure d-none d-md-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                            <path d="M10 16h6" />
                            <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M4 8h3" />
                            <path d="M4 12h3" />
                            <path d="M4 16h3" />
                        </svg>
                        Ver perfil
                    </a>

                    <a href="#"
                    class="btn btn-azure d-md-none btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                            <path d="M10 16h6" />
                            <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M4 8h3" />
                            <path d="M4 12h3" />
                            <path d="M4 16h3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Elementos de texto y éxito
        var textElement = document.getElementById('copy-text');
        var successElement = document.getElementById('copy-success');

        // Ocultar el texto original y mostrar el mensaje de éxito
        textElement.style.display = 'none';
        successElement.style.display = 'inline';

        // Después de 1 segundos, revertir los cambios
        setTimeout(function() {
            textElement.style.display = 'inline';
            successElement.style.display = 'none';
        }, 1000);
    }).catch(function(err) {
        console.error('Error al copiar al portapapeles: ', err);
    });
}
</script>
@endpush
