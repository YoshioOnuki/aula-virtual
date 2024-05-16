<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionCurso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_curso';
    protected $primaryKey = 'id_gestion_curso';
    protected $fillable = [
        'id_gestion_curso',
        'grupo_gestion_curso',
        'estado_gestion_curso',
        'id_curso',
        'id_proceso',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'id_proceso');
    }

    public function gestionAula()
    {
        return $this->hasMany(GestionAula::class, 'id_gestion_curso');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_curso) {
            $gestion_curso->created_by = auth()->id();
        });
        static::updating(function ($gestion_curso) {
            $gestion_curso->updated_by = auth()->id();
        });
        static::deleting(function ($gestion_curso) {
            $gestion_curso->deleted_by = auth()->id();
            $gestion_curso->save();
        });
    }
}
