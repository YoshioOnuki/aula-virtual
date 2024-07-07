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
        session()->forget('tipo_vista');
        return redirect()->route('inicio');
    }

    /* =============== SEGURIDAD Y CONFIGURACION =============== */

    public function redirigir_perfil()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('perfil');
    }

    public function redirigir_usuarios()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('usuarios');
    }

    public function redirigir_registro_alumnos()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('registro-alumnos');
    }

    public function redirigir_autoridades()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('autoridades');
    }


    /* =============== BUSQUEDA DE ALUMNOS Y DOCENTES =============== */
    public function redirigir_alumnos()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('alumnos');
    }

    public function redirigir_docentes()
    {
        // Guardar en la sesión el tipo de vista
        session(['tipo_vista' => 'docente']);
        return redirect()->route('docentes');
    }


    /* =============== ESTRUCTURA ACADEMICA =============== */

    public function redirigir_nivel_academico()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.nivel-academico');
    }

    public function redirigir_tipo_programa()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.tipo-programa');
    }

    public function redirigir_facultad()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.facultad');
    }

    public function redirigir_programa()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('estructura-academica.programa');
    }


    /* =============== GESTION DEL CURSO =============== */

    public function redirigir_plan_estudio()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.plan-estudio');
    }

    public function redirigir_ciclo()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.ciclo');
    }

    public function redirigir_proceso()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.proceso');
    }

    public function redirigir_curso()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('gestion-curso.curso');
    }


    /* =============== GESTION ACADEMICA =============== */

    public function redirigir_cursos($id)
    {
        $id_usuario = Hashids::encode($id);
        session(['tipo_vista' => 'alumno']);
        return redirect()->route('cursos', ['id_usuario' => $id_usuario]);
    }

    public function redirigir_carga_academica($id)
    {
        $id_usuario = Hashids::encode($id);
        session(['tipo_vista' => 'docente']);
        return redirect()->route('carga-academica', ['id_usuario' => $id_usuario]);
    }


    /* =============== EXTRAS =============== */

    public function redirigir_calificaciones()
    {
        //Limpiar la sesión
        session()->forget('tipo_vista');
        return redirect()->route('calificaciones');
    }

    public function redirigir_manuales()
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
