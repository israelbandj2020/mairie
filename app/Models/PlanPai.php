<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPai extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee',
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
}
