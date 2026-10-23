<?php

namespace App\Enums;

enum StatutCompte: string
{
    case EN_ATTENTE = 'en_attente';
    case VALIDE = 'valide';
    case SUSPENDU = 'suspendu';
}
