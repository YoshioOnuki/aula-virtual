<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula';
    protected $primaryKey = 'id_gestion_aula';
    protected $fillable = [
        'id_gestion_aula',
        'grupo_gestion_aula',
        'fondo_gestion_aula',
        'estado_gestion_aula',
        'id_curso',
        'id_proceso',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'id_proceso');
    }

    public function asistencia()
    {
        return $this->hasMany(Asistencia::class, 'id_gestion_aula');
    }

    public function gestionAulaUsuario()
    {
        return $this->hasMany(GestionAulaUsuario::class, 'id_gestion_aula');
    }

    public function recurso()
    {
        return $this->hasMany(Recurso::class, 'id_gestion_aula');
    }

    public function foro()
    {
        return $this->hasMany(Foro::class, 'id_gestion_aula');
    }

    public function linkClase()
    {
        return $this->hasOne(LinkClase::class, 'id_gestion_aula');
    }

    public function presentacion()
    {
        return $this->hasOne(Presentacion::class, 'id_gestion_aula');
    }

    public function silabus()
    {
        return $this->hasOne(Silabus::class, 'id_gestion_aula');
    }

    public function webgrafia()
    {
        return $this->hasMany(Webgrafia::class, 'id_gestion_aula');
    }

    public function trabajoAcademico()
    {
        return $this->hasMany(TrabajoAcademico::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_aula) {
            $gestion_aula->created_by = Auth::id();
        });

        static::updating(function ($gestion_aula) {
            $gestion_aula->updated_by = Auth::id();
        });

        static::deleting(function ($gestion_aula) {
            $gestion_aula->deleted_by = Auth::id();
            $gestion_aula->save();
        });
    }
}
