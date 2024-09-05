<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Proceso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'proceso';
    protected $primaryKey = 'id_proceso';
    protected $fillable = [
        'id_proceso',
        'nombre_proceso',
        'estado_proceso',
    ];

    public function gestionAula()
    {
        return $this->hasMany(GestionAula::class, 'id_proceso');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($proceso) {
            $proceso->created_by = Auth::id();
        });
        static::updating(function ($proceso) {
            $proceso->updated_by = Auth::id();
        });
        static::deleting(function ($proceso) {
            $proceso->deleted_by = Auth::id();
            $proceso->save();
        });
    }
}
