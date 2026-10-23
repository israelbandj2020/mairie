<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalActivite extends Model
{
    use HasFactory;

    protected $table = 'journal_activites';

    protected $fillable = [
        'user_id',
        'action',
        'objet',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function enregistrer(string $action, string $objet, ?string $details = null): void
    {
        self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'objet' => $objet,
            'details' => $details,
        ]);
    }

    public function scopeByUser($query, $userId)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }

    public function scopeByAction($query, $action)
    {
        if ($action) {
            return $query->where('action', $action);
        }
        return $query;
    }

    public function scopeByPeriode($query, $debut, $fin)
    {
        if ($debut && $fin) {
            return $query->whereBetween('created_at', [$debut, $fin]);
        }
        return $query;
    }
}
