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

    /* =============== SEGURIDAD Y CONFIGURACION =============== */

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

    public function mostrar_registro_alumnos()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('registro-alumnos');
    }

    public function mostrar_autoridades()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('autoridades');
    }


    /* =============== BUSQUEDA DE ALUMNOS Y DOCENTES =============== */
    public function mostrar_alumnos()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('alumnos');
    }

    public function mostrar_docentes()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'docente']);
        return redirect()->route('docentes');
    }


    /* =============== ESTRUCTURA ACADEMICA =============== */

    public function mostrar_nivel_academico()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.nivel-academico');
    }

    public function mostrar_tipo_programa()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.tipo-programa');
    }

    public function mostrar_facultad()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.facultad');
    }

    public function mostrar_programa()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.programa');
    }


    /* =============== GESTION DEL CURSO =============== */

    public function mostrar_plan_estudio()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.plan-estudio');
    }

    public function mostrar_ciclo()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.ciclo');
    }

    public function mostrar_proceso()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.proceso');
    }

    public function mostrar_curso()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.curso');
    }


    /* =============== GESTION ACADEMICA =============== */

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


    /* =============== EXTRAS =============== */

    public function mostrar_calificaciones()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('calificaciones');
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
        // dd($this->usuario->mostrar_foto);

    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
