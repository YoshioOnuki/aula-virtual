<?php

namespace App\Livewire\Components\Navegacion;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{

    public $usuario;
    public $persona;
    public $nombre;


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function mount()
    {
        $user = Auth::user();
        $this->usuario = $user;
        $this->persona = $this->usuario->persona;
        $this->nombre = strtoupper($this->persona->soloPrimerosNombres);
    }


    public function render()
    {
        return view('livewire.components.navegacion.sidebar');
    }
}
