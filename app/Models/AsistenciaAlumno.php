<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AsistenciaAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asistencia_alumno';
    protected $primaryKey = 'id_asistencia_alumno';
    protected $fillable = [
        'id_asistencia_alumno',
        'id_asistencia',
        'id_estado_asistencia',
        'id_gestion_aula_usuario',
    ];

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id_asistencia');
    }

    public function estadoAsistencia()
    {
        return $this->belongsTo(EstadoAsistencia::class, 'id_estado_asistencia');
    }

    public function gestionAulaUsuario()
    {
        return $this->belongsTo(GestionAulaUsuario::class, 'id_gestion_aula_usuario');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asistencia_alumno) {
            $asistencia_alumno->created_by = Auth::id();
        });
        static::updating(function ($asistencia_alumno) {
            $asistencia_alumno->updated_by = Auth::id();
        });
        static::deleting(function ($asistencia_alumno) {
            $asistencia_alumno->deleted_by = Auth::id();
            $asistencia_alumno->save();
        });
    }
}
