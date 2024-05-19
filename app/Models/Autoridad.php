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

    public function getMostrarFotoAttribute()
    {
        return $this->foto_autoridad ?? 'https://ui-avatars.com/api/?name=' . $this->solo_primeros_nombres . '&size=64&&color=e8f6f8&background=17a2b8&bold=true';
    }

    public $timestamps = false;

}
