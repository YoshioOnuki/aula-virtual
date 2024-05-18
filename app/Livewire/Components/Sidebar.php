<?php

namespace App\Livewire\Components;

use App\Models\UsuarioRol;
use Livewire\Component;

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

    public function mostrar_inicio()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('inicio');
    }

    public function mostrar_perfil()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('perfil');
    }

    public function mostrar_usuarios()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('usuarios');
    }

    public function mostrar_proceso()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('proceso');
    }

    public function mostrar_registro_alumnos()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('registro-alumnos');
    }

    public function mostrar_cursos()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('cursos');
    }

    public function mostrar_carga_academica()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'docente']);
        return redirect()->route('carga-academica');
    }

    public function mostrar_plan_estudio()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('plan-estudio');
    }

    public function mostrar_manuales()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
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
