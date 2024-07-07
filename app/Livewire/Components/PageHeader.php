<?php

namespace App\Livewire\Components;

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


    public function render()
    {
        return view('livewire.components.page-header');
    }
}
