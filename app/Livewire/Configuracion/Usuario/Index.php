<?php

namespace App\Livewire\Configuracion\Usuario;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;

    #[Url('buscar')]
    public $search = '';

    public $modo = 1; // Modo 1 = Habilitar / 0 = Deshabilitar
    public $titulo_modal = 'Estado de Usuario';
    public $accion_estado = 'Habilitar';
    public $id_usuario;
    public $nombres_persona;
    public $correo_usuario;
    public $rol_usuario;


    public function abrir_modal_estado(Usuario $usuario, $modo)
    {
        $this->id_usuario = $usuario->id_usuario;
        $this->nombres_persona = $usuario->nombre_completo;
        $this->correo_usuario = $usuario->correo_usuario;
        $this->rol_usuario = $usuario->mostrarRol();

        if ($modo === 1) {
            $this->modo = 1;
            $this->titulo_modal = 'Estado de Usuario';
            $this->accion_estado = 'Habilitar';
        } elseif ($modo === 0) {
            $this->modo = 0;
            $this->titulo_modal = 'Estado de Usuario';
            $this->accion_estado = 'Deshabilitar';
        }

        $this->dispatch(
            'modal',
            modal: '#modal-estado-usuario',
            action: 'show'
        );

    }

    public function cambiar_estado()
    {
        //Transacción para el manejo de datos
        try {
            DB::beginTransaction();

            $usuario = Usuario::find($this->id_usuario);
            $usuario->estado_usuario = $this->modo;
            $usuario->save();
            // dd($usuario->estado_usuario);

            //Reiniciar variables
            $this->nombres_persona = '';
            $this->correo_usuario = '';
            $this->rol_usuario = '';
            $this->modo = 1;
            $this->titulo_modal = 'Estado de Usuario';
            $this->accion_estado = 'Habilitar';

            //Cerrar modal
            $this->dispatch(
                'modal',
                modal: '#modal-estado-usuario',
                action: 'hide'
            );

            $this->dispatch(
                'toast-basico',
                mensaje: 'Estado de usuario actualizado correctamente',
                type: 'success'
            );

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Ocurrió un error al actualizar el estado del usuario'.$e->getMessage(),
                type: 'error'
            );
        }

    }

    public function limpiar_modal()
    {
        $this->nombres_persona = '';
        $this->correo_usuario = '';
        $this->rol_usuario = '';
        $this->modo = 1;
        $this->titulo_modal = 'Estado de Usuario';
        $this->accion_estado = 'Habilitar';

        $this->dispatch(
            'modal',
            modal: '#modal-estado-usuario',
            action: 'hide'
        );
    }

    public function mount()
    {
        $this->titulo_modal = 'Estado de Usuario';
        $this->accion_estado = 'Habilitar';
        $this->modo = 1;

    }


    public function render()
    {
        $usuarios = Usuario::search($this->search)
            ->orderBy('id_usuario', 'desc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.configuracion.usuario.index',[
            'usuarios' => $usuarios,
        ]);
    }
}
