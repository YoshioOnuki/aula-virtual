<?php

namespace App\Livewire\Components\TrabajoAcademico;

use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardRevisarTrabajo extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula_usuario;


    public function mount($tipo_vista, $usuario, $id_gestion_aula_usuario)
    {
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);

    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-revisar-trabajo');
    }
}
