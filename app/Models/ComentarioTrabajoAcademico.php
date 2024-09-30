<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ComentarioTrabajoAcademico extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'comentario_trabajo_academico';
    protected $primaryKey = 'id_comentario_trabajo_academico';
    protected $fillable = [
        'id_comentario_trabajo_academico',
        'descripcion_comentario_trabajo_academico',
        'id_trabajo_academico_alumno',
        'id_gestion_aula_docente',
    ];

    public function trabajoAcademicoAlumno()
    {
        return $this->belongsTo(TrabajoAcademicoAlumno::class, 'id_trabajo_academico_alumno');
    }

    public function gestionAulaDocente()
    {
        return $this->belongsTo(GestionAulaDocente::class, 'id_gestion_aula_docente');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comentario_trabajo_academico) {
            $comentario_trabajo_academico->created_by = Auth::id();
        });
        static::updating(function ($comentario_trabajo_academico) {
            $comentario_trabajo_academico->updated_by = Auth::id();
        });
        static::deleting(function ($comentario_trabajo_academico) {
            $comentario_trabajo_academico->deleted_by = Auth::id();
            $comentario_trabajo_academico->save();
        });
    }
}
