<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';
    protected $primaryKey = 'id_cargo';
    protected $fillable = [
        'id_cargo',
        'nombre_cargo',
        'estado_cargo',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_cargo',
    ];

    /**
    * Los atributos que deben ser convertidos.
     *
     * @return array
     */
    protected $casts = [
        'estado_cargo' => 'boolean',
    ];


    /**
     * Retorna autoridad
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autoridad()
    {
        return $this->hasMany(Autoridad::class, 'id_cargo');
    }


    /**
     * Retorna nombre_estado_cargo
     *
     * @return string
     */
    public function getNombreEstadoCargoAttribute() : string
    {
        return $this->estado_cargo ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;
}
