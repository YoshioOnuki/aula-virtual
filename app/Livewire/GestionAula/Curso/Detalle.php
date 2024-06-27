<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Detalle extends Component
{

    public $id_gestion_aula_usuario;
    public $curso;
    public $gestion_aula_usuario;

    public $nombre_curso;
    public $grupo_gestion_aula;
    public $orientaciones_generales = ' ';

    public $cargando = true;
    public $cargando_orientaciones = true;

    public $usuario;
    public $modo_admin = false;



    public function mostrar_orientaciones()
    {
        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'presentacion' => function ($query) {
                        $query->select('id_presentacion', 'descripcion_presentacion', 'id_gestion_aula');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if ($gestion_aula_usuario->gestionAula->presentacion) {
            $this->orientaciones_generales = $gestion_aula_usuario->gestionAula->presentacion->descripcion_presentacion;
        }else{
            $this->orientaciones_generales = '';
        }
    }

    public function mostrar_titulo_curso()
    {
        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'curso' => function ($query) {
                        $query->select('id_curso', 'nombre_curso');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if ($gestion_aula_usuario) {
            $this->nombre_curso = $gestion_aula_usuario->gestionAula->curso->nombre_curso;
            $this->grupo_gestion_aula = $gestion_aula_usuario->gestionAula->grupo_gestion_aula;
        }
    }


    public function load_orientaciones()
    {
        $this->mostrar_orientaciones();
        $this->cargando_orientaciones = false;
    }


    public function mostrar_silabus($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('alumnos.cursos.detalle.silabus', ['id' => $id_url]);
            }else{
                return redirect()->route('cursos.detalle.silabus', ['id' => $id_url]);
            }
        }else{
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('docentes.carga-academica.detalle.silabus', ['id' => $id_url]);
            }else{
                return redirect()->route('carga-academica.detalle.silabus', ['id' => $id_url]);
            }
        }
    }

    public function mostrar_recursos($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('alumnos.cursos.detalle.recursos', ['id' => $id_url]);
            }else{
                return redirect()->route('cursos.detalle.recursos', ['id' => $id_url]);
            }
        }else{
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('docentes.carga-academica.detalle.recursos', ['id' => $id_url]);
            }else{
                return redirect()->route('carga-academica.detalle.recursos', ['id' => $id_url]);
            }
        }
    }

    public function mostrar_foro($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('alumnos.cursos.detalle.foro', ['id' => $id_url]);
            }else{
                return redirect()->route('cursos.detalle.foro', ['id' => $id_url]);
            }
        }else{
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('docentes.carga-academica.detalle.foro', ['id' => $id_url]);
            }else{
                return redirect()->route('carga-academica.detalle.foro', ['id' => $id_url]);
            }
        }
    }

    public function mostrar_asistencia($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('alumnos.cursos.detalle.asistencia', ['id' => $id_url]);
            }else{
                return redirect()->route('cursos.detalle.asistencia', ['id' => $id_url]);
            }
        }else{
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('docentes.carga-academica.detalle.asistencia', ['id' => $id_url]);
            }else{
                return redirect()->route('carga-academica.detalle.asistencia', ['id' => $id_url]);
            }
        }
    }

    public function mostrar_trabajo_academico($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('alumnos.cursos.detalle.trabajo-academico', ['id' => $id_url]);
            }else{
                return redirect()->route('cursos.detalle.trabajo-academico', ['id' => $id_url]);
            }
        }else{
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('docentes.carga-academica.detalle.trabajo-academico', ['id' => $id_url]);
            }else{
                return redirect()->route('carga-academica.detalle.trabajo-academico', ['id' => $id_url]);
            }
        }
    }

    public function mostrar_webgrafia($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('alumnos.cursos.detalle.webgrafia', ['id' => $id_url]);
            }else{
                return redirect()->route('cursos.detalle.webgrafia', ['id' => $id_url]);
            }
        }else{
            if($this->modo_admin)
            {
                session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
                return redirect()->route('docentes.carga-academica.detalle.webgrafia', ['id' => $id_url]);
            }else{
                return redirect()->route('carga-academica.detalle.webgrafia', ['id' => $id_url]);
            }
        }
    }

    public function mostrar_alumnos($id)
    {
        $id_url = encriptar($id);
        if($this->modo_admin)
        {
            session(['id_usuario' => encriptar($this->usuario->id_usuario)]);
            return redirect()->route('docentes.carga-academica.detalle.alumnos', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.alumnos', ['id' => $id_url]);
        }
    }


    public function mount($id)
    {
        if(request()->routeIs('cursos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('carga-academica*'))
        {
            session(['tipo_vista' => 'docente']);
        }

        $this->id_gestion_aula_usuario = desencriptar($id);

        $this->mostrar_titulo_curso();

        if(request()->routeIs('alumnos*') || request()->routeIs('docentes*'))
        {
            if(session('id_usuario') !== null)
            {
                $this->usuario = Usuario::find(desencriptar(session('id_usuario')));
                $this->modo_admin = true;
            }else{
                request()->routeIs('alumnos*') ? redirect()->route('alumnos') : redirect()->route('docentes');
            }
        }else{
            $this->usuario = auth()->user();
        }
    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
