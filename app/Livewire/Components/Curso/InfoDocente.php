<?php

namespace App\Livewire\Components\Curso;

use App\Models\GestionAulaUsuario;
use Livewire\Component;

class InfoDocente extends Component
{
    public $id_gestion_aula_usuario;
    public $docente;

    public $tipo_vista; // Para saber que tipo de vista se está mostrando


    public function mostrar_datos_docente()
    {
        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        $gestion_aula = $gestion_aula_usuario->gestionAula;

        if(config('settings.ver_docente_invitado'))
        {
            $this->docente = GestionAulaUsuario::with(['usuario.persona'])
                ->join('rol', 'gestion_aula_usuario.id_rol', '=', 'rol.id_rol')
                ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
                ->where(function($query) {
                    $query->where('rol.nombre_rol', 'DOCENTE')
                        ->orWhere('rol.nombre_rol', 'DOCENTE INVITADO');
                })
                ->orderBy('rol.nombre_rol', 'asc')
                ->get();
        }else{
            $this->docente = GestionAulaUsuario::with(['usuario.persona'])
                ->join('rol', 'gestion_aula_usuario.id_rol', '=', 'rol.id_rol')
                ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
                ->where(function($query) {
                    $query->where('rol.nombre_rol', 'DOCENTE');
                })
                ->orderBy('rol.nombre_rol', 'asc')
                ->get();
        }
    }


    public function placeholder()
    {
        return <<<'HTML'
        <div class="col-12 mb-3">
            <a class="card card-link card-stacked placeholder-glow">
                <div class="card-cover card-cover-blurred text-center">
                    <div class="avatar avatar-xl placeholder {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }}"></div>
                </div>
                <div class="card-body text-center">
                    <div class="card-title mb-1">
                        <div class="placeholder col-6" style="height: 19.5px"></div>
                    </div>
                    <div class="placeholder bg-secondary col-5" style="height: 17px;"></div>
                    <div class="mt-2">
                        <div class="placeholder {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }} col-3" style="height: 17px;"></div>
                    </div>
                </div>
            </a>
        </div>
        HTML;
    }


    public function mount($id_gestion_aula_usuario, $tipo_vista)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;

        $this->mostrar_datos_docente();
    }


    public function render()
    {
        return view('livewire.components.curso.info-docente');
    }
}
