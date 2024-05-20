<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows
                        " aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inicio') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Detalle
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Detalle - {{ $curso->nombre_curso }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                <div class="card-stamp card-stamp-lg">
                    <div class="card-stamp-icon bg-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-vocabulary">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z" />
                            <path d="M12 5v16" />
                            <path d="M7 7h1" />
                            <path d="M7 11h1" />
                            <path d="M16 7h1" />
                            <path d="M16 11h1" />
                            <path d="M16 15h1" />
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-1">
                            <div class="avatar avatar-xl ">
                                <img src="{{ $docente->usuario->mostrarFoto('docente') ?? asset('/media/avatar_none.webp') }}"
                                    alt="avatar" class="avatar avatar-xl ">
                            </div>
                        </div>
                        <div class="col-10 ms-5">
                            <h3 class="h1">{{ $docente->usuario->nombre_completo }}</h3>
                            <div>
                                <p class="text-justify">
                                    El Sistema de Obtención de Grado Académico (SIOGA) está diseñado para facilitar tu
                                    camino hacia la obtención de tu título universitario, proporcionándote las
                                    herramientas esenciales para gestionar tu proyecto de grado. Con SIOGA, puedes
                                    llevar a cabo tu investigación académica de manera online, accediendo de forma
                                    directa a los procesos de presentación, revisión, evaluación y aprobación de tu
                                    propuesta de tesis.
                                </p>
                                <strong>RECOMENDACIONES:</strong>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="badge bg-azure"></span></div>
                                            <div class="col text-truncate">
                                                <div class="text-reset d-block">Define claramente tu idea o tema de
                                                    investigación:</div>
                                                <div class="d-block text-secondary text-truncate">Un buen punto de
                                                    partida es esencial.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="badge bg-azure"></span></div>
                                            <div class="col text-truncate">
                                                <div class="text-reset d-block">Utiliza las Herramientas del Tesista:
                                                </div>
                                                <div class="d-block text-secondary text-truncate">Encuentra recursos
                                                    útiles en esta sección para apoyar tu investigación.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="badge bg-azure"></span></div>
                                            <div class="col text-truncate">
                                                <div class="text-reset d-block">Identifica tu Línea de Investigación:
                                                </div>
                                                <div class="d-block text-secondary text-truncate">Asegúrate de que tu
                                                    tema esté alineado con una de las líneas de investigación
                                                    reconocidas por la universidad.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="badge bg-azure"></span></div>
                                            <div class="col text-truncate">
                                                <div class="text-reset d-block">Selecciona tu Asesor de tesis:</div>
                                                <div class="d-block text-secondary text-truncate">Podrás elegir tu
                                                    asesor, mientras que los tres jurados de tesis serán asignados
                                                    aleatoriamente por la comisión de grados y títulos a través de
                                                    SIOGA.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-justify">
                                Para optimizar tu experiencia en SIOGA, te recomendamos leer el manual del tesista. <a
                                    href="#">Haz clic aquí</a> para más información.
                                <br> Sigue estas pautas para navegar el proceso académico con claridad y eficacia.
                                ¡SIOGA
                                está aquí para apoyarte en cada paso hacia tu logro académico!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






</div>
