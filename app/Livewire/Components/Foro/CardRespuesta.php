<?php

namespace App\Livewire\Components\Foro;

use App\Models\ForoRespuesta;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardRespuesta extends Component
{
    public $id_usuario_hash;
    public $usuario;
    public $tipo_vista;
    public $id_gestion_aula_hash;
    public $id_gestion_aula_alumno;
    public $foro_respuesta;
    public $modo_respuesta;
    public $nivel;

    public $es_propietario = false;
    public $es_alumno = false;


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
            <div class="card placeholder-glow" style="margin-left: {{ $modo_respuesta ? 0 :$nivel * 2 }}rem;">
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


    public function mount($usuario, $tipo_vista, $id_curso, $id_gestion_aula_alumno, $foro_respuesta, $modo_respuesta, $nivel = 0)
    {
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);
        $this->usuario = $usuario;
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula_alumno = $id_gestion_aula_alumno;
        $this->foro_respuesta = ForoRespuesta::with('gestionAulaAlumno.usuario', 'hijos')->find($foro_respuesta->id_foro_respuesta);
        $this->modo_respuesta = $modo_respuesta === 1 ? true : false;
        $this->es_propietario = $this->foro_respuesta->id_gestion_aula_alumno === $this->id_gestion_aula_alumno;
        $id_gestion_aula = Hashids::decode($id_curso)[0];
        $this->es_alumno = $usuario->esAlumno($id_gestion_aula);
        $this->nivel = $nivel;
    }


    public function render()
    {
        return view('livewire.components.foro.card-respuesta');
    }
}
