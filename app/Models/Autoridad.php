<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoridad extends Model
{
    use HasFactory;

    protected $table = 'autoridad';
    protected $primaryKey = 'id_autoridad';
    protected $fillable = [
        'id_autoridad',
        'nombre_autoridad',
        'foto_autoridad',
        'estado_autoridad',
        'id_cargo',
        'id_facultad',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }

    public function getSoloPrimerosNombresAttribute()
    {
        //Primero separo los nombres de los grados (Dr., Ing., Mg., etc)
        $nombres = explode('.', $this->nombre_autoridad);
        //Luego separo los nombres
        $nombres = explode(' ', $nombres[1]);
        //Retorno solo los primeros nombres
        return $nombres[0] . ' ' . $nombres[1];
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre_autoridad', 'LIKE', '%' . $search . '%')
            ->orWhereHas('facultad', function ($query) use ($search) {
                $query->where('nombre_facultad', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('cargo', function ($query) use ($search) {
                $query->where('nombre_cargo', 'LIKE', '%' . $search . '%');
            });
    }

    public function scopeActivo($query)
    {
        return $query->where('estado_autoridad', 1);
    }

    public function scopeInactivo($query)
    {
        return $query->where('estado_autoridad', 0);
    }

    public function getMostrarFotoAttribute()
    {
        return $this->foto_autoridad ?? 'https://ui-avatars.com/api/?name=' . $this->solo_primeros_nombres . '&size=64&&color='. config('settings.color_lt_autoridades') .'&background='. config('settings.color_autoridades') .'&bold=true';
    }

    public $timestamps = false;

}
