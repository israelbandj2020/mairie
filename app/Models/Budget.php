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
        'libelle',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'ajoute_par',
    ];

    protected $casts = [
        'annee' => 'integer',
        'taille' => 'integer',
    ];

    public function ajoutePar()
    {
        return $this->belongsTo(User::class, 'ajoute_par');
    }

    public function scopeAnnuel($query)
    {
        return $query->where('type', 'annuel');
    }

    public function scopeSupplementaire($query)
    {
        return $query->where('type', 'supplementaire');
    }
}
