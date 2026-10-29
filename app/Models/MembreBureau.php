<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembreBureau extends Model
{
    use HasFactory;

    protected $table = 'membres_bureau';

    protected $fillable = [
        'user_id',
        'role',
        'ordre',
    ];

    protected $casts = [
        'ordre' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByOrdre($query)
    {
        return $query->orderBy('ordre');
    }
}
