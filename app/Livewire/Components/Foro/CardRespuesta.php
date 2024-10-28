<?php

namespace App\Livewire\Components\Foro;

use App\Models\ForoRespuesta;
use Livewire\Component;

class CardRespuesta extends Component
{
    public $tipo_vista;
    public $id_gestion_aula_alumno;
    public $foro_respuesta;

    public $es_propietario = false;


    /**
     * Evento para abrir modal de eliminación de respuesta
     */
    public function eliminar_respuesta()
    {
        $this->dispatch('abrir_modal_eliminar_respuesta', $this->foro_respuesta->id_foro_respuesta);
    }

    /**
     * Placeholder para mostrar mientras se cargan los datos
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
                    <div class="d-none d-sm-block">
                        <div class="col-12"></div>
                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                        </div>
                        <div class="col-12"></div>
                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }

    public function mount($tipo_vista, $id_gestion_aula_alumno, $foro_respuesta)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_alumno = $id_gestion_aula_alumno;
        $this->foro_respuesta = ForoRespuesta::with('gestionAulaAlumno.usuario')->find($foro_respuesta->id_foro_respuesta);
        $this->es_propietario = $this->foro_respuesta->id_gestion_aula_alumno === $this->id_gestion_aula_alumno;
    }


    public function render()
    {
        return view('livewire.components.foro.card-respuesta');
    }
}
