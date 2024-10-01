<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAulaDocente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gestion_aula_docente';
    protected $primaryKey = 'id_gestion_aula_docente';
    protected $fillable = [
        'id_gestion_aula_docente',
        'estado_gestion_aula_docente',
        'es_invitado',
        'id_usuario',
        'id_gestion_aula',
    ];

    protected $casts = [
        'es_invitado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }


    public function comentarioTrabajoAcademico()
    {
        return $this->hasMany(ComentarioTrabajoAcademico::class, 'id_gestion_aula_docente');
    }

    public function foro()
    {
        return $this->hasMany(Foro::class, 'id_gestion_aula_docente');
    }

    // Usar el search del scope de usuario para buscar docentes
    public function scopeSearchDocente($query, $search)
    {
        if ($search) {
            return $query->whereHas('usuario', function ($query) use ($search) {
                $query->searchDocente($search);
            });
        }
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_gestion_aula_docente', $estado);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gestion_aula_docente) {
            $gestion_aula_docente->created_by = Auth::id();
        });
        static::updating(function ($gestion_aula_docente) {
            $gestion_aula_docente->updated_by = Auth::id();
        });
        static::deleting(function ($gestion_aula_docente) {
            $gestion_aula_docente->deleted_by = Auth::id();
            $gestion_aula_docente->save();
        });
    }
}
