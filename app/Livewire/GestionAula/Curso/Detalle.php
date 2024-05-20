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
        $this->docente = GestionAulaUsuario::with('usuario.persona')
                ->where('id_gestion_aula', $gestion_aula->id_gestion_aula)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'DOCENTE');
                })
                ->first();
    }

    
    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
