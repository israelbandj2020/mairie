<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_travail_id',
        'type',
        'titre',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'cree_par',
    ];

    protected $casts = [
        'taille' => 'integer',
    ];

    public function sessionTravail()
    {
        return $this->belongsTo(SessionTravail::class, 'session_travail_id');
    }

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'ordre_du_jour' => 'Ordre du jour',
            'ordre_du_jour_valide' => 'OJ validé',
            'compte_rendu' => 'Compte rendu',
            'decision' => 'Décision',
            'document' => 'Document',
            default => $this->type,
        };
    }
}
