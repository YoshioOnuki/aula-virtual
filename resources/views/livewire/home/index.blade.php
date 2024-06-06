<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Inicio</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Bienvenido
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col col-md-8 col-lg-8 col-xl-8 col-sm-12 col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster mb-3">
                        <div class="card-header" style="background: rgb(12, 166, 120);">
                            <span class="text-white me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-wechat">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M16.5 10c3.038 0 5.5 2.015 5.5 4.5c0 1.397 -.778 2.645 -2 3.47l0 2.03l-1.964 -1.178a6.649 6.649 0 0 1 -1.536 .178c-3.038 0 -5.5 -2.015 -5.5 -4.5s2.462 -4.5 5.5 -4.5z" />
                                    <path
                                        d="M11.197 15.698c-.69 .196 -1.43 .302 -2.197 .302a8.008 8.008 0 0 1 -2.612 -.432l-2.388 1.432v-2.801c-1.237 -1.082 -2 -2.564 -2 -4.199c0 -3.314 3.134 -6 7 -6c3.782 0 6.863 2.57 7 5.785l0 .233" />
                                    <path d="M10 8h.01" />
                                    <path d="M7 8h.01" />
                                    <path d="M15 14h.01" />
                                    <path d="M18 14h.01" />
                                </svg>
                            </span>
                            <h3 class="card-title text-white fw-bold fs-2">Comunicados</h3>
                        </div>
                        <div class="card-body">
                            <div id="carousel-indicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carousel-indicators" data-bs-slide-to="0"
                                        class=" active"></button>
                                    <button type="button" data-bs-target="#carousel-indicators" data-bs-slide-to="1"
                                        class=""></button>
                                    <button type="button" data-bs-target="#carousel-indicators" data-bs-slide-to="2"
                                        class=""></button>
                                    <button type="button" data-bs-target="#carousel-indicators" data-bs-slide-to="3"
                                        class=""></button>
                                    <button type="button" data-bs-target="#carousel-indicators" data-bs-slide-to="4"
                                        class=""></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" alt=""
                                            src="assets/static/photos/home-office-desk-with-macbook-iphone-calendar-watch-and-organizer.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt=""
                                            src="assets/static/photos/young-woman-working-in-a-cafe.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt=""
                                            src="assets/static/photos/everything-you-need-to-work-from-your-bed.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt=""
                                            src="assets/static/photos/young-entrepreneur-working-from-a-modern-cafe.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt=""
                                            src="assets/static/photos/finances-us-dollars-and-bitcoins-currency-money-2.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster mb-3">
                        <div class="card-header" style="background: rgb(12, 166, 120);">
                            <h3 class="card-title text-white fw-bold fs-2">Autoridades</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-cent justify-content-center gap-5 ">
                                @forelse($autoridades_model as $item)
                                    <div class="form-selectgroup-label-content d-flex align-items-start">
                                        <img src="{{ asset($item->mostrar_foto ?? '/media/avatar-none.webp') }}" alt="avatar"
                                            class="avatar me-3 rounded-circle">
                                        <div>
                                            <div class="fs-3">{{ $item->nombre_autoridad }}</div>
                                            <div class="text-muted fs-4">
                                                {{ $item->cargo->nombre_cargo }}
                                                {{ $item->facultad ? 'de la ' . $item->facultad->nombre_facultad : '' }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                <div class="form-selectgroup-label-content d-flex align-items-start">
                                    <div class="fs-3 text-center">
                                        No se encontraron Autoridades.
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
