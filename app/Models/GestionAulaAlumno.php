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

    /**
    * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_completo_alumno',
        'documento_alumno',
        'codigo_alumno',
        'correo_usuario',
        'nombre_en_curso_gestion_aula',
        'ultima_conexion',
    ];

    /**
    * Los atributos que deben ser ocultados.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_gestion_aula_alumno' => 'boolean',
    ];


    /**
     * Retorna usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Retorna gestionAula
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    /**
     * Retorna trabajoAcademicoAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_gestion_aula_alumno');
    }

    /**
     * Retorna foroRespuesta
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foroRespuesta()
    {
        return $this->hasMany(ForoRespuesta::class, 'id_gestion_aula_alumno');
    }

    /**
     * Retorna asistenciaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_gestion_aula_alumno');
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
     * Get the nombre_completo_alumno attribute.
     *
     * @return string
     */
    public function getNombreCompletoAlumnoAttribute() : string
    {
        return $this->usuario->nombre_completo;
    }

    /**
     * Get the documento_alumno attribute.
     *
     * @return string
     */
    public function getDocumentoAlumnoAttribute() : string
    {
        return $this->usuario->documento_persona;
    }

    /**
     * Get the codigo_alumno attribute.
     *
     * @return string
     */
    public function getCodigoAlumnoAttribute() : string
    {
        return $this->usuario->codigo_alumno;
    }

    /**
     * Get the correo_usuario attribute.
     *
     * @return string
     */
    public function getCorreoUsuarioAttribute() : string
    {
        return $this->usuario->correo_usuario;
    }

    /**
     * Get the nombre_en_curso_gestion_aula attribute.
     *
     * @return string
     */
    public function getNombreEnCursoGestionAulaAttribute() : string
    {
        return $this->gestionAula->nombre_en_curso_gestion_aula;
    }

    /**
     * Get the ultima_conexion attribute.
     *
     * @return string
     */
    public function getUltimaConexionAttribute() : string
    {
        return $this->usuario->ultima_conexion;
    }


    /**
     * Scope a query to search alumno.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchAlumno($query, $search)
    {
        if ($search) {
            return $query->whereHas('usuario', function ($query) use ($search) {
                $query->searchAlumno($search);
            });
        }
    }

    /**
     * Scope a query to search alumno.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_gestion_aula_alumno', $estado);
        }
    }


    /**
     * Scope a query to search alumno.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id_gestion_aula
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGestionAula($query, $id_gestion_aula)
    {
        if ($id_gestion_aula) {
            return $query->where('id_gestion_aula', $id_gestion_aula);
        }
    }

        /**
     * Scope a query to search usuario.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $usuario
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsuario($query, $usuario)
    {
        if ($usuario) {
            return $query->where('id_usuario', $usuario);
        }
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
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
