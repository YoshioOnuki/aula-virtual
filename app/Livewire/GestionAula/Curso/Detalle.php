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

    public function mount($id)
    {
        $this->id_gestion_aula_usuario = desencriptar($id);
        $gest_aula_usua = GestionAulaUsuario::find($this->id_gestion_aula_usuario);
        $this->curso = $gest_aula_usua->gestionAula->curso;
        $gestion_aula = $gest_aula_usua->gestionAula;

        $this->docente = GestionAulaUsuario::with(['usuario.persona'])
            ->join('rol', 'gestion_aula_usuario.id_rol', '=', 'rol.id_rol')  // Join explícito con la tabla 'rol'
            ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
            ->where(function($query) {
                $query->where('rol.nombre_rol', 'DOCENTE')
                    ->orWhere('rol.nombre_rol', 'DOCENTE INVITADO');
            })
            ->orderBy('rol.nombre_rol', 'asc')
            ->get();

    }

    
    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
