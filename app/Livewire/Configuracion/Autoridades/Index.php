<?php

namespace App\Livewire\Configuracion\Autoridades;

use App\Models\Autoridad;
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

    // Variables para el modal
    public $modo = 1; // Modo 1 = Habilitar / 0 = Deshabilitar
    public $titulo_modal = 'Estado de Autoridad';
    public $accion_estado = 'Habilitar';
    public $id_autoridad;
    public $nombres_autoridad;
    public $cargo_autoridad;
    public $facultad_autoridad;

    public function abrir_modal_estado(Autoridad $autoridad, $modo)
    {
        $this->id_autoridad = $autoridad->id_autoridad;
        $this->nombres_autoridad = $autoridad->nombre_autoridad;
        $this->cargo_autoridad = $autoridad->cargo->nombre_cargo;
        $this->facultad_autoridad = $autoridad->facultad->nombre_facultad ?? '';

        if ($modo === 1) {
            $this->modo = 1;
            $this->titulo_modal = 'Estado de Autoridad';
            $this->accion_estado = 'Habilitar';
        } elseif ($modo === 0) {
            $this->modo = 0;
            $this->titulo_modal = 'Estado de Autoridad';
            $this->accion_estado = 'Deshabilitar';
        }

        $this->dispatch(
            'modal',
            modal: '#modal-estado-autoridad',
            action: 'show'
        );

    }

    public function cambiar_estado()
    {
        //Transacción para el manejo de datos
        try {
            DB::beginTransaction();

            $autoridad = Autoridad::find($this->id_autoridad);
            $autoridad->estado_autoridad = $this->modo;
            $autoridad->save();

            //Reiniciar variables
            $this->id_autoridad = '';
            $this->nombres_autoridad = '';
            $this->cargo_autoridad = '';
            $this->facultad_autoridad = '';
            $this->modo = 1;
            $this->titulo_modal = 'Estado de Autoridad';
            $this->accion_estado = 'Habilitar';

            //Cerrar modal
            $this->dispatch(
                'modal',
                modal: '#modal-estado-autoridad',
                action: 'hide'
            );

            $this->dispatch(
                'toast-basico',
                mensaje: 'Estado de la Autoridad actualizado correctamente',
                type: 'success'
            );

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Ocurrió un error al actualizar el estado de la Autoridad: ' . $e->getMessage(),
                type: 'error'
            );
        }


    }

    public function limpiar_modal()
    {
        $this->id_autoridad = '';
        $this->nombres_autoridad = '';
        $this->cargo_autoridad = '';
        $this->facultad_autoridad = '';
        $this->modo = 1;
        $this->titulo_modal = 'Estado de Autoridad';
        $this->accion_estado = 'Habilitar';

        $this->dispatch(
            'modal',
            modal: '#modal-estado-autoridad',
            action: 'hide'
        );
    }

    public function render()
    {
        // PreCargar el cargo y la facultad de las autoridades
        $autoridades = Autoridad::with('cargo', 'facultad')
            ->search($this->search)
            ->orderBy('id_autoridad', 'desc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.configuracion.autoridades.index', [
            'autoridades' => $autoridades
        ]);
    }
}
