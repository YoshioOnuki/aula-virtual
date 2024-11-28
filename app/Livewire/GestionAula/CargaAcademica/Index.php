<?php

namespace App\Livewire\GestionAula\CargaAcademica;

use App\Models\GestionAula;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';
    #[Url('filtro-tipo-programa')]
    public $filtro_tipo_programa; // Tipo de programa (Doctorado, Maestría, etc.)
    #[Url('filtro-facultad')]
    public $filtro_facultad;// Facultad (Ingeniería, Ciencias, etc.)
    #[Url('filtro-programa')]
    public $filtro_programa; // Programa (Ingeniería de Sistemas, Educacion, etc.)
    #[Url('filtro-ciclo')]
    public $filtro_ciclo; // Ciclo (I, II, III, etc.)
    #[Url('filtro-plan-estudio')]
    public $filtro_plan_estudio; // Plan de estudio (2010, 2015, etc.)
    #[Url('filtro-en-curso')]
    public $filtro_en_curso; // Filtro para mostrar cursos en curso o finalizados

    public $tipo_vista_curso = 'carga-academica';

    // Variables para page-header
    public $titulo_page_header = 'LISTA DE CURSOS - CARGA ACADÉMICA';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Obtener datos para mostrar el componente Page Header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'LISTA DE CURSOS - CARGA ACADÉMICA';

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];
    }


    public function mount()
    {
        $this->obtener_datos_page_header();
    }


    public function render()
    {
        $cursos = GestionAula::with(['curso'])
            ->whereHas('gestionAulaDocente', function ($query) {
                $query->estado(true);
            })
            ->estado(true)
            ->orderBy('created_at', 'desc')
            ->search($this->search)
            ->tipoPrograma($this->filtro_tipo_programa)
            ->facultad($this->filtro_facultad)
            ->programa($this->filtro_programa)
            ->ciclo($this->filtro_ciclo)
            ->planEstudio($this->filtro_plan_estudio)
            ->enCurso($this->filtro_en_curso)
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.carga-academica.index', compact('cursos'));
    }
}
