<?php

namespace App\Livewire\Components\Curso;

use Livewire\Component;

class OpcionCurso extends Component
{
    public $opcion;
    public $tipo_vista;


    /**
     * Función para redirigir a la opción seleccionada
     */
    public function redirigir_opcion_curso($ruta)
    {
        if ($this->opcion['ruta'] === '#modal-link-clase') {
            // Emitir evento para abrir modal de link de clase
            return $this->dispatch('abrir-modal-link-clase');
        } else if ($this->opcion['ruta'] === '#modal-orientaciones') {
            // Emitir evento para abrir modal de orientaciones
            return $this->dispatch('abrir-modal-orientaciones');
        }

        return redirect()->to($ruta);
    }


    /**
     * Placeholder para mostrar mientras se carga la información
     */
    public function placeholder()
    {
        return <<<'HTML'
            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                <div class="d-flex justify-content-center">
                    <div class="placeholder-glow cursor-progress rounded-3">
                        <div class="ratio card-img-top placeholder rounded-3"
                            style="width: 140px; height: 160px;"></div>
                    </div>
                </div>
            </div>
        HTML;
    }


    public function mount($opcion, $tipo_vista)
    {
        $this->opcion = $opcion;
        $this->tipo_vista = $tipo_vista;
    }


    public function render()
    {
        return view('livewire.components.curso.opcion-curso');
    }
}
