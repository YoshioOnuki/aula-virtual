<?php

namespace App\Livewire\GestionAula\Alumnos;

use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class Index extends Component
{
    use WithPagination;
    use UsuarioTrait;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;

    // Variables para modal
    public $modo = 1; // Modo 1 = Habilitar / 0 = Retirar
    public $titulo_modal = 'Estado de Alumno';
    public $accion_estado = 'Habilitar';
    public $id_gestion_aula_alumno;
    public $codigo_alumno;
    public $nombres_alumno;
    public $correo_usuario;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'LISTA DE ALUMNOS';
    public $links_page_header = [];
    public $regresar_page_header;



    public function abrir_modal_estado(GestionAulaAlumno $gestion_aula_alumno, $modo)
    {
        $this->id_gestion_aula_alumno = $gestion_aula_alumno->id_gestion_aula_alumno;
        $this->codigo_alumno = $gestion_aula_alumno->usuario->codigo_alumno;
        $this->nombres_alumno = $gestion_aula_alumno->usuario->nombre_completo;
        $this->correo_usuario = $gestion_aula_alumno->usuario->correo_usuario;
        $this->titulo_modal = 'Estado de Alumno';

        if ($modo === 1) {
            $this->modo = 1;
            $this->accion_estado = 'Habilitar';
        } elseif ($modo === 0) {
            $this->modo = 0;
            $this->accion_estado = 'Retirar';
        }

        $this->dispatch(
            'modal',
            modal: '#modal-estado-alumnos',
            action: 'show'
        );
    }


    /**
     * Cambiar estado del alumno
     */
    public function cambiar_estado()
    {
        try
        {
            DB::beginTransaction();

            $gestion_aula_alumno = GestionAulaAlumno::find($this->id_gestion_aula_alumno);
            $gestion_aula_alumno->estado_gestion_aula_alumno = $this->modo;
            $gestion_aula_alumno->save();

            DB::commit();

            $this->cerrar_modal();
            $this->limpiar_modal();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Estado de alumno actualizado correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ocurrió un error al actualizar el estado del alummno'.$e->getMessage(),
                type: 'error'
            );
        }
    }


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal = '#modal-estado-alumnos')
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: 'hide'
        );
    }


    /**
     * Limpiar modal
     */
    public function limpiar_modal()
    {
        $this->id_gestion_aula_alumno = '';
        $this->codigo_alumno = '';
        $this->nombres_alumno = '';
        $this->correo_usuario = '';
        $this->modo = 1;
        $this->titulo_modal = 'Estado de Alumno';
        $this->accion_estado = 'Habilitar';

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Obtener los datos para el page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'LISTA DE ALUMNOS';

        // Regresar
        $this->regresar_page_header = [
            'route' => 'carga-academica.detalle',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
        ];

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];

        // Links --> Cursos o Carga Académica
        $this->links_page_header[] = [
            'name' => 'Carga Académica',
            'route' => 'carga-academica',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista]
        ];

        $gestion_aula = GestionAula::with('curso')->find($this->id_gestion_aula);

        // Links --> Detalle del curso o carga académica
        $this->links_page_header[] = [
            'name' => $gestion_aula->curso->nombre_curso,
            'route' => 'carga-academica.detalle',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
        ];

    }


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso();
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso();

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');

        $this->es_docente_invitado = $this->verificar_usuario_invitado();

        $this->obtener_datos_page_header();
    }

    public function render()
    {
        $alumnos = GestionAulaAlumno::with('usuario')
            ->gestionAula($this->id_gestion_aula)
            ->estado(true)
            ->searchAlumno($this->search)
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.alumnos.index', [
            'alumnos' => $alumnos
        ]);
    }
}
