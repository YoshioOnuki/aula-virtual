<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAulaAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula_alumno';
    protected $primaryKey = 'id_gestion_aula_alumno';
    protected $fillable = [
        'id_gestion_aula_alumno',
        'estado_gestion_aula_alumno',
        'id_usuario',
        'id_gestion_aula',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_gestion_aula_alumno');
    }

    public function foroRespuesta()
    {
        return $this->hasMany(ForoRespuesta::class, 'id_gestion_aula_alumno');
    }

    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_gestion_aula_alumno');
    }

    // Usar el search del scope de usuario para buscar alumnos
    public function scopeSearchAlumno($query, $search)
    {
        if ($search) {
            return $query->whereHas('usuario', function ($query) use ($search) {
                $query->searchAlumno($search);
            });
        }
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_gestion_aula_alumno', $estado);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_aula_alumno) {
            $gestion_aula_alumno->created_by = Auth::id();
        });
        static::updating(function ($gestion_aula_alumno) {
            $gestion_aula_alumno->updated_by = Auth::id();
        });
        static::deleting(function ($gestion_aula_alumno) {
            $gestion_aula_alumno->deleted_by = Auth::id();
            $gestion_aula_alumno->save();
        });
    }
}
