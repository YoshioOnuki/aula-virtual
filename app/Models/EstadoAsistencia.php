<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoAsistencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'estado_asistencia';
    protected $primaryKey = 'id_estado_asistencia';
    protected $fillable = [
        'id_estado_asistencia',
        'nombre_estado_asistencia',
        'estado_estado_asistencia',
    ];

    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_estado_asistencia');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($estado_asistencia) {
            $estado_asistencia->created_by = auth()->id();
        });
        static::updating(function ($estado_asistencia) {
            $estado_asistencia->updated_by = auth()->id();
        });
        static::deleting(function ($estado_asistencia) {
            $estado_asistencia->deleted_by = auth()->id();
            $estado_asistencia->save();
        });
    }
}
