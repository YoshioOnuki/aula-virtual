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

    protected $casts = [
        'estado_estado_asistencia' => 'boolean',
    ];

    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_estado_asistencia');
    }

    public $timestamps = false;

}
