<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTrabajoAcademico extends Model
{
    use HasFactory;

    protected $table = 'estado_trabajo_academico';
    protected $primaryKey = 'id_estado_trabajo_academico';
    protected $fillable = [
        'id_estado_trabajo_academico',
        'nombre_estado_trabajo_academico',
        'estado_estado_trabajo_academico',
    ];

    protected $casts = [
        'estado_estado_trabajo_academico' => 'boolean',
    ];

    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_estado_trabajo_academico');
    }

    public $timestamps = false;

}
