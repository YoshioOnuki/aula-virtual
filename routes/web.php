<?php

use App\Livewire\AlumnosDocentes\Index as AlumnosDocentesIndex;
use App\Livewire\Configuracion\Autoridades\Index as AutoridadesIndex;
use App\Livewire\Configuracion\Perfil\Index as PerfilIndex;
use App\Livewire\Configuracion\Usuario\Index as UsuarioIndex;
use App\Livewire\GestionAula\Alumnos\Index as AlumnoIndex;
use App\Livewire\GestionAula\Asistencia\Index as AsistenciaIndex;
use App\Livewire\GestionAula\Curso\Detalle as CursoDetalle;
use App\Livewire\GestionAula\Curso\Index as CursoIndex;
use App\Livewire\GestionAula\Foro\Index as ForoIndex;
use App\Livewire\GestionAula\Manuales\Index as ManualesIndex;
use App\Livewire\GestionAula\PlanEstudio\Index as PlanEstudioIndex;
use App\Livewire\GestionAula\Recurso\Index as RecursoIndex;
use App\Livewire\GestionAula\Silabus\Index as SilabusIndex;
use App\Livewire\GestionAula\TrabajoAcademico\Index as TrabajoAcademicoIndex;
use App\Livewire\GestionAula\Webgrafia\Index as WebgrafiaIndex;
use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Seguridad\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/inicio');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', HomeIndex::class)
        ->name('dashboard');

    // Inicio
    Route::get('/inicio', HomeIndex::class)
        ->name('inicio');


    /* =============== SEGURIDAD Y CONFIGURACION =============== */
    // Perfil
    Route::get('/perfil', PerfilIndex::class)
        ->name('perfil');

    // Usuarios
    Route::get('/usuarios', UsuarioIndex::class)
        ->name('usuarios');

    // Registro de alumnos
    Route::get('/registro-alumnos', UsuarioIndex::class)
        ->name('registro-alumnos');

    // Autoridades
    Route::get('/autoridades', AutoridadesIndex::class)
        ->name('autoridades');


    /* =============== ESTRUCTURA ACADEMICA =============== */
    // Grupo de ruta para el profijo estructura academica
    Route::prefix('estructura-academica')->group(function () {
        // Nivel academico
        Route::get('/nivel-academico', HomeIndex::class)
            ->name('estructura-academica.nivel-academico');
        // Tipo programa
        Route::get('/tipo-programa', HomeIndex::class)
            ->name('estructura-academica.tipo-programa');
        // Facultad
        Route::get('/facultad', HomeIndex::class)
            ->name('estructura-academica.facultad');
        // Programa
        Route::get('/programa', HomeIndex::class)
            ->name('estructura-academica.programa');
    });


    /* =============== GESTION DEL CURSO =============== */
    // Grupo de ruta para el profijo gestion del curso
    Route::prefix('gestion-curso')->group(function () {
        // Plan de estudio
        Route::get('/plan-estudio', PlanEstudioIndex::class)
            ->name('gestion-curso.plan-estudio');
        // Ciclo
        Route::get('/ciclo', HomeIndex::class)
            ->name('gestion-curso.ciclo');
        // Proceso
        Route::get('/proceso', PerfilIndex::class)
            ->name('gestion-curso.proceso');
        // Curso
        Route::get('/curso', CursoIndex::class)
            ->name('gestion-curso.curso');
    });


    /* =============== GESTION DEL AULA =============== */
    // Grupo de ruta para el profijo gestion del aula
    Route::prefix('gestion-aula')->group(function () {
        //------ BUSQUEDA DE ALUMNOS Y DOCENTES ------//
        // Busqueda de alumnos
        Route::get('/alumnos', AlumnosDocentesIndex::class)
        ->name('alumnos');

        // Busqueda de docentes
        Route::get('/docentes', AlumnosDocentesIndex::class)
            ->name('docentes');

        //------ Alumno ------//
        // Cursos
        Route::get('/alumno/{id_usuario}/{tipo_vista}', CursoIndex::class)
        ->name('cursos');
        // Curso detalle
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/detalle', CursoDetalle::class)
            ->name('cursos.detalle');
        // Silabus
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/silabus', SilabusIndex::class)
            ->name('cursos.detalle.silabus');
        // Lectura
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/recursos', RecursoIndex::class)
            ->name('cursos.detalle.recursos');
        // Foro
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/foro', ForoIndex::class)
            ->name('cursos.detalle.foro');
        // Asistencia
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/asistencia', AsistenciaIndex::class)
            ->name('cursos.detalle.asistencia');
        // Trabajos academicos
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/trabajo-academico', TrabajoAcademicoIndex::class)
            ->name('cursos.detalle.trabajo-academico');
        // Webgrafía
        Route::get('/alumno/{id_usuario}/{tipo_vista}/{id_curso}/webgrafia', WebgrafiaIndex::class)
            ->name('cursos.detalle.webgrafia');

        //------ Docente ------//
        // Carga academico
        Route::get('/docente/{id_usuario}/{tipo_vista}', CursoIndex::class)
            ->name('carga-academica');
        // Cargo academico detalle
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/detalle', CursoDetalle::class)
            ->name('carga-academica.detalle');
        // Silabus
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/silabus', SilabusIndex::class)
            ->name('carga-academica.detalle.silabus');
        // Lectura
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/recursos', RecursoIndex::class)
            ->name('carga-academica.detalle.recursos');
        // Foro
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/foro', ForoIndex::class)
            ->name('carga-academica.detalle.foro');
        // Asistencia
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/asistencia', AsistenciaIndex::class)
            ->name('carga-academica.detalle.asistencia');
        // Trabajos academicos
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/trabajo-academico', TrabajoAcademicoIndex::class)
            ->name('carga-academica.detalle.trabajo-academico');
        // Webgrafía
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/webgrafia', WebgrafiaIndex::class)
            ->name('carga-academica.detalle.webgrafia');
        // Alumnos
        Route::get('/docente/{id_usuario}/{tipo_vista}/{id_curso}/alumnos', AlumnoIndex::class)
            ->name('carga-academica.detalle.alumnos');
    });


    /* =============== EXTRAS =============== */
    // Calificaciones
    Route::get('/calificaciones', HomeIndex::class)
        ->name('calificaciones');

    // Plan de estudio
    Route::get('/plan-estudio', PlanEstudioIndex::class)
        ->name('plan-estudio');

    // Manuales
    Route::get('/manuales', ManualesIndex::class)
        ->name('manuales');


});
