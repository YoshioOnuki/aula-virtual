<?php

namespace App\Livewire\Components\Foro;

use App\Models\Foro;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardDetalleForo extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula;
    public $id_gestion_aula_hash;
    public $foro;
    public $modo_respuesta;
    public $es_docente = false;


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


    /**
     * Obtener el foro
     */
    public function obtener_foro($foro)
    {
        $this->foro = Foro::with([
            'gestionAulaDocente' => function ($query) {
                $query->with('usuario');
            }
        ])->find($foro->id_foro);
    }


    public function mount( $usuario, $tipo_vista, $id_curso, $foro, $modo_respuesta)
    {
        $this->usuario = $usuario;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = Hashids::decode($id_curso)[0];
        $this->obtener_foro($foro);
        $this->modo_respuesta = $modo_respuesta === 1 ? true : false;

        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
    }


    public function render()
    {
        return view('livewire.components.foro.card-detalle-foro');
    }
}
