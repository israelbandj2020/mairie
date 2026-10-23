<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliberation extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_travail_id',
        'titre',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'ajoute_par',
    ];

    protected $casts = [
        'taille' => 'integer',
    ];

    public function sessionTravail()
    {
        return $this->belongsTo(SessionTravail::class, 'session_travail_id');
    }

    public function ajoutePar()
    {
        return $this->belongsTo(User::class, 'ajoute_par');
    }

    public function scopeSearch($query, $q)
    {
        if ($q) {
            return $query->where('titre', 'like', "%{$q}%")
                ->orWhereHas('sessionTravail', function ($subQuery) use ($q) {
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
