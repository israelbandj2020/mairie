<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'fonction',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'valide_le' => 'datetime',
        ];
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getInitialesAttribute(): string
    {
        return strtoupper(substr($this->prenom, 0, 1) . substr($this->nom, 0, 1));
    }

    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function estValide(): bool
    {
        return $this->statut === 'valide';
    }

    public function validePar()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    public function comptesValides()
    {
        return $this->hasMany(User::class, 'valide_par');
    }

    public function sessionsTravail()
    {
        return $this->hasMany(SessionTravail::class, 'cree_par');
    }

    public function sessionDocuments()
    {
        return $this->hasMany(SessionDocument::class, 'ajoute_par');
    }

    public function deliberations()
    {
        return $this->hasMany(Deliberation::class, 'ajoute_par');
    }

    public function plansPai()
    {
        return $this->hasMany(PlanPai::class, 'ajoute_par');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'ajoute_par');
    }

    public function besoins()
    {
        return $this->hasMany(Besoin::class, 'cree_par');
    }

    public function documentsAdministration()
    {
        return $this->hasMany(DocumentAdministration::class, 'ajoute_par');
    }

    public function membreBureau()
    {
        return $this->hasOne(MembreBureau::class);
    }

    public function activites()
    {
        return $this->hasMany(JournalActivite::class, 'user_id');
    }
}
