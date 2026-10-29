<?php

namespace App\Observers;

use App\Models\SessionDocument;
use App\Services\FichierService;
use Illuminate\Support\Facades\Storage;

class SessionDocumentObserver
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    /**
     * Handle the SessionDocument "deleted" event.
     */
    public function deleted(SessionDocument $sessionDocument): void
    {
        $this->fichierService->supprimer($sessionDocument->chemin);
    }
}
