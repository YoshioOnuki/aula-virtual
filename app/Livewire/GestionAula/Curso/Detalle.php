<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\Curso;
use App\Models\GestionAulaUsuario;
use Livewire\Component;

class Detalle extends Component
{

    public $curso;

    public function mount()
    {
        $gest_aula_usua = GestionAulaUsuario::find(session('id_gestion_aula_usuario'));
        $this->curso = $gest_aula_usua->gestionAula->curso;
    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
