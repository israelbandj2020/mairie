<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliberation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_enregistrement',
        'session_travail_id',
        'titre',
        'description',
        'date',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'cree_par',
    ];

    protected $casts = [
        'taille' => 'integer',
        'date' => 'date',
    ];

    public function session()
    {
        return $this->belongsTo(SessionTravail::class, 'session_travail_id');
    }

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function scopeSearch($query, $q)
    {
        if ($q) {
            return $query->where('titre', 'like', "%{$q}%")
                ->orWhereHas('session', function ($subQuery) use ($q) {
                    $subQuery->where('nom', 'like', "%{$q}%")
                        ->orWhere('numero', 'like', "%{$q}%");
                });
        }
        return $query;
    }

    public function scopeBySession($query, $sessionId)
    {
        if ($sessionId) {
            return $query->where('session_travail_id', $sessionId);
        }
        return $query;
    }
}
