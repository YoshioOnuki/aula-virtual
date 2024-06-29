<?php

namespace App\Livewire\GestionAula\Recurso;

use App\Models\AlumnoRecurso;
use App\Models\GestionAulaUsuario;
use App\Models\Recurso;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;

    public $usuario;

    public $id_gestion_aula_usuario;
    public $gestion_aula_usuario;
    public $curso;
    public $recursos;

    public $cargando_recursos = true;
    public $cargando_datos_curso = true;
    public $cantidad_recursos = 1;

    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Estado de Usuario';
    public $accion_estado = 'Agregar';
    #[Validate('required')]
    public $nombre_recurso;
    #[Validate('required|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx|max:4096')]
    public $archivo_recurso;
    public $editar_recurso;

    public $modo_admin = false;


    public function cerrar_modal()
    {
        $this->limpiar_modal();
        $this->dispatch(
            'modal',
            modal: '#modal-recursos',
            action: 'hide'
        );
    }

    public function limpiar_modal()
    {
        $this->modo = 1;
        $this->titulo_modal = 'Estado de Usuario';
        $this->accion_estado = 'Agregar';
        $this->nombre_recurso = '';
        $this->editar_recurso = null;
        $this->reset('archivo_recurso');
    }

    // public function abrir_modal_recurso_editar(Recurso $recurso)
    public function abrir_modal_recurso_editar(Recurso $recurso)
    {
        $this->limpiar_modal();

        $this->modo = 0;
        $this->titulo_modal = 'Editar Recurso';
        $this->accion_estado = 'Editar';

        $this->editar_recurso = Recurso::find($recurso->id_recurso);
        $this->nombre_recurso = $this->editar_recurso->nombre_recurso;

        $this->dispatch(
            'modal',
            modal: '#modal-recursos',
            action: 'show'
        );
    }

    public function abrir_modal_recurso_agregar()
    {
        $this->limpiar_modal();

        $this->modo = 1;
        $this->titulo_modal = 'Agregar Recurso';
        $this->accion_estado = 'Agregar';

        $this->dispatch(
            'modal',
            modal: '#modal-recursos',
            action: 'show'
        );

    }

    public function subir_archivo_recurso()
    {
        $carpetas = obtener_ruta_base($this->id_gestion_aula_usuario);

        $archivo = $this->archivo_recurso;
        $nombre_archivo_recurso = $this->editar_recurso->archivo_recurso ?? null;
        array_push($carpetas, 'recursos');
        $extension_archivo = strtolower($archivo->getClientOriginalExtension());

        $extensiones_permitidas = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx'];

        if (in_array($extension_archivo, $extensiones_permitidas)) {
            $extencion_archivo = $extension_archivo;
        } else {
            $this->reset('archivo_recurso');
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al subir el archivo: La extensión del archivo no es válida.
                Revise que el archivo sea de tipo PDF, XLS, XLSX, DOC, DOCX, PPT o PPTX',
                type: 'error'
            );
            return null;
        }

        $nombre_bd = subir_archivo($archivo, $nombre_archivo_recurso, $carpetas, $extencion_archivo);

        return $nombre_bd;
    }

    public function guardar_recurso()
    {
        $this->validate();

        DB::beginTransaction();

        try {

            $nombre_bd = $this->subir_archivo_recurso();

            if($this->modo === 1)
            {
                $recurso = new Recurso();
                $recurso->nombre_recurso = $this->nombre_recurso;
                $recurso->archivo_recurso = $nombre_bd;
                $recurso->id_gestion_aula = $this->gestion_aula_usuario->gestionAula->id_gestion_aula;
                $recurso->save();
            }else{
                $recurso = Recurso::find($this->editar_recurso->id_recurso);
                $recurso->nombre_recurso = $this->nombre_recurso;
                $recurso->archivo_recurso = $nombre_bd;
                $recurso->save();
            }

            DB::commit();

            $this->cerrar_modal();
            $this->load_recursos();

            $this->dispatch(
                'toast-basico',
                mensaje: 'El recurso se ha guardado correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar el recurso: '.$e->getMessage(),
                type: 'error'
            );
        }

    }

    public function mostrar_recursos()
    {
        $this->gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'curso' => function ($query) {
                        $query->with([
                            'ciclo',
                            'planEstudio',
                            'programa' => function ($query) {
                                $query->with([
                                    'facultad',
                                    'tipoPrograma'
                                ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa', 'id_facultad');
                            }
                        ])->select('id_curso', 'codigo_curso', 'nombre_curso', 'creditos_curso', 'horas_lectivas_curso', 'id_programa', 'id_plan_estudio', 'id_ciclo');
                    },
                    'recurso' => function ($query) {
                        $query->select('id_recurso', 'nombre_recurso', 'archivo_recurso', 'id_gestion_aula', 'created_at');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if ($this->gestion_aula_usuario) {
            $this->recursos = $this->gestion_aula_usuario->gestionAula->recurso;
        }
    }

    public function load_recursos()
    {
        $this->mostrar_recursos();
        $this->cargando_recursos = false;
    }

    public function calcular_cantidad_recursos()
    {
        $id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;
        $this->gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'recurso' => function ($query) {
                        $query->select('id_recurso');
                    }
                ])->select('id_gestion_aula');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        $this->cantidad_recursos = Recurso::where('id_gestion_aula', $id_gestion_aula)->count();

        $this->cantidad_recursos === 0 ? $this->cantidad_recursos = 1 : $this->cantidad_recursos;
    }

    public function descargar_recurso(Recurso $recurso)
    {
        $ruta = $recurso->archivo_recurso;
        return response()->download($ruta, $recurso->nombre_recurso.'.'.pathinfo($ruta, PATHINFO_EXTENSION));
    }


    /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */
    public function load_recursos_llamar()
    {
        $this->dispatch('load_recursos_evento');
    }

    public function load_datos_curso_llamar()
    {
        $this->dispatch('load_datos_curso_evento');
    }

    public function mount($id)
    {
        if(request()->routeIs('cursos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('carga-academica*'))
        {
            session(['tipo_vista' => 'docente']);
        }elseif(request()->routeIs('alumnos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('docentes*'))
        {
            session(['tipo_vista' => 'docente']);
        }

        $this->id_gestion_aula_usuario = desencriptar($id);

        $this->calcular_cantidad_recursos();

        if(request()->routeIs('alumnos*') || request()->routeIs('docentes*'))
        {
            if(session('id_usuario') !== null)
            {
                $this->usuario = Usuario::find(desencriptar(session('id_usuario')));
                $this->modo_admin = true;
            }else{
                request()->routeIs('alumnos*') ? redirect()->route('alumnos') : redirect()->route('docentes');
            }
        }else{
            $this->usuario = Usuario::find(auth()->id());
        }

    }

    public function render()
    {
        return view('livewire.gestion-aula.recurso.index');
    }
}
