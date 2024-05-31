<?php

namespace App\Livewire\Configuracion\Usuario;

use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;

    #[Url('buscar')]
    public $search = '';

    public $titulo_modal = 'Estado de Usuario';
    public $accion_estado = 'Habilitar';


    public function abrir_modal()
    {
        $this->dispatch(
            'modal',
            modal: '#modal-estado-usuario',
            action: 'show'
        );


    }

    public function render()
    {
        $usuarios = Usuario::search($this->search)
            ->orderBy('id_usuario', 'desc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.configuracion.usuario.index',[
            'usuarios' => $usuarios,
        ]);
    }
}
