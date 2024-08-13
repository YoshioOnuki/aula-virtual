<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardTrabajoAcademico extends Component
{

    public $trabajos_academicos;
    public $tipo_vista;
    public $usuario;
    public $id_gestion_aula_usuario;


    public function abrir_modal($id_trabajo_academico)
    {
        $this->dispatch('abrir-modal-editar', $id_trabajo_academico);
    }

    public function mount($trabajos_academicos, $tipo_vista, $usuario, $id_gestion_aula_usuario)
    {
        $this->trabajos_academicos = $trabajos_academicos;
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
    }

    public function render()
    {
        return view('livewire.components.card-trabajo-academico');
    }
}
