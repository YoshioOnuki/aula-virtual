<?php

use App\Livewire\Configuracion\Perfil\Index as PerfilIndex;
use App\Livewire\Configuracion\Proceso\Index as ProcesoIndex;
use App\Livewire\Configuracion\Usuario\Index as UsuarioIndex;
use App\Livewire\GestionAula\Curso\Detalle as CursoDetalle;
use App\Livewire\GestionAula\Curso\Index as CursoIndex;
use App\Livewire\GestionAula\Manuales\Index as ManualesIndex;
use App\Livewire\GestionAula\PlanEstudio\Index as PlanEstudioIndex;
use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Seguridad\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/inicio');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', HomeIndex::class)
        ->name('inicio');

    Route::get('/perfil', PerfilIndex::class)
        ->name('perfil');

    Route::get('/usuarios', UsuarioIndex::class)
        ->name('usuarios');
    
    Route::get('/proceso', ProcesoIndex::class)
        ->name('proceso');

    Route::get('/registro-alumnos', UsuarioIndex::class)
        ->name('registro-alumnos');

    Route::get('/cursos', CursoIndex::class)
        ->name('cursos');
    Route::get('/cursos/detalle', CursoDetalle::class)
        ->name('cursos.detalle');

    Route::get('/carga-academica', CursoIndex::class)
        ->name('carga-academica');

    Route::get('/plan-estudio', PlanEstudioIndex::class)
        ->name('plan-estudio');

    Route::get('/manuales', ManualesIndex::class)
        ->name('manuales');

    Route::get('/perfil', PerfilIndex::class)
        ->name('perfil');
});