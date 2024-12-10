<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Usuario extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

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


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_usuario',
    ];

    /**
     * Los atributos que deben ser ocultos.
     *
     * @var array
     */
    protected $hidden = [
        'contrasenia_usuario',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_usuario' => 'boolean',
    ];


    /**
     * Retorna persona
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    /**
     * Retorna usuarioRol
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarioRol()
    {
        return $this->hasMany(UsuarioRol::class, 'id_usuario');
    }

    /**
     * Retorna roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'id_usuario', 'id_rol');
    }

    /**
     * Retorna gestionAulaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionAulaAlumno()
    {
        return $this->hasMany(GestionAulaAlumno::class, 'id_usuario');
    }

    /**
     * Retorna gestionAulaDocente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionAulaDocente()
    {
        return $this->hasMany(GestionAulaDocente::class, 'id_usuario');
    }

    /**
     * Retorna auditoria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auditoria()
    {
        return $this->hasMany(Auditoria::class, 'id_usuario');
    }


    /**
     * Retorna usuarioRegistra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioRegistra()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }

    /**
     * Retorna usuarioActualiza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioActualiza()
    {
        return $this->belongsTo(Usuario::class, 'updated_by');
    }

    /**
     * Retorna usuarioElimina
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioElimina()
    {
        return $this->belongsTo(Usuario::class, 'deleted_by');
    }


    /**
     * Retorna nombre_estado_usuario
     *
     * @return string
     */
    public function getNombreEstadoUsuarioAttribute() : string
    {
        return $this->estado_usuario ? 'Activo' : 'Inactivo';
    }

    /**
     * Retorna nombre_completo
     *
     * @return string
     */
    public function getNombreCompletoAttribute() : string
    {
        return $this->persona?->nombre_completo ?? 'No definido';
    }

    /**
     * Retorna solo_primeros_nombres
     *
     * @return string
     */
    public function getSoloPrimerosNombresAttribute() : string
    {
        return $this->persona?->solo_primeros_nombres ?? 'No definido';
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

    // Validar que rol es docente invitado, mandando como parametro el id de la gestion aula
    public function esDocenteInvitado($id_gestion_aula)
    {
        $gestionAulaDocente = GestionAulaDocente::where('id_usuario', $this->id_usuario)
            ->gestionAula($id_gestion_aula)
            ->invitado(true)
            ->first();

        if ($gestionAulaDocente) {
            return true;
        }

        return false;
    }

    // Validar que rol es alumno, mandando como parametro el id de la gestion aula
    public function esAlumno($id_gestion_aula)
    {
        $gestionAulaAlumno = GestionAulaAlumno::where('id_usuario', $this->id_usuario)
            ->gestionAula($id_gestion_aula)
            ->estado(true)
            ->first();

        if ($gestionAulaAlumno) {
            return true;
        }

        return false;
    }

    // Validar que rol es docente, mandando como parametro el id de la gestion aula
    public function esDocente($id_gestion_aula)
    {
        $gestionAulaDocente = GestionAulaDocente::where('id_usuario', $this->id_usuario)
            ->gestionAula($id_gestion_aula)
            ->invitado(false)
            ->estado(true)
            ->first();

        if ($gestionAulaDocente) {
            return true;
        }

        return false;
    }

    // Mostrar la foto del usuario, si no tiene foto, mostrar una por defecto
    public function MostrarFoto($tipo)
    {
        $color = '000000';
        $color_lt = 'ffffff';

        if ($tipo === 'usuario') {
            $color = config('settings.color_usuario');
            $color_lt = config('settings.color_lt_usuario');
        }

        if ($tipo === 'docente') {
            $color = config('settings.color_docente');
            $color_lt = config('settings.color_lt_docente');
        }

        if ($tipo === 'alumno') {
            $color = config('settings.color_alumnos');
            $color_lt = config('settings.color_lt_alumnos');
        }

        if ($tipo === 'azure') {
            $color = '4299e1';
            $color_lt = 'ecf5fc';
        }

        if ($tipo === 'indigo') {
            $color = '4263eb';
            $color_lt = 'eceffd';
        }

        $nombres = $this->persona ? $this->persona->solo_primeros_nombres : 'Sin Nombres';

        return $this->foto_usuario || $this->foto_usuario != '' ? $this->foto_usuario :
            'https://ui-avatars.com/api/?name=' . $nombres . '&size=64&&color=' . $color_lt . '&background=' . $color . '&bold=true';
    }

    //Mostrar el rol, si tiene mas de un rol, concatenar
    public function mostrarRoles()
    {
        $roles = '';
        foreach ($this->roles as $rol) {
            $roles .= $rol->nombre_rol . ', ';
        }
        return substr($roles, 0, -2);
    }


    /**
     * Scope a query to search
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('correo_usuario', 'LIKE', '%' . $search . '%')
                ->orWhereHas('persona', function ($subQuery) use ($search) {
                    $subQuery->where('nombres_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_paterno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_materno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('documento_persona', 'LIKE', '%' . $search . '%');
                });
        });
    }

    /**
     * Scope a query to search alumno
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchAlumno($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
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

    /**
     * Scope a query to search docente
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchDocente($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('correo_usuario', 'LIKE', '%' . $search . '%')
                ->orWhereHas('persona', function ($subQuery) use ($search) {
                    $subQuery->where('nombres_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_paterno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellido_materno_persona', 'LIKE', '%' . $search . '%')
                        ->orWhere('documento_persona', 'LIKE', '%' . $search . '%');
                });
        });
    }

    /**
     * Scope a query to search estado de usuario.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_usuario', $estado);
        }
    }

    /**
     * Scope a query to search docente activo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivo($query)
    {
        return $query->where('estado_usuario', true);
    }

    /**
     * Scope a query to search docente inactivo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactivo($query)
    {
        return $query->where('estado_usuario', false);
    }

    /**
     * Scope a query to search by correo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $correo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCorreo($query, $correo)
    {
        return $query->where('correo_usuario', $correo);
    }

    /**
     * Scope a query to search by rol.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $rol
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRol($query, $rol)
    {
        return $query->whereHas('roles', function ($subQuery) use ($rol) {
            $subQuery->where('nombre_rol', $rol);
        });
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Call the Auditable logic
        static::bootAuditable();

        static::creating(function ($usuario) {
            $usuario->created_by = Auth::id();
        });

        static::updating(function ($usuario) {
            $usuario->updated_by = Auth::id();
        });

        static::deleting(function ($usuario) {
            $usuario->deleted_by = Auth::id();
            $usuario->save();
        });
    }
}
