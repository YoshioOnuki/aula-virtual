<?php

namespace App\Livewire\Components\Curso;

use App\Models\AsistenciaAlumno;
use App\Models\ForoRespuesta;
use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\GestionAulaDocente;
use App\Models\TrabajoAcademico;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardCurso extends Component
{

    public $gestion_aula;
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
    public $ruta_vista;


    public function redirigir_curso_detalle($id)
    {
        if($this->docente) {
            $id_curso = Hashids::encode($this->docente->id_gestion_aula);
            $id_usuario = Hashids::encode($this->usuario->id_usuario);

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

        if ($this->tipo_vista === 'cursos')
        {
            $this->docente = GestionAula::with([
                'gestionAulaAlumno' => function ($query) {
                    $query->with([
                        'usuario' => function ($query) {
                            $query->with('persona')
                                ->first();
                        }
                    ])->first();
                }
            ])
                ->where('id_gestion_aula', $this->gestion_aula_usuario->id_gestion_aula)
                ->whereHas('gestionAulaAlumno', function ($query) {
                    $query->where('id_usuario', $this->usuario->id_usuario)
                        ->estado(true);
                })
                ->first();

            if($this->docente) {
                $this->foto_docente[$this->gestion_aula_usuario->id_gestion_aula] = $this->docente->gestionAulaAlumno[0]->usuario->mostrarFoto('alumno');
            }else{
                $this->foto_docente[$this->gestion_aula_usuario->id_gestion_aula] = '/media/avatar-none.webp';
            }
        } else {
            $this->docente = GestionAula::with([
                'gestionAulaDocente' => function ($query) {
                    $query->with([
                        'usuario' => function ($query) {
                            $query->with('persona')
                                ->first();
                        }
                    ])->first();
                }
            ])
                ->where('id_gestion_aula', $this->gestion_aula_usuario->id_gestion_aula)
                ->whereHas('gestionAulaDocente', function ($query) {
                    $query->where('id_usuario', $this->usuario->id_usuario)
                        ->estado(true);
                })
                ->first();
            if($this->docente) {
                $this->foto_docente[$this->gestion_aula_usuario->id_gestion_aula] = $this->gestion_aula_usuario->usuario->mostrarFoto('alumno');
            }else{
                $this->foto_docente[$this->gestion_aula_usuario->id_gestion_aula] = '/media/avatar-none.webp';
            }
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
    public function mount($tipo_vista, $usuario, $gestion_aula, $ruta_vista)
    {
        $this->tipo_vista = $tipo_vista;
        $this->gestion_aula = GestionAula::with('curso')
            ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
            ->first();

        if ($this->tipo_vista === 'cursos')
        {
            $this->gestion_aula_usuario = GestionAulaAlumno::with('usuario.persona')
                ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
                ->where('id_usuario', $usuario->id_usuario)
                ->first();
        } else {
            $this->gestion_aula_usuario = GestionAulaDocente::with('usuario.persona')
                ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
                ->where('id_usuario', $usuario->id_usuario)
                ->first();
        }

        $this->usuario = $usuario;

        $user = Auth::user();
        $this->usuario_sesion = Usuario::find($user->id_usuario);

        if ($this->usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }
        $this->ruta_vista = $ruta_vista;

        $this->mostrar_foto_docente();
        if ($this->tipo_vista === 'cursos')
        {
            $this->calcular_progreso();
        }
    }


    public function render()
    {
        return view('livewire.components.curso.card-curso');
    }
}
