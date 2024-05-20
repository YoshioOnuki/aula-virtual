<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'id_usuario',
        'correo_usuario',
        'contrasenia_usuario',
        'foto_usuario',
        'estado_usuario',
        'id_persona',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function usuarioRol()
    {
        return $this->hasMany(UsuarioRol::class, 'id_usuario');
    }

    public function rol()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'id_usuario', 'id_rol');
    }
    

    public function gestionAulaUsuario(){
        return $this->hasMany(GestionAulaUsuario::class, 'id_usuario');
    }

    // Validar que rol es, mandando como parametro el nombre del rol
    public function esRol($nombreRol)
    {
        foreach ($this->rol as $rol) {
            if ($rol->nombre_rol == $nombreRol) {
                return true;
            }
        }
        return false;
    }

    public function MostrarFoto($tipo)
    {
        $color = '000000';
        $color_lt = 'ffffff';

        if($tipo === 'usuario')
        {
            $color = config('settings.color_usuario');
            $color_lt = config('settings.color_lt_usuario');
        }

        if($tipo === 'docente')
        {
            $color = config('settings.color_docentes');
            $color_lt = config('settings.color_lt_docentes');
        }

        if($tipo === 'alumno')
        {
            $color = config('settings.color_alumnos');
            $color_lt = config('settings.color_lt_alumnos');
        }

        return $this->foto_usuario ?? 'https://ui-avatars.com/api/?name=' . $this->persona->solo_primeros_nombres . '&size=64&&color='. $color_lt .'&background='. $color .'&bold=true';
    }

    //Mostrar el rol, si tiene mas de un rol, concatenar
    public function mostrarRol()
    {
        $roles = '';
        foreach ($this->rol as $rol) {
            $roles .= $rol->nombre_rol . ', ';
        }
        return substr($roles, 0, -2);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->persona->nombre_completo;
    }

    public function getSoloPrimerosNombresAttribute()
    {
        return $this->persona->solo_primeros_nombres;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            $usuario->created_by = auth()->id();
        });

        static::updating(function ($usuario) {
            $usuario->updated_by = auth()->id();
        });

        static::deleting(function ($usuario) {
            $usuario->deleted_by = auth()->id();
            $usuario->save();
        });
    }
}
