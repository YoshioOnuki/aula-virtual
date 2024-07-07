<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{


    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Trabajo académico';
    public $links_page_header = [];
    public $regresar_page_header;


    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.index');
    }
}
