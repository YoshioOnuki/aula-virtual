<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Webgrafia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'webgrafia';
    protected $primaryKey = 'id_webgrafia';
    protected $fillable = [
        'id_webgrafia',
        'descripcion_webgrafia',
        'link_webgrafia',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function scopeSearch($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where('descripcion_webgrafia', 'LIKE', "%$search%")
            ->orWhere('link_webgrafia', 'LIKE', "%$search%");
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($webgrafia) {
            $webgrafia->created_by = Auth::id();
        });
        static::updating(function ($webgrafia) {
            $webgrafia->updated_by = Auth::id();
        });
        static::deleting(function ($webgrafia) {
            $webgrafia->deleted_by = Auth::id();
            $webgrafia->save();
        });
    }
}
