<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\AsistenciaAlumno;
use App\Models\ForoRespuesta;
use App\Models\GestionAula;
use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use Livewire\Component;

class Index extends Component
{
    public $usuario;
    public $cursos;
    public $favorito;
    public $numero_progreso = array();
    public $numero_progreso_realizados = array();
    public $progreso = array();
    public $foto_docente = array();

    public $cargando = true;
    public $cantidad_cursos = 1;

    public function curso_favorito($id)
    {
        usleep(500000);
        $gest_aula_usua = GestionAulaUsuario::find($id);
        if ($gest_aula_usua->favorito_gestion_aula_usuario == 0) {
            $gest_aula_usua->favorito_gestion_aula_usuario = 1;
        } else {
            $gest_aula_usua->favorito_gestion_aula_usuario = 0;
        }
        $gest_aula_usua->save();
    }

    public function curso_detalle($id)
    {
        $docente  = GestionAulaUsuario::with('usuario.persona')
            ->where('id_gestion_aula', $id)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'DOCENTE');
            })
            ->first();
        if($docente) {
            if(session('tipo_vista') === 'alumno') {
                $id_url = encriptar($docente->id_gestion_aula_usuario);
                return redirect()->route('cursos.detalle', ['id' => $id_url]);
            } else {
                $id_url = encriptar($docente->id_gestion_aula_usuario);
                return redirect()->route('carga-academica.detalle', ['id' => $id_url]);
            }
        } else {

            $this->dispatch(
                'toast-basico',
                mensaje: 'No se puede acceder al curso, no tiene docente asignado',
                type: 'error'
            );
        }
    }

    public function calcular_progreso()
    {
        $this->calcular_trabajo_academico();
        $this->calcular_foros();
        $this->calcular_asistencia();
    }

    public function calcular_trabajo_academico()
    {
        foreach ($this->cursos as $curso) {
            if ($curso->gestionAula->trabajoAcademico->count() > 0) {
                $trabajos = $curso->gestionAula->trabajoAcademico->count();
                $trabajos_realizados = 0;


                $trabajos_realizados = TrabajoAcademico::Join('trabajo_academico_alumno', 'trabajo_academico.id_trabajo_academico', '=', 'trabajo_academico_alumno.id_trabajo_academico')
                    ->where('trabajo_academico.id_gestion_aula', $curso->gestionAula->id_gestion_aula)
                    ->where('trabajo_academico_alumno.id_gestion_aula_usuario', $curso->id_gestion_aula_usuario)
                    ->where('trabajo_academico_alumno.id_estado_trabajo_academico', 2)
                    ->count();

                $this->numero_progreso[$curso->id_gestion_aula_usuario] = $trabajos;
                $this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] = $trabajos_realizados;
                $this->progreso[$curso->id_gestion_aula_usuario] = round(($trabajos_realizados / $trabajos) * 100);
            }
        }
    }

    public function calcular_foros()
    {
        foreach ($this->cursos as $curso) {
            if ($curso->gestionAula->foro->count() > 0) {
                $foros = $curso->gestionAula->foro->count();
                $foros_realizados = 0;

                $foros_realizados = ForoRespuesta::Join('foro', 'foro.id_foro', '=', 'foro_respuesta.id_foro')
                    ->where('foro_respuesta.id_gestion_aula_usuario', $curso->id_gestion_aula_usuario)
                    ->count();

                $this->numero_progreso[$curso->id_gestion_aula_usuario] += $foros;
                $this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] += $foros_realizados;
                $this->progreso[$curso->id_gestion_aula_usuario] = round(($this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] / $this->numero_progreso[$curso->id_gestion_aula_usuario]) * 100);
            }
        }
    }

    public function calcular_asistencia()
    {
        foreach ($this->cursos as $curso) {
            if ($curso->gestionAula->asistencia->count() > 0) {
                $asistencias = $curso->gestionAula->asistencia->count();
                $asistencias_realizadas = 0;

                $asistencias_realizadas = AsistenciaAlumno::where('id_gestion_aula_usuario', $curso->id_gestion_aula_usuario)->count();

                $this->numero_progreso[$curso->id_gestion_aula_usuario] += $asistencias;
                $this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] += $asistencias_realizadas;
                $this->progreso[$curso->id_gestion_aula_usuario] = round(($this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] / $this->numero_progreso[$curso->id_gestion_aula_usuario]) * 100);
            }
        }
    }

    public function mostrar_cursos()
    {
        if(session('tipo_vista') === 'alumno')
        {
            $cursos = GestionAulaUsuario::with(['gestionAula.curso', 'rol'])
                ->where('id_usuario', auth()->user()->id_usuario)
                ->where('estado_gestion_aula_usuario', 1)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'ALUMNO');
                })
                ->orderBy('favorito_gestion_aula_usuario', 'desc')
                ->get();

            $favoritos = $cursos->where('favorito_gestion_aula_usuario', 1)
                ->sortBy('gestionAula.curso.nombre_curso');

            $noFavoritos = $cursos->where('favorito_gestion_aula_usuario', 0)
                ->sortBy('gestionAula.curso.nombre_curso');

            $this->cursos = $favoritos->concat($noFavoritos);

        } else {
                $cursos = GestionAulaUsuario::with(['gestionAula.curso', 'rol'])
                    ->where('id_usuario', auth()->user()->id_usuario)
                    ->where('estado_gestion_aula_usuario', 1)
                    ->whereHas('rol', function ($query) {
                        $query->whereIn('nombre_rol', ['DOCENTE', 'DOCENTE INVITADO']);
                    })
                    ->orderBy('favorito_gestion_aula_usuario', 'desc')
                    ->get();

            $favoritos = $cursos->where('favorito_gestion_aula_usuario', 1)
                ->sortBy('gestionAula.curso.nombre_curso');

            $noFavoritos = $cursos->where('favorito_gestion_aula_usuario', 0)
                ->sortBy('gestionAula.curso.nombre_curso');

            $this->cursos = $favoritos->concat($noFavoritos);

        }
    }

    public function mostrar_foto_docente()
    {
        foreach ($this->cursos as $curso) {
            // Sacar el docente del curso desde la gestion aula usuario
            $docente = GestionAulaUsuario::with('usuario.persona')
                ->where('id_gestion_aula', $curso->gestionAula->id_gestion_aula)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'DOCENTE');
                })
                ->first();
                if($docente) {
                    $this->foto_docente[$curso->id_gestion_aula] = $docente->usuario->mostrarFoto('alumno');
                }else{
                    $this->foto_docente[$curso->id_gestion_aula] = '/media/avatar-none.webp';
                }
            }
    }

    public function load_cursos()
    {
        usleep(100000);
        $this->mostrar_cursos();
        $this->calcular_progreso();
        $this->mostrar_foto_docente();
        $this->cargando = false;
    }

    public function calcular_cantidad_curso()
    {
        if(session('tipo_vista') === 'alumno')
        {
            $this->cantidad_cursos = GestionAulaUsuario::with('rol')
                ->where('id_usuario', auth()->user()->id_usuario)
                ->where('estado_gestion_aula_usuario', 1)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'ALUMNO');
                })
                ->count();


        } elseif(session('tipo_vista') === 'docente') {
            $this->cantidad_cursos = GestionAulaUsuario::with('rol')
                ->where('id_usuario', auth()->user()->id_usuario)
                ->where('estado_gestion_aula_usuario', 1)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'DOCENTE');
                })
                ->count();
        }
        $this->cantidad_cursos === 0 ? $this->cantidad_cursos = 1 : $this->cantidad_cursos;
    }


    public function mount()
    {
        if(request()->routeIs('cursos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('carga-academica*'))
        {
            session(['tipo_vista' => 'docente']);
        }

        $this->usuario = auth()->user();

        $this->calcular_cantidad_curso();

    }

    public function render()
    {
        $this->mostrar_cursos();

        return view('livewire.gestion-aula.curso.index');
    }
}
