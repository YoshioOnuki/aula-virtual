<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAulaDocente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula_docente';
    protected $primaryKey = 'id_gestion_aula_docente';
    protected $fillable = [
        'id_gestion_aula_docente',
        'estado_gestion_aula_docente',
        'es_invitado',
        'id_usuario',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_gestion_aula_docente',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_gestion_aula_docente' => 'boolean',
        'es_invitado' => 'boolean',
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
     * Retorna comentarioTrabajoAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarioTrabajoAcademico()
    {
        return $this->hasMany(ComentarioTrabajoAcademico::class, 'id_gestion_aula_docente');
    }

    /**
     * Retorna foro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foro()
    {
        return $this->hasMany(Foro::class, 'id_gestion_aula_docente');
    }

    // Usar el search del scope de usuario para buscar docentes
    public function scopeSearchDocente($query, $search)
    {
        if ($search) {
            return $query->whereHas('usuario', function ($query) use ($search) {
                $query->searchDocente($search);
            });
        }
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
     * Retorna nombre_estado_gestion_aula_docente
     *
     * @return string
     */
    public function getNombreEstadoGestionAulaDocenteAttribute() : string
    {
        return $this->estado_gestion_aula_docente ? 'Activo' : 'Inactivo';
    }


    /**
     * Scope a query to search gestion aula.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $gestion_aula
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGestionAula($query, $gestion_aula)
    {
        if ($gestion_aula) {
            return $query->where('id_gestion_aula', $gestion_aula);
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
     * Scope a query to search estado.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_gestion_aula_docente', $estado);
        }
    }

    /**
     * Scope a query to search invitado.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $invitado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInvitado($query, $invitado)
    {
        return $query->where('es_invitado', $invitado);
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_aula_docente) {
            $gestion_aula_docente->created_by = Auth::id();
        });
        static::updating(function ($gestion_aula_docente) {
            $gestion_aula_docente->updated_by = Auth::id();
        });
        static::deleting(function ($gestion_aula_docente) {
            $gestion_aula_docente->deleted_by = Auth::id();
            $gestion_aula_docente->save();
        });
    }
}
