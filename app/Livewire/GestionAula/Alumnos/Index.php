<?php

namespace App\Livewire\GestionAula\Alumnos;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $usuario;

    public $id_gestion_aula_usuario;
    public $id_gestion_aula;

    public $modo = 1; // Modo 1 = Habilitar / 0 = Retirar
    public $titulo_modal = 'Estado de Alumno';
    public $accion_estado = 'Habilitar';
    public $id_gestion_aula_usuario_alumno;
    public $codigo_alumno;
    public $nombres_alumno;
    public $correo_usuario;


    public function abrir_modal_estado(GestionAulaUsuario $gestion_aula_usuario, $modo)
    {
        $this->id_gestion_aula_usuario_alumno = $gestion_aula_usuario->id_gestion_aula_usuario;
        $this->codigo_alumno = $gestion_aula_usuario->usuario->persona->codigo_alumno_persona;
        $this->nombres_alumno = $gestion_aula_usuario->usuario->nombre_completo;
        $this->correo_usuario = $gestion_aula_usuario->usuario->correo_usuario;
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

    public function cambiar_estado()
    {
        //Transacción para el manejo de datos
        try {
            DB::beginTransaction();

            $gestion_aula_usuario = GestionAulaUsuario::find($this->id_gestion_aula_usuario_alumno);
            $gestion_aula_usuario->estado_gestion_aula_usuario = $this->modo;
            $gestion_aula_usuario->save();
            // dd($gestion_aula_usuario->estado_gestion_aula_usuario, $gestion_aula_usuario->usuario->nombre_completo);

            //Reiniciar variables
            $this->id_gestion_aula_usuario_alumno = '';
            $this->codigo_alumno = '';
            $this->nombres_alumno = '';
            $this->correo_usuario = '';
            $this->modo = 1;
            $this->titulo_modal = 'Estado de Alumno';
            $this->accion_estado = 'Habilitar';

            //Cerrar modal
            $this->dispatch(
                'modal',
                modal: '#modal-estado-alumnos',
                action: 'hide'
            );

            $this->dispatch(
                'toast-basico',
                mensaje: 'Estado de alumno actualizado correctamente',
                type: 'success'
            );

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Ocurrió un error al actualizar el estado del alummno'.$e->getMessage(),
                type: 'error'
            );
        }

    }

    public function limpiar_modal()
    {
        $this->id_gestion_aula_usuario_alumno = '';
        $this->codigo_alumno = '';
        $this->nombres_alumno = '';
        $this->correo_usuario = '';
        $this->modo = 1;
        $this->titulo_modal = 'Estado de Alumno';
        $this->accion_estado = 'Habilitar';

        $this->dispatch(
            'modal',
            modal: '#modal-estado-alumnos',
            action: 'hide'
        );
    }

    public function mount($id)
    {
        if(request()->routeIs('cursos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('carga-academica*'))
        {
            session(['tipo_vista' => 'docente']);
        }

        $this->id_gestion_aula_usuario = desencriptar($id);
        $this->id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

        $this->usuario = Usuario::find(auth()->id());

    }

    public function render()
    {
        $alumnos = GestionAulaUsuario::with([
            'usuario' => function ($query) {
                $query->with([
                    'persona' => function ($query) {
                        $query->select('id_persona', 'documento_persona', 'nombres_persona', 'apellido_paterno_persona', 'apellido_materno_persona', 'codigo_alumno_persona', 'correo_persona');
                    }
                ])->select('id_usuario', 'correo_usuario', 'foto_usuario', 'estado_usuario', 'id_persona');
            },
            'rol' => function ($query) {
                $query->select('id_rol', 'nombre_rol', 'estado_rol');
            },
        ])->where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->searchUsuario($this->search)
            ->paginate($this->mostrar_paginate);
        // dd($alumnos);

        return view('livewire.gestion-aula.alumnos.index', [
            'alumnos' => $alumnos
        ]);
    }
}
