<?php

namespace App\Observers;

use App\Models\Deliberation;
use App\Services\FichierService;

class DeliberationObserver
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function deleted(Deliberation $deliberation): void
    {
        $this->fichierService->supprimer($deliberation->chemin);
    }
}
