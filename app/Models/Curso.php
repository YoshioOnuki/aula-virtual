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

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    public function planEstudio()
    {
        return $this->belongsTo(PlanEstudio::class, 'id_plan_estudio');
    }

    public function gestionAula()
    {
        return $this->hasMany(GestionAula::class, 'id_curso');
    }

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
