<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LinkClase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'link_clase';
    protected $primaryKey = 'id_link_clase';
    protected $fillable = [
        'id_link_clase',
        'nombre_link_clase',
        'estado_link_clase',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_link_clase',
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
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_link_clase' => 'boolean',
    ];


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
     * Retorna nombre_estado_link_clase
     *
     * @return string
     */
    public function getNombreEstadoLinkClaseAttribute() : string
    {
        return $this->estado_link_clase ? 'Activo' : 'Inactivo';
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

        static::creating(function ($link_clase) {
            $link_clase->created_by = Auth::id();
        });
        static::updating(function ($link_clase) {
            $link_clase->updated_by = Auth::id();
        });
        static::deleting(function ($link_clase) {
            $link_clase->deleted_by = Auth::id();
            $link_clase->save();
        });
    }
}
