<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'plan_estudio';
    protected $primaryKey = 'id_plan_estudio';
    protected $fillable = [
        'id_plan_estudio',
        'nombre_plan_estudio',
        'anio_plan_estudio',
        'estado_plan_estudio',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_plan_estudio',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_plan_estudio' => 'boolean',
    ];


    /**
     * Retorna curso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function curso()
    {
        return $this->hasMany(Curso::class, 'id_plan_estudio');
    }


    /**
     * Retorna nombre_estado_plan_estudio
     *
     * @return string
     */
    public function getNombreEstadoPlanEstudioAttribute() : string
    {
        return $this->estado_plan_estudio ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;

}
