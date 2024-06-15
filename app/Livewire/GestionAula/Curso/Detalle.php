<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Component;

class Detalle extends Component
{

    public $id_gestion_aula_usuario;
    public $curso;
    public $docente;
    public $gestion_aula_usuario;

    public $nombre_curso;
    public $grupo_gestion_aula;
    public $orientaciones_generales = ' ';
    public $link_clase = ' ';

    public $cargando = true;
    public $cargando_orientaciones = true;
    public $cargando_docente = true;
    public $cargando_datos_curso = true;



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

    public function mostrar_datos_docente()
    {
        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        $gestion_aula = $gestion_aula_usuario->gestionAula;

        $this->docente = GestionAulaUsuario::with(['usuario.persona'])
            ->join('rol', 'gestion_aula_usuario.id_rol', '=', 'rol.id_rol')
            ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
            ->where(function($query) {
                $query->where('rol.nombre_rol', 'DOCENTE')
                    ->orWhere('rol.nombre_rol', 'DOCENTE INVITADO');
            })
            ->orderBy('rol.nombre_rol', 'asc')
            ->get();
    }

    public function mostrar_datos_curso()
    {
        $this->gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'curso' => function ($query) {
                        $query->with([
                            'ciclo',
                            'planEstudio',
                            'programa' => function ($query) {
                                $query->with([
                                    'facultad',
                                    'tipoPrograma'
                                ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa', 'id_facultad');
                            }
                        ])->select('id_curso', 'codigo_curso', 'nombre_curso', 'creditos_curso', 'horas_lectivas_curso', 'id_programa', 'id_plan_estudio', 'id_ciclo');
                    },
                    'linkClase' => function ($query) {
                        $query->select('id_link_clase', 'id_gestion_aula', 'nombre_link_clase');
                    },
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        $this->link_clase = $this->gestion_aula_usuario->gestionAula->linkClase;

        if ($this->gestion_aula_usuario) {
            $this->curso = $this->gestion_aula_usuario->gestionAula->curso;
        }
    }

    public function load_datos_curso()
    {
        usleep(300000);
        $this->mostrar_datos_curso();
        $this->cargando_datos_curso = false;
    }

    public function load_datos_docente()
    {
        $this->mostrar_datos_docente();
        $this->cargando_docente = false;
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
            return redirect()->route('cursos.detalle.silabus', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.silabus', ['id' => $id_url]);
        }
    }

    public function mostrar_link_clase()
    {
        if($this->gestion_aula_usuario->gestionAula->linkClase->isEmpty())
        {
            $this->dispatch(
                'toast-basico',
                mensaje: 'El link de la clase no está disponible',
                type: 'error'
            );
        }else{
            //redirigir a un enlace externo
            return redirect()->away($this->gestion_aula_usuario->gestionAula->linkClase->nombre_link_clase);

        }
    }

    public function mostrar_recursos($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            return redirect()->route('cursos.detalle.recursos', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.recursos', ['id' => $id_url]);
        }
    }

    public function mostrar_foro($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            return redirect()->route('cursos.detalle.foro', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.foro', ['id' => $id_url]);
        }
    }

    public function mostrar_asistencia($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            return redirect()->route('cursos.detalle.asistencia', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.asistencia', ['id' => $id_url]);
        }
    }

    public function mostrar_trabajo_academico($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            return redirect()->route('cursos.detalle.trabajo-academico', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.trabajo-academico', ['id' => $id_url]);
        }
    }

    public function mostrar_webgrafia($id)
    {
        $id_url = encriptar($id);
        if(session('tipo_vista') === 'alumno'){
            return redirect()->route('cursos.detalle.webgrafia', ['id' => $id_url]);
        }else{
            return redirect()->route('carga-academica.detalle.webgrafia', ['id' => $id_url]);
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
    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
