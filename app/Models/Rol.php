<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    protected $fillable = [
        'id_rol',
        'nombre_rol',
        'estado_rol',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_rol',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_rol' => 'boolean',
    ];


    /**
     * Retorna usuarios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usuarios() {
        return $this->belongsToMany(Usuario::class, 'usuario_rol', 'id_rol', 'id_usuario');
    }

    /**
     * Retorna usuarioRol
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarioRol()
    {
        return $this->hasMany(UsuarioRol::class, 'id_rol');
    }


    /**
     * Retorna nombre_estado_rol
     *
     * @return string
     */
    public function getNombreEstadoRolAttribute() : string
    {
        return $this->estado_rol ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;

}
