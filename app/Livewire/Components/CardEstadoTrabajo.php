<?php

namespace App\Livewire\Components;

use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use App\Models\TrabajoAcademicoAlumno;
use Livewire\Component;

class CardEstadoTrabajo extends Component
{

    public $tipo_vista;
    public $trabajo_academico;
    public $cantidad_alumnos;
    public $cantidad_alumnos_entregados;


    public function mount(TrabajoAcademico $trabajo_academico, $tipo_vista, $id_gestion_aula)
    {
        $this->tipo_vista = $tipo_vista;
        $this->trabajo_academico = $trabajo_academico;

        // Cantidad de alumnos que han entregado el trabajo
        $this->cantidad_alumnos_entregados = TrabajoAcademicoAlumno::where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->count();

        // Cantida de alumnos del curso
        $this->cantidad_alumnos = GestionAulaUsuario::with('rol')
            ->where('id_gestion_aula', $id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->where('estado_gestion_aula_usuario', 1)
            ->count();

    }


    public function render()
    {
        return view('livewire.components.card-estado-trabajo');
    }
}
