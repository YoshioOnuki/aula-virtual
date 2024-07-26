<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrabajoAcademico extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trabajo_academico';
    protected $primaryKey = 'id_trabajo_academico';
    protected $fillable = [
        'id_trabajo_academico',
        'titulo_trabajo_academico',
        'descripcion_trabajo_academico',
        'fecha_inicio_trabajo_academico',
        'fecha_fin_trabajo_academico',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_trabajo_academico');
    }

    public function archivoDocente()
    {
        return $this->hasMany(ArchivoDocente::class, 'id_trabajo_academico');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trabajo_academico) {
            $trabajo_academico->created_by = auth()->id();
        });
        static::updating(function ($trabajo_academico) {
            $trabajo_academico->updated_by = auth()->id();
        });
        static::deleting(function ($trabajo_academico) {
            $trabajo_academico->deleted_by = auth()->id();
            $trabajo_academico->save();
        });
    }
}
