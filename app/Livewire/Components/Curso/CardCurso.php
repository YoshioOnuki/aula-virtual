<?php

namespace App\Livewire\Components\Curso;

use App\Models\AsistenciaAlumno;
use App\Models\ForoRespuesta;
use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardCurso extends Component
{

    public $gestion_aula_usuario;
    public $usuario;
    public $usuario_sesion;
    public $docente;
    public $tipo_curso;

    public $numero_progreso = array();
    public $numero_progreso_realizados = array();
    public $progreso = array();
    public $foto_docente = array();

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente


    public function redirigir_curso_detalle($id)
    {
        $docente  = GestionAulaUsuario::with('usuario.persona')
            ->where('id_gestion_aula', $id)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'DOCENTE');
            })
            ->first();
        if($docente) {
            $gestion_aula_usuario = GestionAulaUsuario::where('id_gestion_aula', $id)
                ->where('id_usuario', $this->usuario->id_usuario)
                ->first();

            $id_curso = Hashids::encode($gestion_aula_usuario->id_gestion_aula_usuario);
            $id_usuario = Hashids::encode($this->usuario->id_usuario);

            $usuario_sesion = Usuario::find($this->usuario_sesion->id_usuario);
            if ($usuario_sesion->esRol('ADMINISTRADOR'))
            {
                $this->modo_admin = true;
            }

            if($this->tipo_vista === 'cursos')
            {
                return redirect()->route('cursos.detalle', ['id_usuario' => $id_usuario, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
            } else {
                return redirect()->route('carga-academica.detalle', ['id_usuario' => $id_usuario, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
            }
        } else {

            $this->dispatch(
                'toast-basico',
                mensaje: 'No se puede acceder al curso, no tiene docente asignado',
                type: 'error'
            );
        }
    }


    /* =============== CALCULAR PROGRESO DEL CURSO =============== */
        public function calcular_progreso()
        {
            $this->calcular_trabajo_academico();
            // $this->calcular_foros();
            $this->calcular_asistencia();
        }

        public function calcular_trabajo_academico()
        {
            if ($this->gestion_aula_usuario->gestionAula->trabajoAcademico->count() > 0)
            {
                $trabajos = $this->gestion_aula_usuario->gestionAula->trabajoAcademico->count();
                $trabajos_realizados = 0;

                $trabajos_realizados = TrabajoAcademico::Join('trabajo_academico_alumno', 'trabajo_academico.id_trabajo_academico', '=', 'trabajo_academico_alumno.id_trabajo_academico')
                    ->where('trabajo_academico.id_gestion_aula', $this->gestion_aula_usuario->gestionAula->id_gestion_aula)
                    ->where('trabajo_academico_alumno.id_gestion_aula_usuario', $this->gestion_aula_usuario->id_gestion_aula_usuario)
                    ->where('trabajo_academico_alumno.id_estado_trabajo_academico', 2)
                    ->count();

                $this->numero_progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario] = $trabajos;
                $this->numero_progreso_realizados[$this->gestion_aula_usuario->id_gestion_aula_usuario] = $trabajos_realizados;
                $this->progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario] = round(($trabajos_realizados / $trabajos) * 100);
            }
        }

        public function calcular_foros()
        {
            if ($this->gestion_aula_usuario->gestionAula->foro->count() > 0)
            {
                $foros = $this->gestion_aula_usuario->gestionAula->foro->count();
                $foros_realizados = 0;

                $foros_realizados = ForoRespuesta::Join('foro', 'foro.id_foro', '=', 'foro_respuesta.id_foro')
                    ->where('foro_respuesta.id_gestion_aula_usuario', $this->gestion_aula_usuario->id_gestion_aula_usuario)
                    ->count();

                $this->numero_progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario] += $foros;
                $this->numero_progreso_realizados[$this->gestion_aula_usuario->id_gestion_aula_usuario] += $foros_realizados;
                $this->progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario] = round(($this->numero_progreso_realizados[$this->gestion_aula_usuario->id_gestion_aula_usuario] / $this->numero_progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario]) * 100);
            }
        }

        public function calcular_asistencia()
        {
            if ($this->gestion_aula_usuario->gestionAula->asistencia->count() > 0) {
                $asistencias = $this->gestion_aula_usuario->gestionAula->asistencia->count();
                $asistencias_realizadas = 0;

                $asistencias_realizadas = AsistenciaAlumno::where('id_gestion_aula_usuario', $this->gestion_aula_usuario->id_gestion_aula_usuario)->count();

                $this->numero_progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario] += $asistencias;
                $this->numero_progreso_realizados[$this->gestion_aula_usuario->id_gestion_aula_usuario] += $asistencias_realizadas;
                $this->progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario] = round(($this->numero_progreso_realizados[$this->gestion_aula_usuario->id_gestion_aula_usuario] / $this->numero_progreso[$this->gestion_aula_usuario->id_gestion_aula_usuario]) * 100);
            }
        }
    /* =========================================================== */


    public function mostrar_foto_docente()
    {
        // Sacar el docente del curso desde la gestion aula usuario
        $docente = GestionAulaUsuario::with('usuario.persona')
            ->where('id_gestion_aula', $this->gestion_aula_usuario->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'DOCENTE');
            })
            ->first();
        if($docente) {
            $this->foto_docente[$this->gestion_aula_usuario->id_gestion_aula] = $docente->usuario->mostrarFoto('alumno');
        }else{
            $this->foto_docente[$this->gestion_aula_usuario->id_gestion_aula] = '/media/avatar-none.webp';
        }
    }


    public function placeholder()
    {
        return <<<'HTML'
            <div class="col-sm-4 col-lg-4 col-xl-3 p-xl-2 p-lg-1 p-2">
                <div class="card placeholder-glow cursor-progress">
                    <div class="ratio ratio-16x9 card-img-top placeholder"></div>
                    <div class="card-avatar avatar avatar-smm rounded-circle">
                        <div class="avatar avatar-rounded placeholder"></div>
                    </div>
                    <div class="card-body mb-2">
                        <div class="placeholder placeholder-sm col-4 mt-4"></div>
                        <div class="placeholder col-12 mt-1"></div>
                        <div class="placeholder placeholder-xs col-12 mt-6"></div>
                    </div>
                </div>
            </div>
        HTML;
    }


    // Mount
    public function mount($tipo_vista, $usuario, $gestion_aula)
    {
        $this->tipo_vista = $tipo_vista;
        $this->gestion_aula_usuario = GestionAulaUsuario::with('rol', 'gestionAula.curso')
            ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
            ->where('id_usuario', $usuario->id_usuario)
            ->first();

        $this->usuario = $usuario;

        $user = Auth::user();
        $this->usuario_sesion = Usuario::find($user->id_usuario);

        if ($this->usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }

        $this->mostrar_foto_docente();
        $this->calcular_progreso();
    }


    public function render()
    {
        return view('livewire.components.curso.card-curso');
    }
}
