<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LinkClase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'link_clase';
    protected $primaryKey = 'id_link_clase';
    protected $fillable = [
        'id_link_clase',
        'nombre_link_clase',
        'estado_link_clase',
        'id_gestion_aula',
    ];

    protected $casts = [
        'estado_link_clase' => 'boolean',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link_clase) {
            $link_clase->created_by = Auth::id();
        });
        static::updating(function ($link_clase) {
            $link_clase->updated_by = Auth::id();
        });
        static::deleting(function ($link_clase) {
            $link_clase->deleted_by = Auth::id();
            $link_clase->save();
        });
    }
}
