<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAulaUsuario extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula_usuario';
    protected $primaryKey = 'id_gestion_aula_usuario';
    protected $fillable = [
        'id_gestion_aula_usuario',
        'estado_gestion_aula_usuario',
        'favorito_gestion_aula_usuario',
        'id_usuario',
        'id_rol',
        'id_gestion_aula',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_gestion_aula_usuario');
    }

    public function foroRespuesta()
    {
        return $this->hasMany(ForoRespuesta::class, 'id_gestion_aula_usuario');
    }

    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_gestion_aula_usuario');
    }

    public function comentarioTrabajoAcademico()
    {
        return $this->hasMany(ComentarioTrabajoAcademico::class, 'id_gestion_aula_usuario');
    }

    // Usar el search del scope de usuario
    public function scopeSearchUsuario($query, $search)
    {
        if ($search) {
            return $query->whereHas('usuario', function ($query) use ($search) {
                $query->search($search);
            });
        }
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_aula_usuario) {
            $gestion_aula_usuario->created_by = Auth::id();
        });
        static::updating(function ($gestion_aula_usuario) {
            $gestion_aula_usuario->updated_by = Auth::id();
        });
        static::deleting(function ($gestion_aula_usuario) {
            $gestion_aula_usuario->deleted_by = Auth::id();
            $gestion_aula_usuario->save();
        });
    }
}
