<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAulaUsuario extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula_usuario';
    protected $primaryKey = 'id_gestion_aula_usuario';
    protected $fillable = [
        'id_gestion_aula_usuario',
        'estado_gestion_aula_usuario',
        'id_usuario',
        'id_usuario_rol',
        'id_gestion_aula',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function usuarioRol()
    {
        return $this->belongsTo(UsuarioRol::class, 'id_usuario_rol');
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_aula_usuario) {
            $gestion_aula_usuario->created_by = auth()->id();
        });
        static::updating(function ($gestion_aula_usuario) {
            $gestion_aula_usuario->updated_by = auth()->id();
        });
        static::deleting(function ($gestion_aula_usuario) {
            $gestion_aula_usuario->deleted_by = auth()->id();
            $gestion_aula_usuario->save();
        });
    }
}
