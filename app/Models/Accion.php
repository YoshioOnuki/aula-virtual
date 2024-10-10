<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use HasFactory;

    protected $table = 'accion';
    protected $primaryKey = 'id_accion';
    protected $fillable = [
        'id_accion',
        'nombre_accion',
    ];

    public $timestamps = false;
}
