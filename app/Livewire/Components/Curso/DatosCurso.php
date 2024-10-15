<?php

namespace App\Livewire\Components\Curso;

use App\Models\GestionAula;
use App\Models\GestionAulaUsuario;
use Livewire\Component;

class DatosCurso extends Component
{

    public $curso;
    public $gestion_aula;
    public $ruta_pagina;
    public $id_gestion_aula;

    public $link_clase = ' ';

    public $datos = false;

    public $tipo_vista; // Para saber que tipo de vista se está mostrando

    protected $listeners = ['actualizar_datos_curso' => 'actualizar_datos_curso'];


    /**
     * Actualiza los datos del curso, renderizando la vista
     */
    public function actualizar_datos_curso()
    {
        $this->mount($this->id_gestion_aula, $this->ruta_pagina, $this->tipo_vista);
    }

    /**
     * Muestra los datos del curso
     */
    public function mostrar_datos_curso()
    {
        $this->gestion_aula = GestionAula::with([
            'curso' => function ($query) {
                $query->with([
                    'ciclo',
                    'planEstudio',
                    'programa' => function ($query) {
                        $query->with([
                            'facultad',
                            'tipoPrograma'
                        ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa', 'id_facultad');
                    }
                ])->select('id_curso', 'codigo_curso', 'nombre_curso', 'creditos_curso', 'horas_lectivas_curso', 'id_programa', 'id_plan_estudio', 'id_ciclo');
            },
            'linkClase' => function ($query) {
                $query->select('id_link_clase', 'id_gestion_aula', 'nombre_link_clase');
            }
        ])->find($this->id_gestion_aula);


        if ($this->gestion_aula) {
            $this->curso = $this->gestion_aula->curso;
        }
    }


    /**
     * Placeholder para mostrar mientras se cargan los datos
     */
    public function placeholder()
    {
        return <<<'HTML'
        <div class="card card-stacked placeholder-glow">
            <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                <div class="placeholder col-5 {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }}"
                style="height: 1.5rem; width: 170.56px;"></div>
            </div>
            <div class="card-body row g-3 mb-0">
                <div class="d-flex flex-column gap-2">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 148.94px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 148.94px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 117.06px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 43.3px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 122.21px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder col-12 bg-secondary" style="height: 17px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-start">
                            <div class="row g-2">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 34.20px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 57.86px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-end">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 40.07px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 104.33px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 64.44px;"></div>
                                </div>
                            </div>
                        </div>

                        @if($datos)
                            <div class="col-12">
                                <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-12 mt-1 mb-2" aria-hidden="true" style="height: 36px;"></a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        HTML;
    }


    public function mount($id_gestion_aula, $ruta_pagina, $tipo_vista)
    {
        $this->id_gestion_aula = $id_gestion_aula;
        $this->ruta_pagina = $ruta_pagina;
        $this->tipo_vista = $tipo_vista;

        if($ruta_pagina == 'carga-academica.detalle' || $ruta_pagina == 'cursos.detalle')
        {
            $this->datos = true;
        }

        $this->mostrar_datos_curso();
    }


    public function render()
    {
        return view('livewire.components.curso.datos-curso');
    }
}
