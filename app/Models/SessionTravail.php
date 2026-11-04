<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionTravail extends Model
{
    use HasFactory;

    protected $table = 'sessions_travail';

    protected $fillable = [
        'numero',
        'nom',
        'date',
        'lieu',
        'statut',
        'cree_par',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function documents()
    {
        return $this->hasMany(SessionDocument::class, 'session_travail_id');
    }

    public function deliberations()
    {
        return $this->hasMany(Deliberation::class, 'session_travail_id');
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'planifiee' => 'Planifiée',
            'en_cours' => 'En cours',
            'terminee' => 'Terminée',
            'annulee' => 'Annulée',
            default => $this->statut,
        };
    }

    public function scopeSearch($query, $q)
    {
        if ($q) {
            return $query->where('nom', 'like', "%{$q}%")
                ->orWhere('numero', 'like', "%{$q}%");
        }
        return $query;
    }

    public function scopeByAnnee($query, $annee)
    {
        if ($annee) {
            return $query->whereYear('date', $annee);
        }
        return $query;
    }

    public function scopeByStatut($query, $statut)
    {
        if ($statut) {
            return $query->where('statut', $statut);
        }
        return $query;
    }

    public static function genererNumero($date)
    {
        $annee = date('Y', strtotime($date));
        $compteur = self::whereYear('date', $annee)->count() + 1;

        if ($compteur > 4) {
            throw new \Exception("Le maximum de 4 sessions par année a été atteint pour l'année {$annee}.");
        }

        return sprintf('%s-%02d', $annee, $compteur);
    }

    public static function getCompteurAnnee($annee = null)
    {
        $annee = $annee ?? date('Y');
        return self::whereYear('date', $annee)->count();
    }
}
