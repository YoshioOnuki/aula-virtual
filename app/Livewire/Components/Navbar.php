<?php

namespace App\Livewire\Components;

use App\Models\UsuarioRol;
use Livewire\Component;

class Navbar extends Component
{
    public $usuario;
    public $persona;
    public $nombre;

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function mount()
    {
        $this->usuario = auth()->user();
        $this->persona = $this->usuario->persona;
        $this->nombre = $this->persona->soloPrimerosNombres;
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
