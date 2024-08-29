<div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">

                        @foreach ($linksArray as $item)
                            <li class="breadcrumb-item">
                                <a href="{{ route($item['route'], $item['params']) }}">
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endforeach

                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="#">
                                {{ $titulo_pasos }}
                            </a>
                        </li>
                    </ol>
                </div>
                <h2 class="page-title text-uppercase">
                    {{ $titulo }}
                </h2>
            </div>
            @if($regresar)
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route($regresar['route'], $regresar['params']) }}"
                    class="btn btn-secondary d-none d-md-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                        Regresar
                    </a>

                    <a href="{{ route($regresar['route'], $regresar['params']) }}"
                    class="btn btn-secondary d-md-none btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
