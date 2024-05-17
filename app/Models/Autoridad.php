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

    public $timestamps = false;

}
