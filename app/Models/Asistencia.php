<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Asistencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asistencia';
    protected $primaryKey = 'id_asistencia';
    protected $fillable = [
        'id_asistencia',
        'fecha_asistencia',
        'hora_inicio_asistencia',
        'hora_fin_asistencia',
        'id_tipo_asistencia',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_tipo_asistencia',
    ];

    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_asistencia' => 'date',
        'hora_inicio_asistencia' => 'time',
        'hora_fin_asistencia' => 'time',
    ];


    /**
     * Retorna trabajoAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoAsistencia()
    {
        return $this->belongsTo(TipoAsistencia::class, 'id_tipo_asistencia');
    }

    /**
     * Retorna asistenciaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asistenciaAlumno()
    {
        return $this->hasMany(AsistenciaAlumno::class, 'id_asistencia');
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
     * Get the nombre_tipo_asistencia attribute.
     *
     * @return string
     */
    public function getNombreTipoAsistenciaAttribute(): string
    {
        return $this->tipoAsistencia->nombre_tipo_asistencia;
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
            $query->where('nombre_asistencia', 'like', '%' . $search . '%')
                ->orWhere('fecha_asistencia', 'like', '%' . $search . '%')
                ->orWhere('hora_inicio_asistencia', 'like', '%' . $search . '%')
                ->orWhere('hora_fin_asistencia', 'like', '%' . $search . '%')
                ->orWhereHas('asistenciaAlumno', function ($query) use ($search) {
                    $query->whereHas('estadoAsistencia', function ($query) use ($search) {
                        $query->where('nombre_estado_asistencia', 'like', '%' . $search . '%');
                    });
                });
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

        static::creating(function ($asistencia) {
            $asistencia->created_by = Auth::id();
        });
        static::updating(function ($asistencia) {
            $asistencia->updated_by = Auth::id();
        });
        static::deleting(function ($asistencia) {
            $asistencia->deleted_by = Auth::id();
            $asistencia->save();
        });
    }
}
