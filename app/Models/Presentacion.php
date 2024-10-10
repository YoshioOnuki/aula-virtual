<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Presentacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'presentacion';
    protected $primaryKey = 'id_presentacion';
    protected $fillable = [
        'id_presentacion',
        'descripcion_presentacion',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_curso',
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
     * Retorna gestionAula
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function gestionAula()
    {
        return $this->hasOne(GestionAula::class, 'id_gestion_aula');
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
     * Retorna nombre_curso
     *
     * @return string
     */
    public function getNombreCursoAttribute() : string
    {
        return $this->gestionAula->nombre_curso;
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($presentacion) {
            $presentacion->created_by = Auth::id();
        });
        static::updating(function ($presentacion) {
            $presentacion->updated_by = Auth::id();
        });
        static::deleting(function ($presentacion) {
            $presentacion->deleted_by = Auth::id();
            $presentacion->save();
        });
    }
}
