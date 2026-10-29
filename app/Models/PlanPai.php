<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPai extends Model
{
    use HasFactory;

    protected $table = 'plans_pai';

    protected $fillable = [
        'annee',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'cree_par',
    ];

    protected $casts = [
        'annee' => 'integer',
        'taille' => 'integer',
    ];

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }
}
