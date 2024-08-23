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
    public $trabajo_academico_alumno;
    public $id_gestion_aula_usuario;
    public $cantidad_alumnos;
    public $cantidad_alumnos_entregados;
    public $cantidad_alumnos_revisados;
    public $cantidad_alumnos_observados;

    protected $listeners = ['actualizar_estado_trabajo' => 'actualizar_estado_trabajo'];


    public function actualizar_estado_trabajo()
    {
        $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
            ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
            ->first();

        $this->cantidad_alumnos_entregados = TrabajoAcademicoAlumno::where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->count();

        $this->cantidad_alumnos_revisados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
            ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->whereHas('estadoTrabajoAcademico', function ($query) {
                $query->where('nombre_estado_trabajo_academico', 'Revisado');
            })
            ->count();

        $this->cantidad_alumnos_observados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
            ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->whereHas('estadoTrabajoAcademico', function ($query) {
                $query->where('nombre_estado_trabajo_academico', 'Observado');
            })
            ->count();

        $this->cantidad_alumnos = GestionAulaUsuario::with('rol')
            ->where('id_gestion_aula', $this->trabajo_academico->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->where('estado_gestion_aula_usuario', 1)
            ->count();
    }


    public function mount(TrabajoAcademico $trabajo_academico, $tipo_vista, $id_gestion_aula, $id_gestion_aula_usuario)
    {
        $this->tipo_vista = $tipo_vista;
        $this->trabajo_academico = $trabajo_academico;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
        $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
            ->first();

        // Cantidad de alumnos que han entregado el trabajo
        $this->cantidad_alumnos_entregados = TrabajoAcademicoAlumno::where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->count();

        // Cantidad de alumnos que han sido revisados
        $this->cantidad_alumnos_revisados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
            ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->whereHas('estadoTrabajoAcademico', function ($query) {
                $query->where('nombre_estado_trabajo_academico', 'Revisado');
            })
            ->count();

        // Cantidad de alumnos que han sido observados
        $this->cantidad_alumnos_observados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
            ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->whereHas('estadoTrabajoAcademico', function ($query) {
                $query->where('nombre_estado_trabajo_academico', 'Observado');
            })
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
