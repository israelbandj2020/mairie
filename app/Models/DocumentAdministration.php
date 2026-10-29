<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAdministration extends Model
{
    use HasFactory;

    protected $table = 'documents_administration';

    protected $fillable = [
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

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }
}
