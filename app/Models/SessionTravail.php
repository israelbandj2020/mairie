<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionTravail extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'nom',
        'date_session',
        'cree_par',
    ];

    protected $casts = [
        'date_session' => 'date',
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

    public function getStatutAttribute(): string
    {
        $aOrdreDuJour = $this->documents()->where('type', 'ordre_du_jour')->exists();
        $aOrdreDuJourValide = $this->documents()->where('type', 'ordre_du_jour_valide')->exists();
        $aCompteRendu = $this->documents()->where('type', 'compte_rendu')->exists();
        $aDecisions = $this->documents()->where('type', 'decision')->exists();

        if (!$aOrdreDuJour) {
            return 'Planifiée';
        }

        if ($aOrdreDuJour && !$aOrdreDuJourValide) {
            return 'Ordre du jour publié';
        }

        if ($aOrdreDuJourValide && !$aCompteRendu && !$aDecisions) {
            return 'Tenue';
        }

        if ($aCompteRendu && $aDecisions) {
            return 'Clôturée';
        }

        return 'Planifiée';
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
            return $query->whereYear('date_session', $annee);
        }
        return $query;
    }

    public function scopeByStatut($query, $statut)
    {
        if ($statut) {
            return $query->whereHas('documents', function ($q) use ($statut) {
                // Logique complexe à adapter selon le statut
            });
        }
        return $query;
    }
}
