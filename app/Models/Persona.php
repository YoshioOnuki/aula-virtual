<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'persona';
    protected $primaryKey = 'id_persona';
    protected $fillable = [
        'id_persona',
        'documento_persona',
        'nombres_persona',
        'apellido_paterno_persona',
        'apellido_materno_persona',
        'codigo_alumno_persona',
        'correo_persona',
    ];

    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'id_persona');
    }

    public function getSoloPrimerosNombresAttribute()
    {
        $nombres = explode(' ', $this->nombres_persona);
        return $nombres[0] . ' ' . $this->apellido_paterno_persona;
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombres_persona . ' ' . $this->apellido_paterno_persona . ' ' . $this->apellido_materno_persona;
    }

    public function getFotoAttribute()
    {
        return $this->usuario->first()->foto_usuario ?? '';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($persona) {
            $persona->created_by = auth()->id();
        });

        static::updating(function ($persona) {
            $persona->updated_by = auth()->id();
        });

        static::deleting(function ($persona) {
            $persona->deleted_by = auth()->id();
            $persona->save();
        });
    }
}
