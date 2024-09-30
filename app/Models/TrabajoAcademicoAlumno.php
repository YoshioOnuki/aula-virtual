<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TrabajoAcademicoAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trabajo_academico_alumno';
    protected $primaryKey = 'id_trabajo_academico_alumno';
    protected $fillable = [
        'id_trabajo_academico_alumno',
        'descripcion_trabajo_academico_alumno',
        'nota_trabajo_academico_alumno',
        'id_estado_trabajo_academico',
        'id_trabajo_academico',
        'id_gestion_aula_alumno',
    ];

    protected $casts = [
        'nota_trabajo_academico_alumno' => 'decimal:2',
    ];

    public function estadoTrabajoAcademico()
    {
        return $this->belongsTo(EstadoTrabajoAcademico::class, 'id_estado_trabajo_academico');
    }

    public function trabajoAcademico()
    {
        return $this->belongsTo(TrabajoAcademico::class, 'id_trabajo_academico');
    }

    public function gestionAulaAlumno()
    {
        return $this->belongsTo(GestionAulaAlumno::class, 'id_gestion_aula_alumno');
    }

    public function comentarioTrabajoAcademico()
    {
        return $this->hasMany(ComentarioTrabajoAcademico::class, 'id_trabajo_academico_alumno');
    }

    public function archivoAlumno()
    {
        return $this->hasMany(ArchivoAlumno::class, 'id_trabajo_academico_alumno');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trabajo_academico_alumno) {
            $trabajo_academico_alumno->created_by = Auth::id();
        });
        static::updating(function ($trabajo_academico_alumno) {
            $trabajo_academico_alumno->updated_by = Auth::id();
        });
        static::deleting(function ($trabajo_academico_alumno) {
            $trabajo_academico_alumno->deleted_by = Auth::id();
            $trabajo_academico_alumno->save();
        });
    }
}
