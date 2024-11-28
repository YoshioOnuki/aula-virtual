<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAula extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'gestion_aula';
    protected $primaryKey = 'id_gestion_aula';
    protected $fillable = [
        'id_gestion_aula',
        'grupo_gestion_aula',
        'fondo_gestion_aula',
        'estado_gestion_aula',
        'en_curso_gestion_aula',
        'id_curso',
        'id_proceso',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_gestion_aula',
        'nombre_en_curso_gestion_aula',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_gestion_aula' => 'boolean',
        'en_curso_gestion_aula' => 'boolean',
    ];


    /**
     * Retorna curso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    /**
     * Retorna proceso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'id_proceso');
    }

    /**
     * Retorna asistencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class, 'id_gestion_aula');
    }

    /**
     * Retorna gestionAulaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionAulaAlumno()
    {
        return $this->hasMany(GestionAulaAlumno::class, 'id_gestion_aula');
    }

    /**
     * Retorna gestionAulaDocente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionAulaDocente()
    {
        return $this->hasMany(GestionAulaDocente::class, 'id_gestion_aula');
    }

    /**
     * Retorna recurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recurso()
    {
        return $this->hasMany(Recurso::class, 'id_gestion_aula');
    }

    /**
     * Retorna foro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foro()
    {
        return $this->hasMany(Foro::class, 'id_gestion_aula');
    }

    /**
     * Retorna linkClase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function linkClase()
    {
        return $this->hasOne(LinkClase::class, 'id_gestion_aula');
    }

    /**
     * Retorna presentacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function presentacion()
    {
        return $this->hasOne(Presentacion::class, 'id_gestion_aula');
    }

    /**
     * Retorna silabus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function silabus()
    {
        return $this->hasOne(Silabus::class, 'id_gestion_aula');
    }

    /**
     * Retorna webgrafia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function webgrafia()
    {
        return $this->hasMany(Webgrafia::class, 'id_gestion_aula');
    }

    /**
     * Retorna trabajoAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoAcademico()
    {
        return $this->hasMany(TrabajoAcademico::class, 'id_gestion_aula');
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
     * Get the nombre_estado_gestion_aula attribute.
     *
     * @return string
     */
    public function getNombreEstadoGestionAulaAttribute(): string
    {
        return $this->estado_gestion_aula ? 'Activo' : 'Inactivo';
    }

    /**
     * Get the nombre_en_curso_gestion_aula attribute.
     *
     * @return string
     */
    public function getNombreEnCursoGestionAulaAttribute(): string
    {
        return $this->en_curso_gestion_aula ? 'EN CURSO' : 'FINALIZADO';
    }


    /**
     * Scope a query to search.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('grupo_gestion_aula', 'like', '%' . $search . '%')
                        ->orWhereHas('curso', function ($query) use ($search) {
                            $query->where('nombre_curso', 'like', '%' . $search . '%')
                                ->orWhere('codigo_curso', 'like', '%' . $search . '%');
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
        return $query->where('estado_gestion_aula', $estado);
    }

    /**
     * Scope a query to search en curso.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $en_curso
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnCurso($query, $en_curso)
    {
        return $query->where('en_curso_gestion_aula', $en_curso);
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

        static::creating(function ($gestion_aula) {
            $gestion_aula->created_by = Auth::id();
        });

        static::updating(function ($gestion_aula) {
            $gestion_aula->updated_by = Auth::id();
        });

        static::deleting(function ($gestion_aula) {
            $gestion_aula->deleted_by = Auth::id();
            $gestion_aula->save();
        });
    }
}
