<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plainte extends Model
{
    protected $fillable = [
        'type_plainte',
        'nom',
        'prenom',
        'telephone',
        'description',
        'photo',
        'statut_validation',
        'cree_par',
    ];

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function getTypePlainteLabelAttribute(): string
    {
        return match ($this->type_plainte) {
            'executif' => 'Exécutif',
            'agent_mairie' => 'Agent de la mairie',
            'conseiller' => 'Conseiller',
            'autres' => 'Autres',
            default => $this->type_plainte,
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
}
