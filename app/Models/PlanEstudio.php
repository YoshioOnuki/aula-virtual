<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'plan_estudio';
    protected $primaryKey = 'id_plan_estudio';
    protected $fillable = [
        'id_plan_estudio',
        'nombre_plan_estudio',
        'anio_plan_estudio',
        'estado_plan_estudio',
    ];

    protected $casts = [
        'estado_plan_estudio' => 'boolean',
    ];

    public function curso()
    {
        return $this->hasMany(Curso::class, 'id_plan_estudio');
    }

    public $timestamps = false;

}
