<?php

namespace App\Livewire\GestionAula\CargaAcademica;

use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\Facultad;
use App\Models\GestionAula;
use App\Models\Persona;
use App\Models\PlanEstudio;
use App\Models\Proceso;
use App\Models\Programa;
use App\Models\TipoPrograma;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 8;
    public $mostrar_paginate_alumnos = 10;
    #[Url(except: '', as: 'buscar')]
    public $search = '';
    public $search_alumnos = '';
    #[Url(except: '', as: 'tipo-programa')]
    public $filtro_tipo_programa = ''; // Tipo de programa (Doctorado, Maestría, etc.)
    #[Url(except: '', as: 'facultad')]
    public $filtro_facultad = '';// Facultad (Ingeniería, Ciencias, etc.)
    #[Url(except: '', as: 'programa')]
    public $filtro_programa = ''; // Programa (Ingeniería de Sistemas, Educacion, etc.)
    #[Url(except: '', as: 'ciclo')]
    public $filtro_ciclo = ''; // Ciclo (I, II, III, etc.)
    #[Url(except: '', as: 'plan-estudio')]
    public $filtro_plan_estudio = ''; // Plan de estudio (2010, 2015, etc.)
    #[Url(except: '', as: 'proceso')]
    public $filtro_proceso = ''; // Proceso (2021-1, 2021-2, etc.)
    #[Url(except: '', as: 'en-curso')]
    public $filtro_en_curso = ''; // Filtro para mostrar cursos en curso o finalizados

    // Variables para el modal de registro y edición
    public $titulo_modal = 'Registrar carga académica o curso a dictar';
    public $accion_modal = 'Registrar';
    public $modo = 1; // 1: Registrar, 0: Editar
    #[Validate('required|integer', as: 'curso')]
    public $id_curso;
    #[Validate('required|max:1|regex:/^[a-zA-Z]+$/', as: 'grupo')]
    public $grupo_gestion_aula;
    #[Validate('required|integer', as: 'proceso')]
    public $id_proceso;
    #[Validate('nullable|integer', as: 'docente')]
    public $id_docente;
    #[Validate('nullable|array', as: 'alumnos')]
    public $alumnos_seleccionados;
    public $id_gestion_aula;

    // Variables para el modal de eliminación
    public $id_gestion_aula_eliminar;
    public $curso_a_eliminar;
    public $proceso_a_eliminar;
    public $docente_a_eliminar;

    public $filtro_activo = false;
    public $config_activo = false;
    public $estado_carga_modal = true;

    public $tipo_vista_curso = 'carga-academica';

    // Variables para page-header
    public $titulo_page_header = 'LISTA DE CURSOS - CARGA ACADÉMICA';
    public $links_page_header = [];
    public $regresar_page_header;


    public function guardar_carga_academica()
    {
        // dd($this->id_curso, $this->grupo_gestion_aula, $this->id_proceso, $this->id_docente, $this->alumnos_seleccionados);
        $this->validate([
            'id_curso' => 'required|integer',
            'grupo_gestion_aula' => 'required|max:1|regex:/^[a-zA-Z]+$/',
            'id_proceso' => 'required|integer',
            'id_docente' => 'nullable|integer',
            'alumnos_seleccionados' => 'nullable|array'
        ]);

        try
        {
            DB::beginTransaction();

            if ($this->modo === 0) {
                $gestion_aula = GestionAula::where('id_gestion_aula', $this->id_gestion_aula)->first();

                $gestion_aula->grupo_gestion_aula = strtoupper($this->grupo_gestion_aula);
                $gestion_aula->id_curso = $this->id_curso;
                $gestion_aula->id_proceso = $this->id_proceso;
                $gestion_aula->save();

                if ($this->id_docente) {
                    $gestion_aula_docente = $gestion_aula->gestionAulaDocente->first();
                    if ($gestion_aula_docente) {
                        $gestion_aula_docente->id_usuario = $this->id_docente;
                        $gestion_aula_docente->save();
                    } else {
                        $gestion_aula->gestionAulaDocente()->create([
                            'estado_gestion_aula_docente' => true,
                            'id_usuario' => $this->id_docente,
                        ]);
                    }
                }

                // Validar si hay alumnos en gestión de aula-alumno
                if ($gestion_aula->gestionAulaAlumno->isEmpty()) {
                    foreach ($this->alumnos_seleccionados as $alumno) {
                        $gestion_aula->gestionAulaAlumno()->create([
                            'estado_gestion_aula_alumno' => true,
                            'id_usuario' => $alumno,
                        ]);
                    }
                } else {
                    // Comparar los alumnos seleccionados con los alumnos matriculados, si hay diferencias, actualizar
                    $comparar_alumnos = $gestion_aula->gestionAulaAlumno->pluck('id_usuario')->toArray();
                    $diferencias_menos = array_diff($comparar_alumnos, $this->alumnos_seleccionados);
                    $diferencias_mas = array_diff($this->alumnos_seleccionados, $comparar_alumnos);

                    if ($diferencias_menos) {
                        $gestion_aula->gestionAulaAlumno()->whereIn('id_usuario', $diferencias_menos)->delete();
                    }
                    if ($diferencias_mas) {
                        foreach ($diferencias_mas as $alumno) {
                            $gestion_aula->gestionAulaAlumno()->create([
                                'estado_gestion_aula_alumno' => true,
                                'id_usuario' => $alumno,
                            ]);
                        }
                    }
                }

            } else {
                $gestion_aula = GestionAula::create([
                    'grupo_gestion_aula' => strtoupper($this->grupo_gestion_aula),
                    'estado_gestion_aula' => true,
                    'en_curso_gestion_aula' => true,
                    'id_curso' => $this->id_curso,
                    'id_proceso' => $this->id_proceso
                ]);

                if ($this->id_docente) {
                    $gestion_aula->gestionAulaDocente()->create([
                        'estado_gestion_aula_docente' => true,
                        'id_usuario' => $this->id_docente,
                    ]);
                }

                if ($this->alumnos_seleccionados) {
                    foreach ($this->alumnos_seleccionados as $alumno) {
                        $gestion_aula->gestionAulaAlumno()->create([
                            'estado_gestion_aula_alumno' => true,
                            'id_usuario' => $alumno,
                        ]);
                    }
                }
            }

            // $gestion_aula->load('gestionAulaAlumno', 'gestionAulaDocente');
            // dd($gestion_aula->toArray(), $gestion_aula->gestionAulaDocente->toArray(), $gestion_aula->gestionAulaAlumno->toArray());

            DB::commit();

            $this->cerrar_modal();
            $this->limpiar_modal();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Carga académica registrada correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar la carga académica',
                type: 'error'
            );
        }
    }


    public function eliminar_carga_academica()
    {
        try
        {
            DB::beginTransaction();

            $gestion_aula = GestionAula::with([
                'asistencia',
                'trabajoAcademico',
                'linkClase',
                'presentacion',
                'recurso',
                'foro',
                'silabus',
                'webgrafia',
                'gestionAulaDocente',
                'gestionAulaAlumno'
            ])->where('id_gestion_aula', $this->id_gestion_aula_eliminar)->first();

            // Validar si la gestión de aula tiene registros tablas de asistencia, trabajo académico, link de clases, prsentacion, recurso, foro, silabus, webgrafía
            // Si tiene registros, no se puede eliminar
            if ($gestion_aula->asistencia->isNotEmpty() ||
                $gestion_aula->trabajoAcademico->isNotEmpty() ||
                $gestion_aula->recurso->isNotEmpty() ||
                $gestion_aula->foro->isNotEmpty() ||
                $gestion_aula->webgrafia->isNotEmpty() ||
                $gestion_aula->linkClase !== null ||
                $gestion_aula->presentacion !== null ||
                $gestion_aula->silabus !== null)
            {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'No se puede eliminar la carga académica, tiene registros asociados',
                    type: 'error'
                );
                $this->cerrar_modal('#modal-eliminar-carga-academica');
                $this->limpiar_modal_eliminar();
                return;
            }

            // Eliminar gestión de aula y sus relaciones (docente y alumnos)
            $gestion_aula->gestionAulaDocente()->delete();
            $gestion_aula->gestionAulaAlumno()->delete();
            $gestion_aula->delete();

            DB::commit();

            $this->cerrar_modal('#modal-eliminar-carga-academica');
            $this->limpiar_modal_eliminar();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Carga académica eliminada correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al eliminar la carga académica',
                type: 'error'
            );
        }
    }


    #[On('abrir-modal-editar-carga-academica')]
    public function abrir_modal_carga_academica($id_gestion_aula = null)
    {
        $this->limpiar_modal();
        if ($id_gestion_aula) {
            $this->id_gestion_aula = $id_gestion_aula;
            $gestion_aula = GestionAula::with(['curso', 'gestionAulaDocente', 'gestionAulaAlumno'])
                ->find($id_gestion_aula)->first();

            $this->modo = 0;
            $this->titulo_modal = 'Editar carga académica o curso a dictar';
            $this->accion_modal = 'Editar';

            $this->dispatch('set-id-curso', data: $gestion_aula->id_curso);
            $this->dispatch('set-id-docente', data: $gestion_aula->gestionAulaDocente->first()->id_usuario ?? null);
            $this->dispatch('set-alumnos-matriculados', data: $gestion_aula->gestionAulaAlumno->pluck('id_usuario')->toArray() ?? []);

            $this->id_curso = $gestion_aula->id_curso;
            $this->grupo_gestion_aula = $gestion_aula->grupo_gestion_aula;
            $this->id_proceso = $gestion_aula->id_proceso;
            $this->id_docente = $gestion_aula->gestionAulaDocente->first()->id_usuario ?? null;
            $this->alumnos_seleccionados = $gestion_aula->gestionAulaAlumno->pluck('id_usuario')->toArray() ?? [];
        } else {
            $this->modo = 1;
            $this->titulo_modal = 'Registrar carga académica o curso a dictar';
            $this->accion_modal = 'Registrar';
        }

        $this->estado_carga_modal = false;
    }


    #[On('abrir-modal-eliminar-carga-academica')]
    public function abrir_modal_eliminar_carga_academica($id_gestion_aula)
    {
        $gestion_aula = GestionAula::with(['curso', 'proceso', 'gestionAulaDocente'])
            ->find($id_gestion_aula)->first();

        $this->id_gestion_aula_eliminar = $id_gestion_aula;
        $this->curso_a_eliminar = $gestion_aula->curso->nombre_curso . ' - ' . $gestion_aula->grupo_gestion_aula;
        $this->proceso_a_eliminar = $gestion_aula->proceso->nombre_proceso;
        $this->docente_a_eliminar = $gestion_aula->gestionAulaDocente->first()->usuario->nombre_completo ?? 'Sin docente asignado';

        $this->estado_carga_modal = false;
    }


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal = '#modal-carga-academica')
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: 'hide'
        );
    }


    public function limpiar_modal_eliminar()
    {
        $this->reset([
            'id_gestion_aula_eliminar',
            'curso_a_eliminar',
            'proceso_a_eliminar',
            'docente_a_eliminar'
        ]);
        $this->resetErrorBag();
        $this->estado_carga_modal = true;
    }


    public function limpiar_modal()
    {
        $this->modo = 1;
        $this->titulo_modal = 'Registrar carga académica o curso a dictar';
        $this->accion_modal = 'Registrar';
        $this->dispatch('set-reset');
        $this->reset([
            'id_curso',
            'grupo_gestion_aula',
            'id_proceso',
            'id_docente',
            'alumnos_seleccionados',
            'id_gestion_aula'
        ]);
        $this->resetErrorBag();
        $this->estado_carga_modal = true;
    }


    private function validar_facultad($facultades)
    {
        // Verificar si la facultad seleccionada es válida
        $facultadValida = $facultades->contains(fn($facultad) => intval($facultad->id_facultad) === intval($this->filtro_facultad));

        // Si la facultad no es válida, limpiar el filtro
        if (!$facultadValida) {
            $this->filtro_facultad = '';
        }
    }


    public function validar_programa($programas)
    {
        // Verificar si el programa seleccionado es válido
        $programaValido = $programas->contains(fn($programa) => intval($programa->id_programa) === intval($this->filtro_programa));

        // Si el programa no es válido, limpiar el filtro
        if (!$programaValido) {
            $this->filtro_programa = '';
        }
    }


    /**
     * Obtener datos para mostrar el componente Page Header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'LISTA DE CURSOS - CARGA ACADÉMICA';

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];
    }


    public function mount()
    {
        $this->obtener_datos_page_header();
    }


    public function render()
    {
        $cursos = GestionAula::with(['curso'])
            ->estado(true)
            ->orderBy('created_at', 'desc')
            ->search($this->search)
            ->tipoPrograma($this->filtro_tipo_programa)
            ->facultad($this->filtro_facultad)
            ->programa($this->filtro_programa)
            ->ciclo($this->filtro_ciclo)
            ->planEstudio($this->filtro_plan_estudio)
            ->proceso($this->filtro_proceso)
            ->enCurso($this->filtro_en_curso)
            ->paginate($this->mostrar_paginate);


        $tipo_programas = TipoPrograma::estado(true)->get();

        $facultades = $this->filtro_tipo_programa !== ''
            ? Programa::with('facultad')
                ->estado(true)
                ->tipoPrograma($this->filtro_tipo_programa)
                ->get()
                ->pluck('facultad')
                ->unique()
            : Facultad::estado(true)->get();

        $this->validar_facultad($facultades);

        if ($this->filtro_facultad != '' && $this->filtro_tipo_programa != '') {
            $programas = Programa::estado(true)->facultad($this->filtro_facultad)->tipoPrograma($this->filtro_tipo_programa)->get();
            $this->validar_programa($programas);
        } else {
            $programas = [];
            $this->filtro_programa = '';
        }
        $ciclos = Ciclo::estado(true)->get();
        $planes_estudio = PlanEstudio::estado(true)->get();
        $procesos = Proceso::estado(true)->get();

        $cursos_carga_academica = Curso::with(['ciclo', 'programa', 'programa.tipoPrograma', 'planEstudio'])
            ->estado(true)->get();

        $docentes = Usuario::with(['roles', 'persona'])
            ->rol('DOCENTE')
            ->estado(true)
            ->get();

        $alumnos = Usuario::with(['roles', 'persona'])
            ->rol('ALUMNO')
            ->estado(true)
            ->get();

        if ($this->modo === 0) {
            $alumnos_matriculados = Persona::with([
                'usuario' => function ($query) {
                    $query->with([
                        'gestionAulaAlumno' => function ($query) {
                            $query->where('id_gestion_aula', $this->id_gestion_aula);
                        }
                    ]);
                }
            ])
                ->whereHas('usuario.gestionAulaAlumno', function ($query) {
                    $query->where('id_gestion_aula', $this->id_gestion_aula)
                        ->estado(true);
                })
                ->search($this->search_alumnos)
                ->orderBy('nombres_persona', 'asc')
                ->orderBy('apellido_paterno_persona', 'asc')
                ->orderBy('apellido_materno_persona', 'asc')
                ->paginate($this->mostrar_paginate_alumnos);
        } else {
            $alumnos_matriculados = [];
        }

        return view('livewire.gestion-aula.carga-academica.index', compact([
            'cursos',
            'tipo_programas',
            'facultades',
            'programas',
            'ciclos',
            'planes_estudio',
            'procesos',
            'cursos_carga_academica',
            'docentes',
            'alumnos',
            'alumnos_matriculados'
        ]));
    }
}
