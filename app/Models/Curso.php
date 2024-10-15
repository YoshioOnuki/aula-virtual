<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Curso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'curso';
    protected $primaryKey = 'id_curso';
    protected $fillable = [
        'id_curso',
        'codigo_curso',
        'nombre_curso',
        'creditos_curso',
        'horas_lectivas_curso',
        'estado_curso',
        'id_ciclo',
        'id_programa',
        'id_plan_estudio'
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_curso',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_curso' => 'boolean',
    ];


    /**
     * Retorna ciclo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo');
    }

    /**
     * Retorna programa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    /**
     * Retorna planEstudio
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planEstudio()
    {
        return $this->belongsTo(PlanEstudio::class, 'id_plan_estudio');
    }

    /**
     * Retorna gestionAula
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function gestionAula()
    {
        return $this->hasMany(GestionAula::class, 'id_curso');
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
     * Get the nombre_estado_curso attribute.
     *
     * @return string
     */
    public function getNombreEstadoCursoAttribute(): string
    {
        return $this->estado_curso ? 'Activo' : 'Inactivo';
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($curso) {
            $curso->created_by = Auth::id();
        });
        static::updating(function ($curso) {
            $curso->updated_by = Auth::id();
        });
        static::deleting(function ($curso) {
            $curso->deleted_by = Auth::id();
            $curso->save();
        });
    }
}
