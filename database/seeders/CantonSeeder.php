<?php

namespace Database\Seeders;

use App\Models\Canton;
use Illuminate\Database\Seeder;

class CantonSeeder extends Seeder
{
    public function run(): void
    {
        $cantons = [
            'Gbatopé',
            'Davié',
            'Djagblé',
            'Kpomé',
            'Abobo',
            'Gblinvié',
            'Avéta',
        ];

        foreach ($cantons as $nom) {
            Canton::firstOrCreate(['nom' => $nom]);
        }
    }
}
