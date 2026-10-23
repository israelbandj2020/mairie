<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    public function besoins()
    {
        return $this->hasMany(Besoin::class, 'canton_id');
    }
}
