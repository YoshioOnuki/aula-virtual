<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclo';
    protected $primaryKey = 'id_ciclo';
    protected $fillable = [
        'id_ciclo',
        'numero_ciclo',
        'nombre_ciclo',
        'estado_ciclo',
    ];

    protected $casts = [
        'estado_ciclo' => 'boolean',
    ];

    public function curso()
    {
        return $this->hasMany(Curso::class, 'id_ciclo');
    }

    public $timestamps = false;

}
