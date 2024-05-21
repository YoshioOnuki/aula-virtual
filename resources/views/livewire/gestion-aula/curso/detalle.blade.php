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
                            <li class="breadcrumb-item">
                                @if(session('tipo_vista') == 'alumno')
                                    <a href="{{ route('cursos') }}">Mis Cursos</a>
                                @else
                                    <a href="{{ route('carga-academica') }}">Carga Académica</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Detalle
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        {{ $curso->nombre_curso }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="row g-3">
                        @forelse ($docente as $item)
                            <div class="col-12">
                                <a class="card card-link card-stacked">
                                    <div class="card-cover card-cover-blurred text-center"
                                        style="background-image: url({{ session('tipo_vista') == 'docente' ? config('settings.fondo_detalle_doncente') : config('settings.fondo_detalle_alumno') }})">
                                        @if (session('tipo_vista') == 'docente')
                                            <img src="{{ asset($item->usuario->mostrarFoto('docente')) }}"
                                                alt="avatar" class="avatar avatar-xl avatar-thumb rounded">
                                        @else
                                            <img src="{{ asset($item->usuario->mostrarFoto('alumno')) }}" alt="avatar"
                                                class="avatar avatar-xl avatar-thumb rounded">
                                        @endif
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="card-title mb-1">
                                            {{ $item->usuario->nombre_completo }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $item->usuario->persona->correo_persona }}
                                        </div>
                                        <div class="mt-2">
                                            <span
                                                class="badge {{ session('tipo_vista') == 'alumno' ? 'bg-teal-lt' : 'bg-yellow-lt' }}">
                                                {{ $item->rol->nombre_rol }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                    <div
                                        class="card-body d-flex flex-column align-items-center text-center text-muted fw-bold">
                                        Sin docente asignado
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="row g-3">
                        @if(session('tipo_vista') == 'alumno')
                            <div class="col-12">
                                <div class="card card-stacked animate__animated animate__fadeIn animate__faster mb-3">
                                    <div class="card-header" style="background: #e7f6f2;">
                                        <span class="text-teal me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                                <path d="M9 7l4 0" />
                                                <path d="M9 11l4 0" />
                                            </svg>
                                        </span>
                                        <h3 class="card-title text-teal fw-bold fs-2">Orientaciones Generales</h3>
                                    </div>
                                    <div class="card-body px-5">
                                        <span style="text-align: justify;" class="fs-3">
                                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laborum beatae commodi
                                            ullam harum! Mollitia impedit provident accusantium libero nam non officiis id
                                            vel voluptatibus ipsum dolorum ducimus reprehenderit, asperiores laboriosam!
                                            Totam quisquam voluptatibus perspiciatis id consequuntur consequatur, deserunt
                                            consectetur ea animi nemo porro quos! Eaque natus aliquam impedit molestiae illo
                                            tempore consequatur labore, quos voluptatem quia officiis eligendi facilis
                                            error!
                                            Voluptatum ipsa ipsam laborum rem, dolor cupiditate? Illo excepturi blanditiis
                                            voluptates harum minus cum ullam, soluta quisquam architecto est sunt rem, earum
                                            perspiciatis, laborum quae dolores consequatur consectetur corporis magni.
                                            Sapiente eligendi harum deserunt ducimus deleniti explicabo, doloribus
                                            repellendus dolorem fugit est illo voluptas fugiat recusandae expedita saepe
                                            magni culpa. Fugiat pariatur, id blanditiis quasi est ab harum quae numquam.
                                            Atque quae eum animi. Saepe ut, adipisci perferendis impedit exercitationem
                                            reprehenderit libero similique. Et cupiditate consequuntur perspiciatis quo
                                            quaerat unde. Hic quam voluptate accusamus labore voluptatum. Eveniet eaque
                                            obcaecati rem.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                                <div class="card-stamp card-stamp-lg">
                                    @if (session('tipo_vista') == 'docente')
                                        <div class="card-stamp-icon bg-yellow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-align-box-left-middle">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                <path d="M9 15h-2" />
                                                <path d="M13 12h-6" />
                                                <path d="M11 9h-4" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="card-stamp-icon bg-teal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                    @endif
                                </div>
                                <div class="card-body d-flex justify-content-center">
                                    <div class="row g-3">
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro-info.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Silabus
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro-info.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Silabus
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Lecturas
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Lecturas
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-foro-discusion.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Foro
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-foro-discusion.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Foro
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>


                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-matricula.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Asistencia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-matricula.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Asistencia
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-curso-por-internet.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Trabajos Académicos
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-curso-por-internet.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Trabajos Académicos
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <div class="">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-ubicacion-ip.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Webgrafía
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <span class="hide-theme-light">
                                                <div class="dark-mode">
                                                    <div class="image-button {{ session('tipo_vista') == 'alumno' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-ubicacion-ip.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Webgrafía
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
