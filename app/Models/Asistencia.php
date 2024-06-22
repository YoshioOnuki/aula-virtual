<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asistencia';
    protected $primaryKey = 'id_asistencia';
    protected $fillable = [
        'id_asistencia',
        'nombre_asistencia',
        'fecha_asistencia',
        'hora_inicio_asistencia',
        'hora_fin_asistencia',
        'id_gestion_aula',
    ];

    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_asistencia');
    }

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function scopeSearch($query, $search) {
        if ($search == null) {
            return $query;
        }

        return $query->where(function($query) use ($search) {
            $query->where('nombre_asistencia', 'like', '%'.$search.'%')
                ->orWhere('fecha_asistencia', 'like', '%'.$search.'%')
                ->orWhere('hora_inicio_asistencia', 'like', '%'.$search.'%')
                ->orWhere('hora_fin_asistencia', 'like', '%'.$search.'%')
                ->orWhereHas('asistenciaAlumno', function($query) use ($search) {
                    $query->whereHas('estadoAsistencia', function($query) use ($search) {
                        $query->where('nombre_estado_asistencia', 'like', '%'.$search.'%');
                    });
                });
        });
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asistencia) {
            $asistencia->created_by = auth()->id();
        });
        static::updating(function ($asistencia) {
            $asistencia->updated_by = auth()->id();
        });
        static::deleting(function ($asistencia) {
            $asistencia->deleted_by = auth()->id();
            $asistencia->save();
        });
    }
}
