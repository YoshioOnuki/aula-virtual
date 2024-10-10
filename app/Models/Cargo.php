<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';
    protected $primaryKey = 'id_cargo';
    protected $fillable = [
        'id_cargo',
        'nombre_cargo',
        'estado_cargo',
    ];

    protected $casts = [
        'estado_cargo' => 'boolean',
    ];

    public function autoridad()
    {
        return $this->hasMany(Autoridad::class, 'id_cargo');
    }

    public $timestamps = false;
}
