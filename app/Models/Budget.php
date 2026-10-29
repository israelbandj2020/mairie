<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee',
        'type',
        'montant',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'cree_par',
    ];

    protected $casts = [
        'annee' => 'integer',
        'montant' => 'decimal:2',
        'taille' => 'integer',
    ];

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'annuel' => 'Budget annuel',
            'supplementaire' => 'Budget supplémentaire',
            default => $this->type,
        };
    }
}
