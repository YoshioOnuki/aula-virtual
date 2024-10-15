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


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_trabajo_academico',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_estado_trabajo_academico' => 'boolean',
    ];


    /**
     * Retorna trabajoAcademicoAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_estado_trabajo_academico');
    }


    /**
     * Retorna nombre_estado_trabajo_academico
     *
     * @return string
     */
    public function getNombreEstadoTrabajoAcademicoAttribute() : string
    {
        return $this->estado_estado_trabajo_academico ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;

}
