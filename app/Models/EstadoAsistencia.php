<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAsistencia extends Model
{
    use HasFactory;

    protected $table = 'estado_asistencia';
    protected $primaryKey = 'id_estado_asistencia';
    protected $fillable = [
        'id_estado_asistencia',
        'nombre_estado_asistencia',
        'estado_estado_asistencia',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_asistencia',
    ];

    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_estado_asistencia' => 'boolean',
    ];


    /**
     * Retorna asistenciaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_estado_asistencia');
    }


    /**
     * Retorna nombre_estado_asistencia
     *
     * @return string
     */
    public function getNombreEstadoAsistenciaAttribute() : string
    {
        return $this->estado_estado_asistencia ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;
}
