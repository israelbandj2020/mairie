<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Besoin extends Model
{
    use HasFactory;

    protected $table = 'besoins_prioritaires';

    protected $fillable = [
        'canton_id',
        'titre',
        'description',
        'nom',
        'prenom',
        'telephone',
        'photo',
        'statut_validation',
        'priorite',
        'statut',
        'cree_par',
    ];

    public function canton()
    {
        return $this->belongsTo(Canton::class, 'canton_id');
    }

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function getPrioriteLabelAttribute(): string
    {
        return match ($this->priorite) {
            'haute' => 'Haute',
            'moyenne' => 'Moyenne',
            'basse' => 'Basse',
            default => $this->priorite,
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_cours' => 'En cours',
            'traite' => 'Traité',
            'rejete' => 'Rejeté',
            default => $this->statut,
        };
    }

    public function getStatutValidationLabelAttribute(): string
    {
        return match ($this->statut_validation) {
            'en_attente' => 'En attente',
            'valide' => 'Validé',
            'rejete' => 'Rejeté',
            default => $this->statut_validation,
        };
    }

    public function scopeValides($query)
    {
        return $query->where('statut_validation', 'valide');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut_validation', 'en_attente');
    }

    public function scopeByPriorite($query)
    {
        return $query->orderByRaw("FIELD(priorite, 'haute', 'moyenne', 'basse')");
    }

    public function scopeByCanton($query, $cantonId)
    {
        if ($cantonId) {
            return $query->where('canton_id', $cantonId);
        }
        return $query;
    }
}
