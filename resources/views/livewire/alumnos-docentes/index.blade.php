<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-12">
                    <livewire:alumnos-docentes.buscar :tipo_vista="$tipo_vista" lazy />
                </div>
            </div>
        </div>
    </div>

</div>
