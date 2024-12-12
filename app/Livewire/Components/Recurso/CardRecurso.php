<?php

namespace App\Livewire\Components\Recurso;

use App\Models\Recurso;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;

#[Lazy(isolate: false)]
class CardRecurso extends Component
{
    public $tipo_vista;
    public $recurso;
    public $usuario;
    public $id_gestion_aula;
    public $es_docente;


    /**
     * Cargar recursos
     */
    #[On('load-recursos')]
    public function load_recursos()
    {
        $this->mount($this->tipo_vista, $this->usuario, $this->id_gestion_aula, $this->recurso);
    }


    /**
     * Abrir modal para editar un recurso
     */
    public function abrir_modal_recurso_editar(Recurso $recurso)
    {
        $this->dispatch('abrir-modal-recurso-editar', $recurso);
    }


    /**
     * Descargar recurso
     */
    public function descargar_recurso(Recurso $recurso)
    {
        $ruta = $recurso->archivo_recurso;
        return response()->download($ruta, $recurso->nombre_recurso.'.'.pathinfo($ruta, PATHINFO_EXTENSION));
    }


    /**
     * Placeholder para la carga de datos
     */
    public function placeholder()
    {
        return <<<'HTML'
            <div class="col-12">
                <div class="card placeholder-glow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-5">
                            <div class="placeholder col-6" style="height: 1.5rem;"></div>
                            <div class="placeholder"></div>
                        </div>
                        <div>
                            <div class="col-12"></div>
                            <div class="placeholder placeholder-xs col-4 bg-secondary">
                            </div>
                            <div class="col-12"></div>
                            <div class="placeholder placeholder-xs col-4 bg-secondary">
                            </div>
                        </div>
                        <div class=" d-flex justify-content-end">
                            <a href="#" tabindex="-1"
                                class="btn btn-secondary disabled placeholder col-sm-2 col-lg-3 col-xl-2 d-none d-md-inline-block me-2"
                                aria-hidden="true"></a>
                            <a href="#" tabindex="-1"
                                class="btn btn-secondary disabled placeholder col-1 d-md-none btn-icon me-2"
                                aria-hidden="true"></a>

                            <a href="#" tabindex="-1"
                                class="btn btn-primary disabled placeholder col-sm-3 col-lg-4 col-xl-2 d-none d-md-inline-block"
                                aria-hidden="true"></a>
                            <a href="#" tabindex="-1"
                                class="btn btn-primary disabled placeholder col-1 d-md-none btn-icon"
                                aria-hidden="true"></a>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }


    public function mount($tipo_vista, $usuario, $id_curso, $recurso)
    {
        $this->tipo_vista = $tipo_vista;
        $this->recurso = $recurso;
        $this->usuario = $usuario;
        $this->id_gestion_aula = $id_curso;
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
    }


    public function render()
    {
        return view('livewire.components.recurso.card-recurso');
    }
}
