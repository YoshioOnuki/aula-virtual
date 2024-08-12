<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardTrabajoAcademico extends Component
{

    public $trabajo_academico;
    public $tipo_vista;
    public $usuario;
    public $id_gestion_aula_usuario;


    public function abrir_modal($id_trabajo_academico)
    {
        $this->dispatch('abrir-modal-editar', $id_trabajo_academico);
    }

    public function mount($trabajo_academico, $tipo_vista, $usuario, $id_gestion_aula_usuario)
    {
        $this->trabajo_academico = $trabajo_academico;
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
    }

    public function render()
    {
        return view('livewire.components.card-trabajo-academico');
    }
}
