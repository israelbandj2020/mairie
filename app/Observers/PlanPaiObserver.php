<?php

namespace App\Observers;

use App\Models\PlanPai;
use App\Services\FichierService;

class PlanPaiObserver
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function deleted(PlanPai $planPai): void
    {
        $this->fichierService->supprimer($planPai->chemin);
    }
}
