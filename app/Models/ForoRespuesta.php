<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ForoRespuesta extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'foro_respuesta';
    protected $primaryKey = 'id_foro_respuesta';
    protected $fillable = [
        'id_foro_respuesta',
        'descripcion_foro_respuesta',
        'id_foro',
        'id_gestion_aula_alumno',
        'id_respuesta_padre',
    ];


    /**
     * Retorna foro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foro()
    {
        return $this->belongsTo(Foro::class, 'id_foro');
    }

    /**
     * Retorna gestionAulaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gestionAulaAlumno()
    {
        return $this->belongsTo(GestionAulaAlumno::class, 'id_gestion_aula_alumno');
    }

    /**
     * Retorna padre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function padre()
    {
        return $this->belongsTo(ForoRespuesta::class, 'id_respuesta_padre');
    }

    /**
     * Retorna hijos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hijos()
    {
        return $this->hasMany(ForoRespuesta::class, 'id_respuesta_padre');
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
     * Contar total de respuestas
     *
     * @return int
     */
    public function contar_total_respuestas() : int
    {
        // Inicializamos el contador con la cantidad de respuestas hijas directas
        $count = $this->hijos->count();

        // Iteramos sobre cada hijo y contamos también sus respuestas anidadas
        foreach ($this->hijos as $item) {
            $count += $item->contar_total_respuestas();
        }

        return $count;
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

        static::creating(function ($foro_respuesta) {
            $foro_respuesta->created_by = Auth::id();
        });
        static::updating(function ($foro_respuesta) {
            $foro_respuesta->updated_by = Auth::id();
        });
        static::deleting(function ($foro_respuesta) {
            $foro_respuesta->deleted_by = Auth::id();
            $foro_respuesta->save();
        });
    }
}
