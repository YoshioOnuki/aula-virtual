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
        'ultima_accion_usuario',
        'id_accion_usuario',
        'accion_usuario',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function usuarioRol()
    {
        return $this->hasMany(UsuarioRol::class, 'id_usuario');
    }

    public function roles() {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'id_usuario', 'id_rol');
    }

    public function accionUsuario()
    {
        return $this->belongsTo(AccionUsuario::class, 'id_accion_usuario');
    }

    public function gestionAulaUsuario(){
        return $this->hasMany(GestionAulaUsuario::class, 'id_usuario');
    }

    // Validar que rol es, mandando como parametro el nombre del rol
    public function esRol($nombreRol)
    {
        foreach ($this->roles as $rol) {
            if ($rol->nombre_rol == $nombreRol) {
                return true;
            }
        }
        return false;
    }

    // Validar que rol pertenece a la gestion de aula
    public function esRolGestionAula($nombreRol, $idGestionAulaUsuario)
    {
        $idGestionAula = GestionAulaUsuario::find($idGestionAulaUsuario)->id_gestion_aula;
        $gestionAulaUsuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->select('id_gestion_aula');
            },
            'rol' => function ($query) {
                $query->select('id_rol', 'nombre_rol');
            }
        ])->whereHas('rol', function ($query) use ($nombreRol) {
            $query->where('nombre_rol', $nombreRol);
        })->where('id_usuario', $this->id_usuario)
        ->where('id_gestion_aula', $idGestionAula)->first();

        if ($gestionAulaUsuario) {
            return true;
        }

        return false;
    }

    public function getRolUsuaAttribute()
    {
        return $this->roles->first()->nombre_rol;
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
            $color = config('settings.color_docente');
            $color_lt = config('settings.color_lt_docente');
        }

        if($tipo === 'alumno')
        {
            $color = config('settings.color_alumnos');
            $color_lt = config('settings.color_lt_alumnos');
        }

        if($tipo === 'azure')
        {
            $color = '4299e1';
            $color_lt = 'ecf5fc';
        }

        if($tipo === 'indigo')
        {
            $color = '4263eb';
            $color_lt = 'eceffd';
        }

        $nombres = $this->persona ? $this->persona->solo_primeros_nombres : 'Sin Nombres';

        return $this->foto_usuario ?? 'https://ui-avatars.com/api/?name=' . $nombres . '&size=64&&color='. $color_lt .'&background='. $color .'&bold=true';
    }

    //Mostrar el rol, si tiene mas de un rol, concatenar
    public function mostrarRol()
    {
        $roles = '';
        foreach ($this->roles as $rol) {
            $roles .= $rol->nombre_rol . ', ';
        }
        return substr($roles, 0, -2);
    }

    public function mostrarRolCollection()
    {

    }

    public function getNombreCompletoAttribute()
    {
        return $this->persona?->nombre_completo;
    }

    public function getSoloPrimerosNombresAttribute()
    {
        return $this->persona->solo_primeros_nombres;
    }

    public function scopeSearch($query, $search) {
        if ($search == null) {
            return $query;
        }

        return $query->where(function($query) use ($search) {
            $query->where('correo_usuario', 'LIKE', '%' . $search . '%')
                ->orWhereHas('persona', function ($subQuery) use ($search) {
                    $subQuery->where('nombres_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_paterno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_materno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('documento_persona', 'LIKE', '%' . $search . '%');
                });
        });
    }

    public function scopeSearchAlumno($query, $search) {
        if ($search == null) {
            return $query;
        }

        return $query->where(function($query) use ($search) {
            $query->where('correo_usuario', 'LIKE', '%' . $search . '%')
                ->orWhereHas('persona', function ($subQuery) use ($search) {
                    $subQuery->where('nombres_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_paterno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_materno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('documento_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('codigo_alumno_persona', 'LIKE', '%' . $search . '%');
                });
        });
    }

    public function scopeActivo($query) {
        return $query->where('estado_usuario', 1);
    }

    public function scopeInactivo($query) {
        return $query->where('estado_usuario', 0);
    }

    public function scopeCorreo($query, $correo) {
        return $query->where('correo_usuario', $correo);
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
