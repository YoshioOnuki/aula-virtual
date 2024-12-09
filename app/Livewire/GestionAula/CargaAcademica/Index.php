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
    public $mostrar_paginate = 8;
    #[Url(except: '', as: 'buscar')]
    public $search = '';
    #[Url(except: '', as: 'tipo-programa')]
    public $filtro_tipo_programa = ''; // Tipo de programa (Doctorado, Maestría, etc.)
    #[Url(except: '', as: 'facultad')]
    public $filtro_facultad = '';// Facultad (Ingeniería, Ciencias, etc.)
    #[Url(except: '', as: 'programa')]
    public $filtro_programa = ''; // Programa (Ingeniería de Sistemas, Educacion, etc.)
    #[Url(except: '', as: 'ciclo')]
    public $filtro_ciclo = ''; // Ciclo (I, II, III, etc.)
    #[Url(except: '', as: 'plan-estudio')]
    public $filtro_plan_estudio = ''; // Plan de estudio (2010, 2015, etc.)
    #[Url(except: '', as: 'proceso')]
    public $filtro_proceso = ''; // Proceso (2021-1, 2021-2, etc.)
    #[Url(except: '', as: 'en-curso')]
    public $filtro_en_curso = ''; // Filtro para mostrar cursos en curso o finalizados

    public $filtro_activo = false;

    public $tipo_vista_curso = 'carga-academica';

    // Variables para page-header
    public $titulo_page_header = 'LISTA DE CURSOS - CARGA ACADÉMICA';
    public $links_page_header = [];
    public $regresar_page_header;


    private function validar_facultad($facultades)
    {
        // Verificar si la facultad seleccionada es válida
        $facultadValida = $facultades->contains(fn($facultad) => intval($facultad->id_facultad) === intval($this->filtro_facultad));

        // Si la facultad no es válida, limpiar el filtro
        if (!$facultadValida) {
            $this->filtro_facultad = '';
        }
    }


    public function validar_programa($programas)
    {
        // Verificar si el programa seleccionado es válido
        $programaValido = $programas->contains(fn($programa) => intval($programa->id_programa) === intval($this->filtro_programa));

        // Si el programa no es válido, limpiar el filtro
        if (!$programaValido) {
            $this->filtro_programa = '';
        }
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

        $facultades = $this->filtro_tipo_programa !== ''
            ? Programa::with('facultad')
                ->estado(true)
                ->tipoPrograma($this->filtro_tipo_programa)
                ->get()
                ->pluck('facultad')
                ->unique()
            : Facultad::estado(true)->get();

        $this->validar_facultad($facultades);

        if ($this->filtro_facultad != '' && $this->filtro_tipo_programa != '') {
            $programas = Programa::estado(true)->facultad($this->filtro_facultad)->tipoPrograma($this->filtro_tipo_programa)->get();
            $this->validar_programa($programas);
        } else {
            $programas = [];
            $this->filtro_programa = '';
        }
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
