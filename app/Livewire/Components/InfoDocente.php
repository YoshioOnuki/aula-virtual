<?php

namespace App\Livewire\Components;

use App\Models\GestionAulaUsuario;
use Livewire\Component;

class InfoDocente extends Component
{

    public $id_gestion_aula_usuario;
    public $docente;

    public $cargando_docente = true;

    public $tipo_vista; // Para saber que tipo de vista se está mostrando


    public function load_datos_docente()
    {
        $this->mostrar_datos_docente();
        $this->cargando_docente = false;
    }

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


    public function mount($id_gestion_aula_usuario, $tipo_vista)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
    }

    public function render()
    {
        return view('livewire.components.info-docente');
    }
}
