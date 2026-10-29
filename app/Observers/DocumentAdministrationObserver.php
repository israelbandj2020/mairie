<?php

namespace App\Observers;

use App\Models\DocumentAdministration;
use App\Services\FichierService;

class DocumentAdministrationObserver
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function deleted(DocumentAdministration $documentAdministration): void
    {
        $this->fichierService->supprimer($documentAdministration->chemin);
    }
}
