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
     * Los atributos que deben ser convertidos.
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
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;

}
