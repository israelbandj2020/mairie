<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Besoin extends Model
{
    use HasFactory;

    protected $table = 'besoins_prioritaires';

    protected $fillable = [
        'canton_id',
        'titre',
        'description',
        'priorite',
        'cree_par',
    ];

    public function canton()
    {
        return $this->belongsTo(Canton::class, 'canton_id');
    }

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function scopeByPriorite($query)
    {
        return $query->orderByRaw("FIELD(priorite, 'haute', 'moyenne', 'basse')");
    }

    public function scopeByCanton($query, $cantonId)
    {
        if ($cantonId) {
            return $query->where('canton_id', $cantonId);
        }
        return $query;
    }
}
