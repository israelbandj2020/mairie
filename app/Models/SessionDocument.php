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
}
