<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Sidebar extends Component
{
    public $usuario;
    public $persona;
    public $nombre;


    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    /* =============== EXTRAS =============== */

    public function redirigir_calificaciones()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('calificaciones');
    }

    public function redirigir_manuales()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('manuales');
    }



    public function mount()
    {
        $this->usuario = auth()->user();
        $this->persona = $this->usuario->persona;
        $this->nombre = strtoupper($this->persona->soloPrimerosNombres);
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
