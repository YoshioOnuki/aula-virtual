<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula';
    protected $primaryKey = 'id_gestion_aula';
    protected $fillable = [
        'id_gestion_aula',
        'estado_gestion_aula',
        'id_gestion_curso',
    ];

    public function gestionCurso()
    {
        return $this->belongsTo(GestionCurso::class, 'id_gestion_curso');
    }

    public function asistencia()
    {
        return $this->hasMany(Asistencia::class, 'id_gestion_aula');
    }

    public function gestionAulaUsuario()
    {
        return $this->hasMany(GestionAulaUsuario::class, 'id_gestion_aula');
    }

    public function lectura()
    {
        return $this->hasMany(Lectura::class, 'id_gestion_aula');
    }

    public function foro()
    {
        return $this->hasMany(Foro::class, 'id_gestion_aula');
    }

    public function link_clase()
    {
        return $this->hasMany(LinkClase::class, 'id_gestion_aula');
    }

    public function presentacion()
    {
        return $this->hasMany(Presentacion::class, 'id_gestion_aula');
    }

    public function silabus()
    {
        return $this->hasMany(Silabus::class, 'id_gestion_aula');
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
            $gestion_aula->created_by = auth()->id();
        });

        static::updating(function ($gestion_aula) {
            $gestion_aula->updated_by = auth()->id();
        });

        static::deleting(function ($gestion_aula) {
            $gestion_aula->deleted_by = auth()->id();
            $gestion_aula->save();
        });
    }
}
