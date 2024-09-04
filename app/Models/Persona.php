<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        return $this->hasOne(Usuario::class, 'id_persona');
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

    public function scopeSearch($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where('nombres_persona', 'LIKE', "%$search%")
            ->orWhere('apellido_paterno_persona', 'LIKE', "%$search%")
            ->orWhere('apellido_materno_persona', 'LIKE', "%$search%")
            ->orWhere('codigo_alumno_persona', 'LIKE', "%$search%")
            ->orWhere('correo_persona', 'LIKE', "%$search%");
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($persona) {
            $persona->created_by = Auth::id();
        });

        static::updating(function ($persona) {
            $persona->updated_by = Auth::id();
        });

        static::deleting(function ($persona) {
            $persona->deleted_by = Auth::id();
            $persona->save();
        });
    }
}
