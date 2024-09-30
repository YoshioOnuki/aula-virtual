<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;

    protected $table = 'facultad';
    protected $primaryKey = 'id_facultad';
    protected $fillable = [
        'id_facultad',
        'nombre_facultad',
        'estado_facultad',
    ];

    protected $casts = [
        'estado_facultad' => 'boolean',
    ];

    public function programa()
    {
        return $this->hasMany(Programa::class, 'id_facultad');
    }

    public function autoridad()
    {
        return $this->hasMany(Autoridad::class, 'id_facultad');
    }

    public $timestamps = false;

}
