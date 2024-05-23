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

    public function mount($id)
    {
        $this->id_gestion_aula_usuario = desencriptar($id);
        
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
        if ($this->gestion_aula_usuario) {
            $this->curso = $this->gestion_aula_usuario->gestionAula->curso;
        }

        $gestion_aula = $this->gestion_aula_usuario->gestionAula;

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

    
    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
