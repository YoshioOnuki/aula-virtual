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

    public function redirigir_inicio()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('inicio');
    }

    /* =============== SEGURIDAD Y CONFIGURACION =============== */

    public function redirigir_perfil()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('perfil');
    }

    public function redirigir_usuarios()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('usuarios');
    }

    public function redirigir_registro_alumnos()
    {
        return redirect()->route('registro-alumnos');
    }

    public function redirigir_autoridades()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('autoridades');
    }


    /* =============== BUSQUEDA DE ALUMNOS Y DOCENTES =============== */
    public function redirigir_alumnos()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('alumnos');
    }

    public function redirigir_docentes()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('docentes');
    }


    /* =============== ESTRUCTURA ACADEMICA =============== */

    public function redirigir_estructura_nivel_academico()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('estructura-academica.nivel-academico');
    }

    public function redirigir_estructura_tipo_programa()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('estructura-academica.tipo-programa');
    }

    public function redirigir_estructura_facultad()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('estructura-academica.facultad');
    }

    public function redirigir_estructura_programa()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('estructura-academica.programa');
    }


    /* =============== GESTION DEL CURSO =============== */

    public function redirigir_gestion_plan_estudio()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('gestion-curso.plan-estudio');
    }

    public function redirigir_gestion_ciclo()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('gestion-curso.ciclo');
    }

    public function redirigir_gestion_proceso()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('gestion-curso.proceso');
    }

    public function redirigir_gestion_curso()
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        return redirect()->route('gestion-curso.curso');
    }


    /* =============== GESTION ACADEMICA =============== */

    public function redirigir_cursos($id)
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        $id_usuario = Hashids::encode($id);
        return redirect()->route('cursos', ['id_usuario' => $id_usuario, 'tipo_vista' => 'cursos']);
    }

    public function redirigir_carga_academica($id)
    {
        //Limpiar la sesión
        session()->forget('modo_admin');
        $id_usuario = Hashids::encode($id);
        return redirect()->route('carga-academica', ['id_usuario' => $id_usuario, 'tipo_vista' => 'carga-academica']);
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
