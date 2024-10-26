<?php

namespace App\Livewire\Components\Foro;

use App\Models\Foro;
use Livewire\Component;

class CardDetalleForo extends Component
{
    public $tipo_vista;
    public $id_gestion_aula;
    public $foro;


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


    public function mount($tipo_vista, $foro)
    {
        $this->tipo_vista = $tipo_vista;
        $this->foro = Foro::with([
            'gestionAulaDocente' => function ($query) {
                $query->with('usuario');
            }
        ])->find($foro->id_foro);
    }


    public function render()
    {
        return view('livewire.components.foro.card-detalle-foro');
    }
}
