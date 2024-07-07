<?php

namespace App\Livewire\GestionAula\Webgrafia;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{


    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Webgrafía';
    public $links_page_header = [];
    public $regresar_page_header;


    public function render()
    {
        return view('livewire.gestion-aula.webgrafia.index');
    }
}
