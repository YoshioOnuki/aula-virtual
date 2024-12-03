<?php

namespace App\Livewire\GestionAula\CargaAcademica;

use App\Models\Ciclo;
use App\Models\Facultad;
use App\Models\GestionAula;
use App\Models\PlanEstudio;
use App\Models\Proceso;
use App\Models\Programa;
use App\Models\TipoPrograma;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url(except: '', as: 'buscar')]
    public $search = '';
    #[Url(except: '', as: 'tipo-programa')]
    public $filtro_tipo_programa = ''; // Tipo de programa (Doctorado, Maestría, etc.)
    public $cbo_tipo_programa;
    #[Url(except: '', as: 'facultad')]
    public $filtro_facultad = '';// Facultad (Ingeniería, Ciencias, etc.)
    public $cbo_facultad;
    #[Url(except: '', as: 'programa')]
    public $filtro_programa = ''; // Programa (Ingeniería de Sistemas, Educacion, etc.)
    public $cbo_programa;
    #[Url(except: '', as: 'ciclo')]
    public $filtro_ciclo = ''; // Ciclo (I, II, III, etc.)
    public $cbo_ciclo;
    #[Url(except: '', as: 'plan-estudio')]
    public $filtro_plan_estudio = ''; // Plan de estudio (2010, 2015, etc.)
    public $cbo_plan_estudio;
    #[Url(except: '', as: 'proceso')]
    public $filtro_proceso = ''; // Proceso (2021-1, 2021-2, etc.)
    public $cbo_proceso;
    #[Url(except: '', as: 'en-curso')]
    public $filtro_en_curso = ''; // Filtro para mostrar cursos en curso o finalizados
    public $cbo_en_curso;

    public $tipo_vista_curso = 'carga-academica';

    // Variables para page-header
    public $titulo_page_header = 'LISTA DE CURSOS - CARGA ACADÉMICA';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Función para limpiar los filtros
     */
    public function limpiar_filtros()
    {
        $this->cbo_tipo_programa = '';
        $this->cbo_facultad = '';
        $this->cbo_programa = '';
        $this->cbo_ciclo = '';
        $this->cbo_plan_estudio = '';
        $this->cbo_proceso = '';
        $this->cbo_en_curso = '';

        $this->filtro_tipo_programa = '';
        $this->filtro_facultad = '';
        $this->filtro_programa = '';
        $this->filtro_ciclo = '';
        $this->filtro_plan_estudio = '';
        $this->filtro_proceso = '';
        $this->filtro_en_curso = '';
    }

    /**
     * Función para filtrar los cursos
     */
    public function filtrar()
    {

        if ($this->cbo_programa && $this->cbo_facultad) {
            $this->filtro_programa = $this->cbo_programa;
            $this->filtro_facultad = '';
            $this->cbo_facultad = '';
        }
        
        $this->filtro_tipo_programa = $this->cbo_tipo_programa ?? '';
        $this->filtro_facultad = $this->cbo_facultad ?? '';
        $this->filtro_programa = $this->cbo_programa ?? '';
        $this->filtro_ciclo = $this->cbo_ciclo ?? '';
        $this->filtro_plan_estudio = $this->cbo_plan_estudio ?? '';
        $this->filtro_proceso = $this->cbo_proceso ?? '';
        $this->filtro_en_curso = $this->cbo_en_curso ?? '';
    }


    /**
     * Función para mostrar precargar los filtros
     */
    public function pre_cargar_filtros()
    {
        $this->cbo_tipo_programa = $this->filtro_tipo_programa;
        $this->cbo_facultad = $this->filtro_facultad;
        $this->cbo_programa = $this->filtro_programa;
        $this->cbo_ciclo = $this->filtro_ciclo;
        $this->cbo_plan_estudio = $this->filtro_plan_estudio;
        $this->cbo_proceso = $this->filtro_proceso;
        $this->cbo_en_curso = $this->filtro_en_curso;
    }


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
        $this->pre_cargar_filtros();
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
            ->proceso($this->filtro_proceso)
            ->enCurso($this->filtro_en_curso)
            ->paginate($this->mostrar_paginate);

        $tipo_programas = TipoPrograma::estado(true)->get();
        $facultades = Facultad::estado(true)->get();
        $programas = Programa::estado(true)->get();
        $ciclos = Ciclo::estado(true)->get();
        $planes_estudio = PlanEstudio::estado(true)->get();
        $procesos = Proceso::estado(true)->get();

        return view('livewire.gestion-aula.carga-academica.index', compact([
            'cursos',
            'tipo_programas',
            'facultades',
            'programas',
            'ciclos',
            'planes_estudio',
            'procesos'
        ]));
    }
}
