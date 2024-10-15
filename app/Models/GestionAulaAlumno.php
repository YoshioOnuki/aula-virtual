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
        'nombre_estado_gestion_aula_alumno',
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
     * Retorna nombre_estado_gestion_aula_alumno
     *
     * @return string
     */
    public function getNombreEstadoGestionAulaAlumnoAttribute() : string
    {
        return $this->estado_gestion_aula_alumno ? 'Activo' : 'Inactivo';
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
     * Scope a query to search estado.
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
