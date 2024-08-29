<?php

namespace App\Livewire\Components\Navegacion;

use Livewire\Component;

class PageHeader extends Component
{

    public $titulo_pasos;
    public $titulo;
    public $linksArray = [];
    public $regresar;


    public function mount($titulo, $links_array, $regresar, $titulo_pasos)
    {
        $this->titulo_pasos = $titulo_pasos;
        $this->titulo = $titulo;
        $this->regresar = $regresar;
        $this->linksArray = $links_array;
    }


    public function placeholder()
    {
        return <<<'HTML'
        <div class="my-5 d-flex justify-content-center">
            <div class="spinner-border text-blue" role="status"></div>
        </div>
        HTML;
    }


    public function render()
    {
        return view('livewire.components.navegacion.page-header');
    }
}
