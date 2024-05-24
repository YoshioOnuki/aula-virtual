<?php

namespace App\Livewire\Configuracion\Usuario;

use App\Models\Usuario;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    #[Url('mostrar')]
    public $mostrar_paginacion;

    public $usuarios;

    public $search;


    public function render()
    {
        $this->usuarios = Usuario::all();
        // where('estado_usuario', 1)
        //     ->paginate($this->mostrar_paginacion);

        return view('livewire.configuracion.usuario.index');
    }
}
