<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAdministration extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'chemin',
        'nom_original',
        'mime',
        'taille',
        'ajoute_par',
    ];

    protected $casts = [
        'taille' => 'integer',
    ];

    public function ajoutePar()
    {
        return $this->belongsTo(User::class, 'ajoute_par');
    }
}
