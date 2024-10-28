<?php

namespace App\Livewire\Components\Curso;

use App\Models\GestionAula;
use Livewire\Component;

class CardPresentacion extends Component
{
    public $id_gestion_aula;
    public $orientaciones_generales;
    public $orientaciones_generales_bool;


    /**
     * Mostrar orientaciones generales o presentacion del curso
     */
    public function mostrar_orientaciones()
    {
        $gestion_aula = GestionAula::with([
            'presentacion' => function ($query) {
                $query->select('id_presentacion', 'descripcion_presentacion', 'id_gestion_aula');
            }
        ])->find($this->id_gestion_aula);

        $this->orientaciones_generales = $gestion_aula->presentacion ?? null;
    }


    /**
     * Placeholder para mostrar mientras se cargan los datos
     */
    public function placeholder()
    {
        return <<<'HTML'
            <div class="card card-stacked placeholder-glow">
                <div class="card-header bg-teal-lt">
                    <div class="placeholder col-5 bg-teal" style="height: 1.5rem; width: 217.16px;">
                    </div>
                </div>
                <div class="card-body px-5">
                    <div class="placeholder col-12"></div>
                    <div class="placeholder col-10"></div>
                    <div class="placeholder col-12"></div>
                    <div class="placeholder col-11"></div>
                    <div class="placeholder col-7"></div>
                </div>
            </div>
        HTML;
    }


    public function mount($id_gestion_aula)
    {
        $this->id_gestion_aula = $id_gestion_aula;
        $this->mostrar_orientaciones();
    }


    public function render()
    {
        return view('livewire.components.curso.card-presentacion');
    }
}
